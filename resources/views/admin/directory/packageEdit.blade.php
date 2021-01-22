@extends('layouts.master')

@section('title', 'Directory Listing Package')
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
                    <span class="m-nav__link-text">Package</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Edit</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-6 text-right">
        <a href="{{route('admin.directory.package.index')}}" class="btn btn-outline-info m-btn m-btn--custom m-btn--square">Back</a>
    </div>
@endsection

@section('content')
    <div class="tabs-wrapper">
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" data-area="#all" href="#/all">Package Detail</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#price" href="#/price">Set Price</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#meeting" href="#/meeting">Meeting and Attach Form</a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50" id="all_area">
        <div class="m-portlet__body">
            <form action="{{route('admin.directory.package.update', $item->id)}}" id="submit_form" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="form-control-label">
                                Name:

                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="This is package name."
                                ></i>
                            </label>
                            <input type="text" class="form-control" name="name" id="name" value="{{$item->name}}">
                            <div class="form-control-feedback error-name"></div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="form-control-label">
                                Description:

                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="This is description about package. Optional."
                                ></i>
                            </label>
                            <textarea class="form-control m-input--square minh-100 white-space-pre-line" name="description" id="description">{{$item->description}}</textarea>
                            <div class="form-control-feedback error-description"></div>
                        </div>

                        <h5>Features</h5>
                        <hr>
                        <div class="row" x-data="{unlimit:'{{$item->listing_limit==-1?1:0}}'}">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="listing_number" class="form-control-label">
                                        Listing limit number:

                                        <i class="la la-info-circle tipso2"
                                           data-tipso-title="What is this?"
                                           data-tipso="This is directory listing limit number that users can put using this package."
                                        ></i>
                                    </label>
                                    <input type="number" class="form-control" name="listing_limit" id="listing_limit" x-bind:disabled="unlimit==1" value="{{$item->listing_limit!=-1?$item->listing_limit:''}}">
                                    <div class="form-control-feedback error-listing_number"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <br>
                                <br>
                                <label class="m-checkbox m-checkbox--state-success">
                                    <input type="checkbox" name="unlimit" x-on:click="unlimit=unlimit==1?0:1" x-bind:checked="unlimit==1">
                                    Set Unlimit Listing Number

                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="If you check this field, it will give unlimited listing privilege to users"
                                    ></i>
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="m-checkbox m-checkbox--state-success">
                                    <input type="checkbox" name="allow_thumbnail" {{optional($item->property)['thumbnail']==1? 'checked':''}}>
                                    Allow to put thumbnail

                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="This will allow for users to put their image"
                                    ></i>
                                    <span></span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="m-checkbox m-checkbox--state-success">
                                    <input type="checkbox" name="allow_social" {{optional($item->property)['social']==1? 'checked':''}}>
                                    Allow to put social media links

                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="This will allow for users to put their social media link"
                                    ></i>
                                    <span></span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="m-checkbox m-checkbox--state-success">
                                    <input type="checkbox" name="allow_featured" {{optional($item->property)['featured']==1? 'checked':''}}>
                                    Allow featured listings

                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="This will allow for users to set featured listing. Featured listings will be searched first."
                                    ></i>
                                    <span></span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="m-checkbox m-checkbox--state-success">
                                    <input type="checkbox" name="allow_image" {{optional($item->property)['image']==1? 'checked':''}}>
                                    Allow to put image gallery

                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="This will allow for users to put image gallery in listing detail."
                                    ></i>
                                    <span></span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="m-checkbox m-checkbox--state-success">
                                    <input type="checkbox" name="allow_links" {{optional($item->property)['links']==1? 'checked':''}}>
                                    Allow to put external video links

                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="This will allow for users to put external video links."
                                    ></i>
                                    <span></span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="m-checkbox m-checkbox--state-success">
                                    <input type="checkbox" name="allow_videos" {{optional($item->property)['videos']==1? 'checked':''}}>
                                    Allow to upload custom videos

                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="This will allow for users to upload custom videos."
                                    ></i>
                                    <span></span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="m-checkbox m-checkbox--state-success">
                                    <input type="checkbox" name="allow_tracking" {{optional($item->property)['tracking']==1? 'checked':''}}>
                                    Allow to track impression

                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="This will allow for users to see impression tracking data."
                                    ></i>
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <hr>

                        <div class="form-group">
                            <table class="table table-bordered table-item-center">
                                <tbody id="image_area">
                                @foreach($item->getMedia('image') as $key=>$image)
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control m-input--square" value="{{$image->getUrl()}}" readonly>
                                            <input type="hidden" name='oldItems[]' value="{{$image->id}}">
                                        </td>
                                        <td><img class='width-150' src="{{$image->getUrl()}}"/></td>
                                        <td><button class='btn btn-danger btn-sm delRowBtn'>X</button></td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <a href="javascript:void(0);" class="btn m-btn--square m-btn m-btn--custom btn-outline-info p-1" id="addImage">
                                    + Add Image

                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="You can add image gallery to explain about this package better"
                                    ></i>
                                </a>
                            </table>
                        </div>
                        <div class="form-group">
                            <table class="table table-bordered table-item-center">
                                <tbody id="link_area">
                                @foreach($item->getLinks() as $key1=>$link)
                                    <tr>
                                        <td><input type="url" name='links[]' class="form-control m-input--square" value="{{$link}}"></td>
                                        <td><button class='btn btn-danger btn-sm delRowBtn'>X</button></td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <a href="javascript:void(0);" class="btn m-btn--square m-btn m-btn--custom btn-outline-info p-1" id="addLink">
                                    + Add External Video Link

                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="You can add youtube video link to explain about this package better"
                                    ></i>
                                </a>
                            </table>
                        </div>
                        <div class="form-group">
                            <table class="table table-bordered table-item-center">
                                <tbody id="video_area">
                                @foreach($item->getMedia('video') as $key2=>$video)
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control m-input--square" value="{{$video->getUrl()}}" readonly>
                                            <input type="hidden" name='oldItems[]' value="{{$video->id}}">
                                        </td>
                                        <td><button class='btn btn-danger btn-sm delRowBtn'>X</button></td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <a href="javascript:void(0);" class="btn m-btn--square m-btn m-btn--custom btn-outline-info p-1" id="addVideo">
                                    + Upload Video

                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="You can upload your own video to explain about this package better. Supported file extensions are .mp4, .mov, .ogg, .qt, .flv, .3gp, .avi, .wmv, .mpeg, .mpg. Max upload size is 100 MB."
                                    ></i>
                                </a>
                            </table>
                        </div>
                        <div class="form-group m-form__group">
                            <label for="example_input_full_name">
                                Choose Gallery Order:
                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="When you put both images and videos, this is sort order in package detail page."
                                ></i>
                            </label>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="m-option">
                                        <span class="m-option__control">
                                            <span class="m-radio m-radio--brand m-radio--check-bold">
                                                <input type="radio" name="order" value="1" @if($item->order==1) checked @endif>
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
                                                <input type="radio" name="order" value="0" @if($item->order==0) checked @endif>
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
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="thumbnail" class="form-control-label">
                                Thumbnail

                                <i class="la la-info-circle tipso2"
                                   data-tipso-title="What is this?"
                                   data-tipso="This is thumbnail image to show this package. Supported image extensions are .jpg, .png, .jpeg, .gif. Max file size is 10MB."
                                ></i>
                            </label>
                            <input type="file" accept="image/*" class="form-control m-input--square" id="thumbnail" >
                            <div class="form-control-feedback error-thumbnail"></div>
                            <img id="thumbnail_image" class="maxw-100" src="{{$item->getFirstMediaUrl("thumbnail")}}"/>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <label for="featured" class="form-control-label">
                                    Featured?

                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="You can set as featured this package. Users will see features packages first."
                                    ></i>
                                </label>
                                <div>
                                    <span class="m-switch m-switch--icon m-switch--info">
                                        <label>
                                            <input type="checkbox" name="featured" id="featured" @if($item->featured) checked @endif>
                                            <span></span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                            <div class="col-4">
                                <label for="new" class="form-control-label">
                                    New?

                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="You can set this package as new."
                                    ></i>
                                </label>
                                <div>
                                    <span class="m-switch m-switch--icon m-switch--info">
                                        <label>
                                            <input type="checkbox" name="new" id="new" @if($item->new) checked @endif>
                                            <span></span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                            <div class="col-4">
                                <label for="status" class="form-control-label">Approve?
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="This is status of this package. You can approve or disable."
                                    ></i></label>
                                <div>
                                    <div>
                                    <span class="m-switch m-switch--icon m-switch--info">
                                        <label>
                                            <input type="checkbox" name="status" id="status" @if($item->status)checked @endif>
                                            <span></span>
                                        </label>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right mt-4">
                    <button type="submit" class="btn m-btn--square m-btn m-btn--custom btn-outline-success smtBtn">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area md-pt-50" id="price_area">
        <div class="m-portlet__body">
            @include("components.admin.common.priceArea")
        </div>
    </div>

    @include("components.admin.common.meetingForm", ['action'=>route('admin.directory.package.updateMeetingForm', $item->id)])

    @include("components.admin.common.addPriceModal", ['action'=>route('admin.directory.package.createPrice', $item->id)])

@endsection
@section('script')
    <script type="text/javascript" src="{{asset('assets/vendors/cropper/cropper.js')}}"></script>
    <script>
        var item_id = "{{$item->id}}",
            getPriceUrl="{{route('admin.directory.package.edit', $item->id)}}",
            delPriceUrl="{{route('admin.directory.package.deletePrice', $item->id)}}";
    </script>
    <script src="{{asset('assets/js/admin/directory/packageEdit.js')}}"></script>
    <script src="{{asset('assets/js/admin/common/meetingForm.js')}}"></script>
    <script src="{{asset('assets/js/admin/common/price.js')}}"></script>
@endsection
