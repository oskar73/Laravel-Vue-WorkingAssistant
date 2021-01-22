<?php

namespace App\Http\Controllers\Admin\Email;

use App\Http\Controllers\Admin\AdminController;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends AdminController
{
    public function __construct(Subscriber $model)
    {
        $this->model = $model;
    }

    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            return $this->model->getDatatable(request()->get('status'));
        }

        return view(self::$viewDir.'email.subscriber');
    }
}
