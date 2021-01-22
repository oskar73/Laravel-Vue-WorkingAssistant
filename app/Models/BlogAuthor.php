<?php

namespace App\Models;

use App\Models\Module\BlogPost;
use Yajra\DataTables\DataTables;

class BlogAuthor extends User
{
    public function getAuthorDatatable()
    {
        $ids = BlogPost::pluck('user_id')->toArray();
        $authors = User::whereIn('id', $ids)->with('visiblePosts', 'followers');

        return Datatables::of($authors)->addColumn('posts_count', function ($row) {
            return $row->visiblePosts->count();
        })->addColumn('followers_count', function ($row) {
            return $row->followers->count();
        })->addColumn('claps', function ($row) {
            return $row->visiblePosts->sum('favoriters_count');
        })->editColumn('created_at', function ($row) {
            return $row->created_at;
        })->addColumn('action', function ($row) {
            return '
                    <a href="'.route('admin.userManage.detail', $row->id).'" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill tooltip_3" title="Detail">
                            <i class="la la-eye"></i>
                    </a>';
        })->rawColumns(['action'])
            ->make(true);
    }
}
