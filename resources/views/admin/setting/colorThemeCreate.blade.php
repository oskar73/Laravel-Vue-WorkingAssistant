@extends('layouts.master')

@section('title', 'Setting - Color Create')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/jquery/jquery-ui.1.9.2.min.css')}}"/>
    <link href="{{asset('assets/vendors/colorSwatch/style.css')}}" rel="stylesheet" type="text/css" />

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
                    <span class="m-nav__link-text">Setting</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Color</span>
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
    <div class="row color_setting">
        <div class="col-lg-3">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__body position-relative p-0">
                    <div id="color_body">
                        <div class="mode">
                            <button class="lightModeClk" id="light-icon"></button>
                            <button class="darkModeClk" id="dark-icon"></button>
                        </div>
                        <div class="content">
                            <div class="colors pb-0 pt-3">
                                <form action="{{route("admin.setting.color.store", $type)}}" method="POST" id="submit_form">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="m-portlet__head-tools mt-3 mb-3 text-right">
                                                <input type="text" class="form-control maxw-250 d-inline-block mr-2" name="name" placeholder="Name" value="{{$color->name?? ''}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="wrap-btn pt-3">
                                                <button type="button" class="rdm-btn setRdmClk" >Randomize</button>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="m-portlet__head-tools mt-3 mb-3 text-right">
                                                <a href="{{route('admin.setting.color.index')}}" class="btn m-btn--square  btn-outline-primary m-1">
                                                    Back
                                                </a>
                                                <button type="submit" class="btn m-btn--square  btn-outline-info m-1 smtBtn">
                                                    Submit
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="random-colors">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="gen text-center">
                                                    <div class="swatch_label mb-2">
                                                        Main Theme Color
                                                        <i class="la la-info-circle tipso2"
                                                           data-tipso-title="What is this?"
                                                           data-tipso="This is main theme color.Most colors will be put with this color in your website.">
                                                        </i>
                                                    </div>
                                                    <div class="child-color" ><input class="jscolor" id="js1" name="primary"></div>
                                                    <div class="hexcolor">
                                                        <h3>#17405B</h3>
                                                        <i class="jfa-copy tipso1" data-tipso="Copy"></i>
                                                        <i class="jfa-lock tipso1" data-tipso="Lock/Unlock this color"></i>
                                                        <label for="from_file1">
                                                            <i class="fa fa-cloud-upload-alt tipso1" data-tipso="Pick color from file.">
                                                                <input type="file" class="from_file d-none" id="from_file1" data-id="js1">
                                                            </i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="gen text-center">
                                                    <div class="swatch_label mb-2">
                                                        Font Color in Theme Background
                                                        <i class="la la-info-circle tipso2"
                                                           data-tipso-title="What is this?"
                                                           data-tipso="This is font color in brand color background. recommend contrast with brand color. For instance,
                                   if theme color is black, we recommend this color as white.">
                                                        </i>
                                                    </div>
                                                    <div class="child-color"><input class="jscolor" id="js2" name="theme_font"></div>
                                                    <div class="hexcolor">
                                                        <h3>#0A8BA1</h3>
                                                        <i class="jfa-copy tipso1" data-tipso="Copy"></i>
                                                        <i class="jfa-lock tipso1" data-tipso="Lock/Unlock this color"></i>
                                                        <label for="from_file2">
                                                            <i class="fa fa-cloud-upload-alt tipso1" data-tipso="Pick color from file.">
                                                                <input type="file" class="from_file d-none" id="from_file2" data-id="js2">
                                                            </i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="gen text-center">
                                                    <div class="swatch_label mb-2">
                                                        Website Secondary Color
                                                        <i class="la la-info-circle tipso2"
                                                           data-tipso-title="What is this?"
                                                           data-tipso="This is secondary theme color. All buttons, lines, active colors will be covered with this color">
                                                        </i>
                                                    </div>
                                                    <div class="child-color"><input class="jscolor" id="js3"  name="secondary"></div>
                                                    <div class="hexcolor">
                                                        <h3>#09C1C5</h3>
                                                        <i class="jfa-copy tipso1" data-tipso="Copy"></i>
                                                        <i class="jfa-lock tipso1" data-tipso="Lock/Unlock this color"></i>
                                                        <label for="from_file3">
                                                            <i class="fa fa-cloud-upload-alt tipso1" data-tipso="Pick color from file.">
                                                                <input type="file" class="from_file d-none" id="from_file3" data-id="js3">
                                                            </i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="gen text-center">
                                                    <div class="swatch_label mb-2">
                                                        Website Front Page Background Color
                                                        <i class="la la-info-circle tipso2"
                                                           data-tipso-title="What is this?"
                                                           data-tipso="This is front page background color in your website..">
                                                        </i>
                                                    </div>
                                                    <div class="child-color"><input class="jscolor" id="js4" name="background"></div>
                                                    <div class="hexcolor">
                                                        <h3>#F1F3F4</h3>
                                                        <i class="jfa-copy tipso1" data-tipso="Copy"></i>
                                                        <i class="jfa-lock tipso1" data-tipso="Lock/Unlock this color"></i>
                                                        <label for="from_file4">
                                                            <i class="fa fa-cloud-upload-alt tipso1" data-tipso="Pick color from file.">
                                                                <input type="file" class="from_file d-none" id="from_file4" data-id="js4">
                                                            </i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="gen text-center">
                                                    <div class="swatch_label mb-2">
                                                        Website Font Color
                                                        <i class="la la-info-circle tipso2"
                                                           data-tipso-title="What is this?"
                                                           data-tipso="This is font color including Heading tag, normal text in your website. recommend black color.">
                                                        </i>
                                                    </div>
                                                    <div class="child-color"><input class="jscolor" id="js5" name="font"></div>
                                                    <div class="hexcolor">
                                                        <h3>#EA8971</h3>
                                                        <i class="jfa-copy tipso1" data-tipso="Copy"></i>
                                                        <i class="jfa-lock tipso1" data-tipso="Lock/Unlock this color"></i>
                                                        <label for="from_file5">
                                                            <i class="fa fa-cloud-upload-alt tipso1" data-tipso="Pick color from file.">
                                                                <input type="file" class="from_file d-none" id="from_file5" data-id="js5">
                                                            </i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="gen text-center">
                                                    <div class="swatch_label mb-2">
                                                        Website Link Text Color
                                                        <i class="la la-info-circle tipso2"
                                                           data-tipso-title="What is this?"
                                                           data-tipso="This is color of link in website. Recommend same as brand color.">
                                                        </i>
                                                    </div>
                                                    <div class="child-color"><input class="jscolor" id="js6" name="link"></div>
                                                    <div class="hexcolor">
                                                        <h3>#EA8971</h3>
                                                        <i class="jfa-copy tipso1" data-tipso="Copy"></i>
                                                        <i class="jfa-lock tipso1" data-tipso="Lock/Unlock this color"></i>
                                                        <label for="from_file6">
                                                            <i class="fa fa-cloud-upload-alt tipso1" data-tipso="Pick color from file.">
                                                                <input type="file" class="from_file d-none" id="from_file6" data-id="js6">
                                                            </i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="gen text-center">
                                                    <div class="swatch_label mb-2">
                                                        Website Link Hover Text Color
                                                        <i class="la la-info-circle tipso2"
                                                           data-tipso-title="What is this?"
                                                           data-tipso="This is color of link when users hover mouse on link in website.">
                                                        </i>
                                                    </div>
                                                    <div class="child-color"><input class="jscolor" id="js7" name="link_hover"></div>
                                                    <div class="hexcolor">
                                                        <h3>#EA8971</h3>
                                                        <i class="jfa-copy tipso1" data-tipso="Copy"></i>
                                                        <i class="jfa-lock tipso1" data-tipso="Lock/Unlock this color"></i>
                                                        <label for="from_file7">
                                                            <i class="fa fa-cloud-upload-alt tipso1" data-tipso="Pick color from file.">
                                                                <input type="file" class="from_file d-none" id="from_file7" data-id="js7">
                                                            </i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="gen text-center">
                                                    <div class="swatch_label mb-2">
                                                        Website Active Icon Color
                                                        <i class="la la-info-circle tipso2"
                                                           data-tipso-title="What is this?"
                                                           data-tipso="This is icon color, active icon color. Recommend same as brand color but you can set it with different one.">
                                                        </i>
                                                    </div>
                                                    <div class="child-color"><input class="jscolor" id="js8" name="active_icon"></div>
                                                    <div class="hexcolor">
                                                        <h3>#EA8971</h3>
                                                        <i class="jfa-copy tipso1" data-tipso="Copy"></i>
                                                        <i class="jfa-lock tipso1" data-tipso="Lock/Unlock this color"></i>
                                                        <label for="from_file8">
                                                            <i class="fa fa-cloud-upload-alt tipso1" data-tipso="Pick color from file.">
                                                                <input type="file" class="from_file d-none" id="from_file8" data-id="js8">
                                                            </i>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="preview_area">
                <div class="preview_title">Preview</div>
                <img src="{{asset("assets/img/web-frame-header.png")}}" alt="" class="w-100" id="preview_img">
                <iframe src="{{route('home')}}" frameborder="0" class="preview_iframe" id="preview_iframe"></iframe>
            </div>
        </div>
    </div>
    <div class="modal" id="myModal" data-backdrop="static">
        <div class="jgjmodalcenter">
            <canvas id="canvas_picker" class="jgjcanvas"></canvas>
            <input type="color" class="jgjpickedcolor" value="#ffffff" >
            <a href="javascript:void(0);" class="btn btn-danger m-btn--sm jgjmodalclosebtn"  data-dismiss="modal">X</a>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{asset('assets/vendors/jquery/jquery-ui.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/vendors/jscolor/jscolor.js')}}"></script>
    <script src="{{asset('assets/vendors/colorSwatch/colorSwatch.js')}}"></script>
    <script src="{{asset('assets/js/admin/setting/colorThemeCreate.js')}}"></script>
@endsection
