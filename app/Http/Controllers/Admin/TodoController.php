<?php

namespace App\Http\Controllers\Admin;

use App\Models\AppointmentList;
use App\Models\BlogAdsListing;
use App\Models\BlogComment;
use App\Models\DirectoryAdsListing;
use App\Models\DirectoryListing;
use App\Models\Module\BlogPost;
use App\Models\Review;
use App\Models\SiteAdsListing;
use App\Models\Ticket;
use App\Models\UserForm;

class TodoController extends AdminController
{
    public $types;

    public static $typeNames;

    public function __construct()
    {
        $types = [];

//        $typeNames = ['purchaseForm'];
//        if(tenant()->hasAnyPublishModule(["simple_blog", "advanced_blog"]))
//        {
//            array_push($typeNames, "blogComment");
//            if(tenant()->hasAnyPublishModule(["advanced_blog"]))
//            {
//                array_push($typeNames, "blogPost");
//            }
//        }
//        if(tenant()->hasAnyPublishModule(["blogAds"]))
//        {
//            array_push($typeNames, "blogAdsListing");
//        }
//        if(tenant()->hasAnyPublishModule(["siteAds"]))
//        {
//            array_push($typeNames, "siteAdsListing");
//        }
//        if(tenant()->hasAnyPublishModule(["directory"]))
//        {
//            array_push($typeNames, "directoryListing");
//            if(tenant()->hasAnyPublishModule(["directoryAds"]))
//            {
//                array_push($typeNames, "directoryAdsListing");
//            }
//        }
//        if(tenant()->hasAnyPublishModule(["ecommerce"]))
//        {
//            array_push($typeNames, "ecommerceProduct");
//        }
//        if(tenant()->hasAnyPublishModule(["review"]))
//        {
//            array_push($typeNames, "review");
//        }
//        if(tenant()->hasAnyPublishModule(["appointment"]))
//        {
//            array_push($typeNames, "appointment");
//        }
//        if(tenant()->hasAnyPublishModule(["ticket"]))
//        {
//            array_push($typeNames, "ticket");
//        }
//        self::$typeNames = $typeNames;
//
//        foreach(self::$typeNames as $typeName)
//        {
//            $types[$typeName] = $this->getCounts($typeName)?? null;
//        }

        $this->types = $types;
    }

    public function index()
    {
        $types = $this->types;
        foreach ($types as $key => $type) {
            if ($type) {
                return redirect()->route('admin.todo.detail', $key);
            }
        }

        return view(self::$viewDir.'todo.index');
    }

    public function getTodoCount()
    {
        return $this->jsonSuccess(collect((object) $this->types)->sum());
    }

    public function detail($type)
    {
        if (! in_array($type, self::$typeNames)) {
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
        $types = $this->types;

        return view(self::$viewDir.'todo.detail', compact('type', 'types', 'count'));
    }

    public function getTodos($type)
    {
        $result = '';
        $perPage = 10;
        switch ($type) {
            case 'blogPost':
                $todos = BlogPost::with('user')->where('status', 'pending')->oldest()->paginate($perPage);
                $result = view('components.admin.todo.blogPost', compact('todos'))->render();
                break;
            case 'blogComment':
                $todos = BlogComment::with('post', 'user')->where('status', 'pending')->oldest()->paginate($perPage);
                $result = view('components.admin.todo.blogComment', compact('todos'))->render();
                break;
            case 'blogAdsListing':
                $todos = BlogAdsListing::with('user', 'spot')->where('status', 'pending')->oldest()->paginate($perPage);
                $result = view('components.admin.todo.blogAdsListing', compact('todos'))->render();
                break;
            case 'siteAdsListing':
                $todos = SiteAdsListing::with('user', 'spot')->where('status', 'pending')->oldest()->paginate($perPage);
                $result = view('components.admin.todo.siteAdsListing', compact('todos'))->render();
                break;
            case 'directoryAdsListing':
                $todos = DirectoryAdsListing::with('user', 'spot')->where('status', 'pending')->oldest()->paginate($perPage);
                $result = view('components.admin.todo.directoryAdsListing', compact('todos'))->render();
                break;
            case 'directoryListing':
                $todos = DirectoryListing::with('user')->where('status', 'pending')->oldest()->paginate($perPage);
                $result = view('components.admin.todo.directoryListing', compact('todos'))->render();
                break;
            case 'appointment':
                $todos = AppointmentList::with('user')->where('status', 'pending')->oldest()->paginate($perPage);
                $result = view('components.admin.todo.appointment', compact('todos'))->render();
                break;
            case 'ticket':
                $todos = Ticket::with('user')->where('parent_id', 0)->where('status', 'opened')->oldest()->paginate($perPage);
                $result = view('components.admin.todo.ticket', compact('todos'))->render();
                break;
            case 'purchaseForm':
                $todos = UserForm::with('user')->where('status', 'filled')->oldest()->paginate($perPage);
                $result = view('components.admin.todo.purchaseForm', compact('todos'))->render();
                break;
            case 'review':
                $todos = Review::with('user', 'product')->where('status', 0)->oldest()->paginate($perPage);
                $result = view('components.admin.todo.review', compact('todos'))->render();
                break;
        }

        return $result;
    }

    public function getCounts($type)
    {
        $result = 0;
        switch ($type) {
            case 'blogPost':
                $result = BlogPost::where('status', 'pending')->count();
                break;
            case 'blogComment':
                $result = BlogComment::where('status', 'pending')->count();
                break;
            case 'blogAdsListing':
                $result = BlogAdsListing::where('status', 'pending')->count();
                break;
            case 'siteAdsListing':
                $result = SiteAdsListing::where('status', 'pending')->count();
                break;
            case 'directoryAdsListing':
                $result = DirectoryAdsListing::where('status', 'pending')->count();
                break;
            case 'directoryListing':
                $result = DirectoryListing::where('status', 'pending')->count();
                break;
            case 'appointment':
                $result = AppointmentList::where('status', 'pending')->count();
                break;
            case 'ticket':
                $result = Ticket::where('parent_id', 0)->where('status', 'opened')->count();
                break;
            case 'purchaseForm':
                $result = UserForm::where('status', 'filled')->count();
                break;
            case 'review':
                $result = Review::where('status', 0)->count();
                break;
        }

        return $result;
    }
}
