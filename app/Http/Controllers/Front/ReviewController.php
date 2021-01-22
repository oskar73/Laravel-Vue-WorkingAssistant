<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BlogPackage;
use App\Models\DirectoryListing;
use App\Models\DirectoryPackage;
use App\Models\Module\EcommerceProduct;
use App\Models\NotificationTemplate;
use App\Models\Portfolio;
use App\Models\Review;
use Illuminate\Http\Request;
use Validator;

class ReviewController extends Controller
{
    public $model;

    public function __construct()
    {
        $this->model = new Review();
    }

    public function index(Request $request)
    {
        try {
            $item = $this->getModel($request->type)
                ->where('id', $request->model_id)
                ->frontVisible()
                ->with('approvedReviews.user')
                ->first();

            $reviews = $item->approvedReviews()->latest()->paginate(2);
            $count = $item->approvedReviews->count();
            $rating = $item->avgRating();
            $data = view('components.front.reviewItem', compact('reviews'))->render();

            return response()->json([
                'status' => 1,
                'data' => $data,
                'count' => $count,
                'avgRating' => $rating,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }

    public function storeRule($request)
    {
        $rule['type'] = 'required|in:lacarte,service,plugin,portfolio,package,readymade,module,blogPackage,directory,ecommerce';
        if (! \Auth::check()) {
            $rule['name'] = 'required|string|max:45';
            $rule['email'] = 'required|email|max:45';
            $rule['model_id'] = 'required|integer|unique:reviews,model_id,NULL,id,email,'.$request->email.',model,'.$request->type.',web_id,'.tenant('id');
        } else {
            $rule['model_id'] = 'required|integer|unique:reviews,model_id,NULL,id,user_id,'.user()->id.',model,'.$request->type.',web_id,'.tenant('id');
        }
        $rule['rating'] = 'required|integer:in:1,2,3,4,5';
        $rule['comment'] = 'required|string|min:5|max:600';

        return $rule;
    }

    public function getModel($type)
    {
        switch ($type) {
            case 'blogPackage':
                $model = BlogPackage::query();
                break;
            case 'portfolio':
                $model = Portfolio::query();
                break;
            case 'directory':
                $model = DirectoryListing::query();
                break;
            case 'directoryPackage':
                $model = DirectoryPackage::query();
                break;
            case 'ecommerce':
                $model = EcommerceProduct::query();
                break;
        }

        return $model;
    }

    public function store(Request $request)
    {
        try {
            $customMsg = [
                'model_id.unique' => 'You already left the review to this product.',
            ];
            $validation = Validator::make($request->all(), $this->storeRule($request), $customMsg);
            if ($validation->fails()) {
                return response()->json(['status' => 0, 'data' => $validation->errors()]);
            }

            $model = $this->getModel($request->type)
                ->where('id', $request->model_id)
                ->frontVisible()
                ->firstorfail();

            $review = $model->reviews()->create([
                'web_id' => tenant('id'),
                'rating' => $request->rating,
                'comment' => $request->comment,
                'user_id' => user()->id ?? null,
                'model' => $request->type,
                'name' => $request->name,
                'email' => $request->email,
            ]);

//            $this->sendNotification($review);

            return response()->json([
                'status' => 1,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'data' => [json_encode($e->getMessage())],
            ]);
        }
    }

    public function sendNotification($review)
    {
        $notification = new NotificationTemplate();
        $data['url'] = url()->previous().'#review';

        $name = $review->user->name ?? $review->name;
        $email = $review->user->email ?? $review->email;

        $data['detail'] = 'Customer Name: '.$name.' <br> Customer Email: '.$email."<br> Rating: {$review->rating} <br> Comment: {$review->comment}";
        $data['slug'] = $notification::REVIEW_NOTIFY;
        $notification->sendNotificationToAdmin($data);
    }
}
