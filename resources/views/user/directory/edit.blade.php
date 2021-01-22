@extends('layouts.master')

@section('title', 'Directory Listing')
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
                    <span class="m-nav__link-text">Directory Listing</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Edit Listing</span>
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="tabs-wrapper">
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" data-area="#all" href="#/all">Edit Listing</a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50" id="all_area">
        <div class="m-portlet__body">
            <form action="{{route('user.directory.update', $listing->id)}}" id="submit_form" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row" x-data="{thumbnail:{{$listing->isProperty('thumbnail')? 'true':'false'}},featured:{{$listing->featured? 'true':'false'}},links:{{$listing->isProperty('links')? 'true':'false'}},tracking:{{$listing->isProperty('tracking')? 'true':'false'}},social:{{$listing->isProperty('social')? 'true':'false'}},image:{{$listing->isProperty('image')? 'true':'false'}},videos:{{$listing->isProperty('videos')? 'true':'false'}}}">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="footer" class="form-control-label">Choose Category:</label>
                            <select name="category" id="category" class="category" data-live-search="true" data-width="100%">
                                <option value="" disabled selected>Choose Category</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" @if($listing->category_id==$category->id) selected @endif data-tags="{{$category->approvedTags->pluck('id')}}">{{$category->name}}</option>
                                    @foreach($category->approvedSubCategories as $subcat)
                                        <option value="{{$subcat->id}}" @if($listing->category_id==$subcat->id) selected @endif data-tags="{{$category->approvedTags->pluck('id')}}">{{$category->name}} &rarr; {{$subcat->name}}</option>
                                    @endforeach
                                @endforeach
                            </select>
                            <div class="form-control-feedback error-category"></div>
                        </div>
                        <div class="form-group m-form__group">
                            <label for="tag">Select Tags</label><br>
                            <select class="form-control" id="tag" name="tags[]" multiple>
                                <option></option>
                                @foreach($tags as $tag)
                                    <option value="{{$tag->id}}" @if(in_array($tag->id, $listing->tags->pluck("id")->toArray())) selected @endif>{{$tag->name}}</option>
                                @endforeach
                            </select>
                            <div class="form-control-feedback error-tags"></div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="form-control-label">Title:</label>
                            <input type="text" class="form-control" name="title" id="title" value="{{$listing->title}}">
                            <div class="form-control-feedback error-title"></div>
                        </div>
                        <div class="form-group">
                            <label for="url" class="form-control-label">Website Link URL:</label>
                            <input type="text" class="form-control" name="url" id="url" value="{{$listing->url}}">
                            <div class="form-control-feedback error-url"></div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="form-control-label">Description:</label>
                            <textarea class="form-control m-input--square minh-100" name="description" id="description">{{$listing->description}}</textarea>
                            <div class="form-control-feedback error-description"></div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group" x-show="thumbnail">
                            <label for="thumbnail" class="form-control-label">Thumbnail</label>
                            <input type="file" accept="image/*" class="form-control m-input--square" id="thumbnail" >
                            <div class="form-control-feedback error-thumbnail"></div>
                            <img id="thumbnail_image" class="w-100" src="{{$listing->getFirstMediaUrl("thumbnail")}}"/>
                        </div>
                        <div class="form-group" x-show="image">
                            <table class="table table-bordered table-item-center">
                                <tbody id="image_area">
                                    @foreach($listing->getMedia('image') as $key=>$image)
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control m-input--square" value="{{$image->getUrl()}}" readonly>
                                                <input type="hidden" name='oldItems[]' value="{{$image->id}}">
                                            </td>
                                            <td class="text-center">
                                                <figure data-href="{{$image->getUrl()}}" class="width-150 progressive replace m-auto">
                                                    <img class='width-150 preview' src="{{$image->getUrl('thumb')}}"/>
                                                </figure>
                                            </td>
                                            <td><button class='btn btn-danger btn-sm delBtn'>X</button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <a href="javascript:void(0);" class="btn m-btn--square m-btn m-btn--custom btn-outline-info p-1" id="addImage">+ Add Image</a>
                            </table>
                        </div>
                        <div class="form-group" x-show="links">
                            <table class="table table-bordered table-item-center">
                                <tbody id="link_area">
                                    @foreach($listing->getLinks() as $key1=>$link)
                                        <tr>
                                            <td><input type="url" name='links[]' class="form-control m-input--square" value="{{$link}}"></td>
                                            <td><button class='btn btn-danger btn-sm delBtn'>X</button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <a href="javascript:void(0);" class="btn m-btn--square m-btn m-btn--custom btn-outline-info p-1" id="addLink">+ Add External Video Link</a>
                            </table>
                        </div>
                        <div class="form-group" x-show="videos">
                            <table class="table table-bordered table-item-center">
                                <tbody id="video_area">
                                    @foreach($listing->getMedia('video') as $key2=>$video)
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
                        <div class="form-group">
                            <label for="example_input_full_name">Choose Gallery Order:</label>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="m-option">
                                        <span class="m-option__control">
                                            <span class="m-radio m-radio--brand m-radio--check-bold">
                                                <input type="radio" name="order" value="1" @if($listing->order==1) checked @endif>
                                                <span></span>
                                            </span>
                                        </span>
                                        <span class="m-option__label">
                                            <span class="m-option__head">
                                                <span class="m-option__title">
                                                    Image Gallery

                                                    <hr/>

                                                    Video Gallery
                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                <div class="col-lg-6">
                                    <label class="m-option">
                                        <span class="m-option__control">
                                            <span class="m-radio m-radio--brand m-radio--check-bold">
                                                <input type="radio" name="order" value="0" @if($listing->order==0) checked @endif>
                                                <span></span>
                                            </span>
                                        </span>
                                        <span class="m-option__label">
                                            <span class="m-option__head">
                                                <span class="m-option__title">
                                                     Video Gallery

                                                    <hr/>

                                                     Image Gallery

                                                </span>
                                            </span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <label for="featured" class="form-control-label">Featured?</label>
                                <div>
                                    <span class="m-switch m-switch--icon m-switch--info">
                                        <label>
                                            <input type="checkbox"  name="featured" id="featured" x-bind:checked="featured" x-on:click="featured=!featured">
                                            <span></span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="new" class="form-control-label">New?</label>
                                <div>
                                    <span class="m-switch m-switch--icon m-switch--info">
                                        <label>
                                            <input type="checkbox"  name="new" id="new" {{$listing->new? 'checked':''}}>
                                            <span></span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="text-right mt-4">
                    <a href="{{route('user.directory.index')}}" class="btn btn-outline-info m-btn m-btn--custom m-btn--square">Back</a>
                    <button type="submit" class="btn m-btn--square m-btn m-btn--custom btn-outline-success smtBtn">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{asset('assets/vendors/cropper/cropper.js')}}"></script>
    <script src="{{asset('assets/vendors/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('assets/js/user/directory/edit.js')}}"></script>
@endsection
