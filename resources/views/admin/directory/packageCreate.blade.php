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
                    <span class="m-nav__link-text">Create</span>
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="tabs-wrapper">
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" data-area="#all" href="#/all">Package Detail</a></li>
            <li class="tab-item"><a class="tab-link" href="javascript:void(0);">Set Price</a></li>
            <li class="tab-item"><a class="tab-link" href="javascript:void(0);">Meeting and Attach Form</a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50" id="all_area">
        <div class="m-portlet__body">
            <form action="{{route('admin.directory.package.store')}}" id="submit_form" method="post" enctype="multipart/form-data">
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
                            <input type="text" class="form-control" name="name" id="name" >
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
                            <textarea class="form-control m-input--square minh-100 white-space-pre-line" name="description" id="description"></textarea>
                            <div class="form-control-feedback error-description"></div>
                        </div>
                        <h5>Features</h5>
                        <hr>
                        <div class="row" x-data="{unlimit:false}">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="listing_limit" class="form-control-label">
                                        Listing limit number:

                                        <i class="la la-info-circle tipso2"
                                           data-tipso-title="What is this?"
                                           data-tipso="This is directory listing limit number that users can put using this package."
                                        ></i>
                                    </label>
                                    <input type="number" class="form-control" name="listing_limit" id="listing_limit" x-bind:disabled="unlimit">
                                    <div class="form-control-feedback error-listing_limit"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <br>
                                <br>
                                <label class="m-checkbox m-checkbox--state-success">
                                    <input type="checkbox" name="unlimit" x-on:click="unlimit=!unlimit">
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
                                    <input type="checkbox" name="allow_thumbnail">
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
                                    <input type="checkbox" name="allow_social">
                                    Allow to put social media share links

                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="This will allow for users to put their social media link"
                                    ></i>
                                    <span></span>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label class="m-checkbox m-checkbox--state-success">
                                    <input type="checkbox" name="allow_featured">
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
                                    <input type="checkbox" name="allow_image">
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
                                    <input type="checkbox" name="allow_links">
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
                                    <input type="checkbox" name="allow_videos">
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
                                    <input type="checkbox" name="allow_tracking">
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
                                                <input type="radio" name="order" value="1" checked>
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
                                                <input type="radio" name="order" value="0">
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
                            <img id="thumbnail_image" class="w-100"/>
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
                                            <input type="checkbox"  name="featured" id="featured">
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
                                            <input type="checkbox"  name="new" id="new">
                                            <span></span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                            <div class="col-4">
                                <label for="status" class="form-control-label">Approve?
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="What is this?"
                                       data-tipso="This is status of this package. Until you assign price to this package, it shouldn't be approved."
                                    ></i></label>
                                <div>
                                    <span class="m-switch m-switch--icon m-switch--info">
                                        <label>
                                            <input type="checkbox" disabled name="status" id="status">
                                            <span></span>
                                        </label>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right mt-4">
                    <a href="{{route('admin.directory.package.index')}}" class="btn btn-outline-info m-btn m-btn--custom m-btn--square">Back</a>
                    <button type="submit" class="btn m-btn--square m-btn m-btn--custom btn-outline-success smtBtn">Next</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{asset('assets/vendors/cropper/cropper.js')}}"></script>
    <script src="{{asset('assets/js/admin/directory/packageCreate.js')}}"></script>
@endsection
