@extends('layouts.master')

@section('title', 'Portfolio')
@section('style')
@endsection
@section('breadcrumb')
    <div class="col-md-6 text-left">
        <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
            <li class="m-nav__item m-nav__item--home">
                <a href="" class="m-nav__link m-nav__link--icon">
                    <i class="m-nav__link-icon la la-home"></i>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Portfolio</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Detail</span>
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="tabs-wrapper">
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" data-area="#all" href="#/all">{{$portfolio->title}}</a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50" id="all_area">
        <div class="m-portlet__body">
            <form action="{{route('admin.portfolio.item.update', $portfolio->id)}}" id="submit_form" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="footer" class="form-control-label">Choose Category:</label>
                            <select name="category" id="category" class="category selectpicker" data-live-search="true" data-width="100%">
                                <option value="" disabled selected>Choose Category</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @foreach($category->approvedSubCategories as $subcat)
                                        <option value="{{$subcat->id}}">{{$category->name}} --> {{$subcat->name}}</option>
                                    @endforeach
                                @endforeach
                            </select>
                            <div class="form-control-feedback error-category"></div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="form-control-label">Title:</label>
                            <input type="title" class="form-control" name="title" id="title" value="{{$portfolio->title}}">
                            <div class="form-control-feedback error-title"></div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="form-control-label">Description:</label>
                            <textarea class="form-control m-input--square minh-100" name="description" id="description">{{$portfolio->description}}</textarea>
                            <div class="form-control-feedback error-description"></div>
                        </div>
                        <div class="form-group">
                            <table class="table table-bordered table-item-center">
                                <tbody id="image_area">
                                @foreach($portfolio->getMedia('image') as $key=>$image)
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control m-input--square" value="{{$image->getUrl()}}" readonly>
                                            <input type="hidden" name='oldItems[]' value="{{$image->id}}">
                                        </td>
                                        <td><img class='width-150' src="{{$image->getUrl()}}"/></td>
                                        <td><button class='btn btn-danger btn-sm delBtn'>X</button></td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <a href="javascript:void(0);" class="btn m-btn--square m-btn m-btn--custom btn-outline-info p-1" id="addImage">+ Add Image</a>
                            </table>
                        </div>
                        <div class="form-group">
                            <table class="table table-bordered table-item-center">
                                <tbody id="link_area">
                                @foreach($portfolio->getLinks() as $key1=>$link)
                                    <tr>
                                        <td><input type="url" name='links[]' class="form-control m-input--square" value="{{$link}}"></td>
                                        <td><button class='btn btn-danger btn-sm delBtn'>X</button></td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <a href="javascript:void(0);" class="btn m-btn--square m-btn m-btn--custom btn-outline-info p-1" id="addLink">+ Add External Video Link</a>
                            </table>
                        </div>
                        <div class="form-group">
                            <table class="table table-bordered table-item-center">
                                <tbody id="video_area">
                                @foreach($portfolio->getMedia('video') as $key2=>$video)
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control m-input--square" value="{{$video->getUrl()}}" readonly>
                                            <input type="hidden" name='oldItems[]' value="{{$video->id}}">
                                        </td>
                                        <td><button class='btn btn-danger btn-sm delBtn'>X</button></td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <a href="javascript:void(0);" class="btn m-btn--square m-btn m-btn--custom btn-outline-info p-1" id="addVideo">+ Upload Video</a>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="thumbnail" class="form-control-label">Thumbnail</label>
                            <input type="file" accept="image/*" class="form-control m-input--square" id="thumbnail" >
                            <div class="form-control-feedback error-thumbnail"></div>
                            <img id="thumbnail_image" class="maxw-100" src="{{$portfolio->getFirstMediaUrl("thumbnail")}}"/>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="featured" class="form-control-label">Featured?</label>
                                <div>
                                    <span class="m-switch m-switch--icon m-switch--info">
                                        <label>
                                            <input type="checkbox" checked name="featured" id="featured" @if($portfolio->featured) checked @endif>
                                            <span></span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="status" class="form-control-label">Approve?</label>
                                <div>
                                    <span class="m-switch m-switch--icon m-switch--info">
                                        <label>
                                            <input type="checkbox" checked name="status" id="status" @if($portfolio->status) checked @endif>
                                            <span></span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right mt-4">
                    <a href="{{route('admin.portfolio.item.index')}}" class="btn btn-outline-info m-btn m-btn--custom m-btn--square">Back</a>
                    <button type="submit" class="btn m-btn--square m-btn m-btn--custom btn-outline-success smtBtn">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{asset('assets/vendors/cropper/cropper.js')}}"></script>
    <script> var category = "{{$portfolio->category_id}}", portfolio_id = "{{$portfolio->id}}"; </script>
    <script src="{{asset('assets/js/admin/portfolio/itemEdit.js')}}"></script>
@endsection
