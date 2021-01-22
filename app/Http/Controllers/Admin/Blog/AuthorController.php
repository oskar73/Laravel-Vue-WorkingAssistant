<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Admin\AdminController;
use App\Models\BlogAuthor;

class AuthorController extends AdminController
{
    public function __construct(BlogAuthor $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (request()->wantsJson()) {
            return $this->model->getAuthorDatatable();
        }

        return view(self::$viewDir.'blog.author');
    }
}
