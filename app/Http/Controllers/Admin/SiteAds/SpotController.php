<?php

namespace App\Http\Controllers\Admin\SiteAds;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Page;
use App\Models\SiteAdsSpot;
use App\Models\SiteAdsType;
use Illuminate\Http\Request;
use Validator;

class SpotController extends AdminController
{
    public function __construct(SiteAdsSpot $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            $pages = Page::withCount('spots')
                ->whereIn('type', ['box', 'builder'])
                ->where('status', 1)
                ->orderBy('name')
                ->get(['id', 'name', 'url']);

            $types = SiteAdsType::withCount('spots')
                ->where('status', 1)
                ->orderBy('name')
                ->get(['id', 'name']);

            $spots = $this->model->with('approvedPrices', 'parentType', 'page')->get();

            $data1 = view('components.admin.siteAdsPlace', [
                'pages' => $pages,
                'types' => $types,
                'spots' => $spots,
                'selector' => 'datatable-all',
            ])->render();

            $data2 = view('components.admin.siteAdsSpot', [
                'spots' => $spots,
                'display' => 1,
                'selector' => 'datatable-spots',
            ])->render();

            $count['all'] = 1;
            $count['all'] = $pages->count() * $types->count();
            $count['spots'] = $spots->count();

            return response()->json([
                'status' => 1,
                'all' => $data1,
                'spots' => $data2,
                'count' => $count,
            ]);
        }

        return view(self::$viewDir.'siteAds.spot');
    }

    public function page($page_id, $type_id)
    {
        $page = Page::whereIn('type', ['box', 'builder'])
            ->whereId($page_id)
            ->where('status', 1)
            ->firstorfail(['id', 'name']);

        $type = SiteAdsType::where('status', 1)
            ->whereId($type_id)
            ->firstorfail(['id', 'name', 'width', 'height']);

        $spots = $this->model->with('page', 'approvedPrices', 'parentType')
            ->where('page_id', $page_id)
            ->where('type_id', $type_id)
            ->get();

        $selector = 'datatable-spots';

        return view(self::$viewDir.'siteAds.page', compact('spots', 'selector', 'page', 'type'));
    }

    public function create($page_id, $type_id)
    {
        $page = Page::whereIn('type', ['box', 'builder'])
            ->where('status', 1)
            ->whereId($page_id)
            ->firstorfail(['id', 'name', 'url']);

        $type = SiteAdsType::where('status', 1)
            ->whereId($type_id)
            ->firstorfail(['id', 'name', 'width', 'height']);

        return view(self::$viewDir.'siteAds.spotCreate', [
            'page' => $page,
            'type' => $type,
        ]);
    }

    public function store(Request $request, $page_id, $type_id)
    {
        try {
            $validation = Validator::make(
                $request->all(),
                $this->model->createRule(),
                $this->model::CUSTOM_VALIDATION_MESSAGE
            );

            if ($validation->fails()) {
                return response()->json([
                    'status' => 0,
                    'data' => $validation->errors(),
                ]);
            }
            $page = Page::whereIn('type', ['box', 'builder'])
                ->where('status', 1)
                ->whereId($page_id)
                ->firstorfail();

            $type = SiteAdsType::where('status', 1)
                ->whereId($type_id)
                ->firstorfail();

            $spot = $this->model->storeItem($request, $page, $type);
            $url = route('admin.siteAds.spot.edit', $spot->id).'#/default';

            return response()->json([
                'status' => 1,
                'data' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }

    public function edit($id)
    {
        $spot = $this->model->findorfail($id);
        if (request()->wantsJson()) {
            $prices = $spot->prices;
            $view = view('components.admin.siteAdsPrice', compact('prices'))->render();

            return response()->json([
                'status' => 1,
                'data' => $view,
            ]);
        }

        return view(self::$viewDir.'siteAds.spotEdit', compact('spot'));
    }

    public function editPosition($id)
    {
        $spot = $this->model->findorfail($id);
        $page = $spot->page;
        if ($page == null) {
            return back()->with('error', 'Sorry, that page is deleted!');
        }
        $data = optional($page->data);

        $position_id = $spot->position_id ?? guid();
        if ($page->type == 'box') {
            return view(self::$viewDir.'siteAds.spotPositionBox', compact('spot', 'page', 'data', 'position_id'));
        } elseif ($page->type == 'builder') {
            return view(self::$viewDir.'siteAds.spotPositionBuilder', compact('spot', 'page', 'data', 'position_id'));
        } else {
            abort(404);
        }
    }

    public function getAds(Request $request)
    {
        $page = Page::whereIn('type', ['builder', 'box'])
            ->whereId($request->page_id)
            ->firstorfail();

        $spots = $this->model->with('approvedListings.events', 'gag.media', 'approvedListings.media', 'parentType')
            ->wherePageId($page->id)
            ->get();

        $result = [];

        foreach ($spots as $spot) {
            $result[] = $spot->getAdminFrame();
        }

        return response()->json([
            'status' => 1,
            'data' => $result,
        ]);
    }

    public function rule($page)
    {
        if ($page->type == 'box') {
            $rule['sHTML'] = 'required';
        } else {
            $rule['inpHtml'] = 'required';
        }

        return $rule;
    }

    public function updatePosition(Request $request, $id)
    {
        $spot = $this->model->findorfail($id);
        $page = $spot->page;

        $validation = Validator::make($request->all(), $this->rule($page));

        if ($validation->fails()) {
            return response()->json([
                'status' => 0,
                'data' => $validation->errors(),
            ]);
        }
        if ($page->type == 'builder') {
            $page->content = $request->inpHtml;
        } else {
            $page->mainCss = $request->sMainCss;
            $page->sectionCss = $request->sSectionCss;
            $page->content = $request->sHTML;
        }
        $page->save();

        $spot->position_id = $request->position_id;
        $spot->save();

        return response()->json(['status' => 1, 'page' => $request]);
    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make(
            $request->all(),
            $this->model->createRule(0),
            $this->model::CUSTOM_VALIDATION_MESSAGE
        );

        if ($validation->fails()) {
            return response()->json([
                'status' => 0,
                'data' => $validation->errors(),
            ]);
        }

        $spot = $this->model->findorfail($id)
            ->updateItem($request);

        if (! $spot->gag()->exists()) {
            $url = route('admin.siteAds.spot.edit', $spot->id).'#/price';
        } else {
            $url = '#';
        }

        return response()->json([
            'status' => 1,
            'data' => $url,
        ]);
    }

    public function createPrice(Request $request, $id)
    {
        try {
            $validation = Validator::make(
                $request->all(),
                $this->model->createPriceRule($request)
            );
            if ($validation->fails()) {
                return response()->json(['status' => 0, 'data' => $validation->errors()]);
            }

            $price = $this->model->findorfail($id)
                ->createPrice($request);

            return response()->json([
                'status' => 1,
                'data' => $price,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }

    public function deletePrice(Request $request, $id)
    {
        try {
            $price = $this->model->find($id)
                ->prices()
                ->where('id', $request->id)
                ->firstorfail();

            $price->delete();

            return response()->json([
                'status' => 1,
                'data' => $id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }

    public function updateListing(Request $request, $id)
    {
        try {
            $spot = $this->model->findorfail($id);

            $validation = Validator::make(
                $request->all(),
                $spot->updateListingRule($request)
            );

            if ($validation->fails()) {
                return response()->json(['status' => 0, 'data' => $validation->errors()]);
            }

            $spot->updateListing($request);

            if (! $spot->prices->count()) {
                $url = route('admin.siteAds.spot.edit', $spot->id).'#/price';
            } else {
                $url = '#';
            }

            return response()->json([
                'status' => 1,
                'data' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }

    public function switchSpot(Request $request)
    {
        try {
            $action = $request->action;

            $listings = $this->model->whereIn('id', $request->ids)->get();

            if ($action === 'active') {
                $listings->each->update(['status' => 1]);
            } elseif ($action === 'inactive') {
                $listings->each->update(['status' => 0]);
            } elseif ($action === 'featured') {
                $listings->each->update(['featured' => 1]);
            } elseif ($action === 'unfeatured') {
                $listings->each->update(['featured' => 0]);
            } elseif ($action === 'visible') {
                $listings->each->update(['sponsored_visible' => 1]);
            } elseif ($action === 'invisible') {
                $listings->each->update(['sponsored_visible' => 0]);
            } elseif ($action === 'new') {
                $listings->each->update(['new' => 1]);
            } elseif ($action === 'undonew') {
                $listings->each->update(['new' => 0]);
            } elseif ($action === 'delete') {
                $listings->each->delete();
            }

            return response()->json(['status' => 1]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }
}
