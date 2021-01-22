<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Facades\DataTables;

class BizinaEmailTemplate extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';

    protected $table = 'email_templates';

    public function category()
    {
        return $this->belongsTo(BizinaEmailCategory::class, 'category_id')->withDefault();
    }

    public function media()
    {
        return $this->morphMany(BizinaMedia::class, 'media', 'model_type', 'model_id');
    }

    public function getFirstMediaUrl($collection)
    {
        return $this->media->where('collection_name', $collection)->first();
    }

    public function getDatatable()
    {
        $templates = $this::with('category', 'media')->where('status', 1);

        return Datatables::of($templates)->addColumn('category', function ($row) {
            return $row->category->name;
        })->addColumn('image', function ($row) {
            return $row->getFirstMediaUrl('thumbnail');
        })->addColumn('action', function ($row) {
            return '<a href="'.route('admin.email.template.viewOnlineTemplate', $row->slug).'" class="btn btn-outline-primary btn-sm m-1	p-2 m-btn m-btn--icon previewBtn">
                        <span>
                            <i class="la la-eye"></i>
                            <span>View Template</span>
                        </span>
                    </a>
                    <a href="#" class="btn btn-outline-success btn-sm m-1	p-2 m-btn m-btn--icon saveBtn" data-slug="'.$row->slug.'" data-name="'.$row->name.'" data-description="'.$row->description.'">
                        <span>
                            <i class="la la-arrow-down"></i>
                            <span>Save this</span>
                        </span>
                    </a>';
        })->rawColumns(['status', 'category', 'action'])->make(true);
    }
}
