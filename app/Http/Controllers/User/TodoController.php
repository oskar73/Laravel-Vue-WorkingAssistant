<?php

namespace App\Http\Controllers\User;

use App\Models\BlogAdsListing;
use App\Models\DirectoryAdsListing;
use App\Models\DirectoryListing;
use App\Models\SiteAdsListing;
use App\Models\Ticket;
use App\Models\UserBlogPackage;
use App\Models\UserDirectoryPackage;
use App\Models\UserForm;
use App\Models\UserMeeting;

class TodoController extends UserController
{
    public function index()
    {
        $types = $this->getTypes();
        foreach ($types as $key => $type) {
            if ($type) {
                return redirect()->route('user.todo.detail', $key);
            }
        }

        return view(self::$viewDir.'todo.index');
    }

    public function getTodoCount()
    {
        return $this->jsonSuccess(collect((object) $this->getTypes())->sum());
    }

    public function detail($type)
    {
        if (! in_array($type, $this->getTypes())) {
            abort(404);
        }

        $count = $this->getCounts($type);
        if ($count == 0) {
            abort(404);
        }

        if (request()->wantsJson()) {
            $todos = $this->getTodos($type);

            return $this->jsonSuccess($todos);
        }
        $types = $this->getTypes();

        return view(self::$viewDir.'todo.detail', compact('type', 'types', 'count'));
    }

    public function getTypes()
    {
        $types = [];
        $typeNames = ['purchaseForm'];
        if (tenant()->hasAnyPublishModule(['advanced_blog'])) {
            array_push($typeNames, 'blogPost');
        }
        if (tenant()->hasAnyPublishModule(['blogAds'])) {
            array_push($typeNames, 'blogAdsListing');
        }
        if (tenant()->hasAnyPublishModule(['siteAds'])) {
            array_push($typeNames, 'siteAdsListing');
        }
        if (tenant()->hasAnyPublishModule(['directory'])) {
            array_push($typeNames, 'directoryListing');
            if (tenant()->hasAnyPublishModule(['directoryAds'])) {
                array_push($typeNames, 'directoryAdsListing');
            }
        }
        if (tenant()->hasAnyPublishModule(['ecommerce'])) {
            array_push($typeNames, 'ecommerceProduct');
        }
        if (tenant()->hasAnyPublishModule(['appointment'])) {
            array_push($typeNames, 'appointment');
        }
        if (tenant()->hasAnyPublishModule(['ticket'])) {
            array_push($typeNames, 'ticket');
        }
        foreach ($typeNames as $typeName) {
            $types[$typeName] = $this->getCounts($typeName) ?? null;
        }

        return $types;
    }

    public function getTodos($type)
    {
        $result = '';
        $perPage = 20;
        switch ($type) {
            case 'blogPost':
                $todos = UserBlogPackage::where('status', 'active')->my()->oldest()->paginate($perPage);
                $result = view('components.user.todo.blogPost', compact('todos'))->render();
                break;
            case 'blogAdsListing':
                $todos = BlogAdsListing::with('spot')->whereIn('status', ['paid', 'denied'])->my()->oldest()->paginate($perPage);
                $result = view('components.user.todo.blogAdsListing', compact('todos'))->render();
                break;
            case 'siteAdsListing':
                $todos = SiteAdsListing::with('spot')->whereIn('status', ['paid', 'denied'])->my()->oldest()->paginate($perPage);
                $result = view('components.user.todo.siteAdsListing', compact('todos'))->render();
                break;
            case 'directoryListing':
                $todos = UserDirectoryPackage::where('status', 'active')->my()->oldest()->paginate($perPage);
                $result = view('components.user.todo.directoryListing', compact('todos'))->render();
                break;
            case 'directoryAdsListing':
                $todos = DirectoryAdsListing::with('spot')->whereIn('status', ['paid', 'denied'])->my()->oldest()->paginate($perPage);
                $result = view('components.user.todo.directoryAdsListing', compact('todos'))->render();
                break;
            case 'appointment':
                $todos = UserMeeting::with('model')->where('status', 'active')->my()->oldest()->paginate($perPage);
                $result = view('components.user.todo.appointment', compact('todos'))->render();
                break;
            case 'ticket':
                $todos = Ticket::where('parent_id', 0)->my()->where('status', 'answered')->oldest()->paginate($perPage);
                $result = view('components.user.todo.ticket', compact('todos'))->render();
                break;
            case 'purchaseForm':
                $todos = UserForm::with('model')->whereIn('status', ['need to fill', 'need revision'])->my()->oldest()->paginate($perPage);
                $result = view('components.user.todo.purchaseForm', compact('todos'))->render();
                break;
        }

        return $result;
    }

    public function getCounts($type)
    {
        $result = 0;
        switch ($type) {
            case 'blogPost':
                $result = UserBlogPackage::where('status', 'active')->my()->get()->sum('remain_post');
                break;
            case 'blogAdsListing':
                $result = BlogAdsListing::whereIn('status', ['paid', 'denied'])->my()->count();
                break;
            case 'siteAdsListing':
                $result = SiteAdsListing::whereIn('status', ['paid', 'denied'])->my()->count();
                break;
            case 'directoryListing':
                $result = DirectoryListing::whereIn('status', ['paid', 'denied'])->my()->count();
                break;
            case 'directoryAdsListing':
                $result = DirectoryAdsListing::whereIn('status', ['paid', 'denied'])->my()->count();
                break;
            case 'appointment':
                $result = UserMeeting::where('status', 'active')->my()->get()->sum('available_number');
                break;
            case 'ticket':
                $result = Ticket::where('parent_id', 0)->my()->where('status', 'answered')->count();
                break;
            case 'purchaseForm':
                $result = UserForm::whereIn('status', ['need to fill', 'need revision'])->my()->count();
                break;
        }

        return $result;
    }
}
