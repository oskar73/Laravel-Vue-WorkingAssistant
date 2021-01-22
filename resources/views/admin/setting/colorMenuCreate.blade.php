@extends('layouts.master')

@section('title', 'Setting - Color Create')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendors/jquery/jquery-ui.1.9.2.min.css')}}"/>
    <link href="{{asset('assets/vendors/colorSwatch/style.css')}}" rel="stylesheet" type="text/css" />
    <style id="dynamic_style">
    </style>
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
    <div class="color_setting">

        <div id="color_body">
            <div class="mode">
                <button class="lightModeClk" id="light-icon"></button>
                <button class="darkModeClk" id="dark-icon"></button>
            </div>

            <div class="content">
                <div class="colors pb-0">
                    <form action="{{route("admin.setting.color.create", "menu")}}" method="POST" id="submit_form">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="wrap-btn pt-3">
                                    <button type="button" class="rdm-btn setRdmClk" >Randomize here</button>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="m-portlet__head-tools mt-3 mb-3 text-right">
                                    <input type="text" class="form-control maxw-300 d-inline-block mr-2" name="name" placeholder="Name" value="">
                                    <a href="{{route('admin.setting.color.index')}}#/menu" class="btn m-btn--square  btn-outline-primary m-2">
                                        Back
                                    </a>
                                    <button type="submit" class="btn m-btn--square  btn-outline-info m-2 smtBtn">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="random-colors menu_colors">
                            <div class="gen text-center">
                                <div class="swatch_label mb-2">
                                    Navigation Background Color
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="Navbar Background Color"
                                       data-tipso="This is navigation background color.">
                                    </i>
                                </div>
                                <div class="child-color" ><input class="jscolor" id="js1" name="nav_bg"></div>
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

                            <div class="gen text-center">
                                <div class="swatch_label mb-2">
                                    Navigation Item Color
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="Navbar Item Color"
                                       data-tipso="This is item color in navigation menu area.">
                                    </i>
                                </div>
                                <div class="child-color"><input class="jscolor" id="js2" name="nav_item"></div>
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

                            <div class="gen text-center">
                                <div class="swatch_label mb-2">
                                    Navigation Item Hover Background Color
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="Navbar Item Hover Background Color"
                                       data-tipso="This is item hover color in navigation menu area">
                                    </i>
                                </div>
                                <div class="child-color"><input class="jscolor" id="js3" name="nav_hover_bg"></div>
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

                            <div class="gen text-center">
                                <div class="swatch_label mb-2">
                                    Navigation Item Hover Color
                                    <i class="la la-info-circle tipso2"
                                       data-tipso-title="Navbar Item Hover Color"
                                       data-tipso="This is navigation item hover color">
                                    </i>
                                </div>
                                <div class="child-color"><input class="jscolor" id="js4" name="nav_hover_item"></div>
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
                    </form>
                </div>
            </div>
        </div>
        <div class="preview_area">
            <div class="preview_title">Preview</div>
            <img src="{{asset("assets/img/web-frame-header.png")}}" alt="" class="w-100" id="preview_img">
            <iframe src="{{route('home')}}" frameborder="0" class="preview_iframe" id="preview_iframe"></iframe>
        </div>

        <div class="modal" id="myModal" data-backdrop="static">
            <div class="jgjmodalcenter">
                <canvas id="canvas_picker" class="jgjcanvas"></canvas>
                <input type="color" class="jgjpickedcolor" value="#ffffff" >
                <a href="javascript:void(0);" class="btn btn-danger m-btn--sm jgjmodalclosebtn"  data-dismiss="modal">X</a>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/vendors/jquery/jquery-ui.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/vendors/jscolor/jscolor.js')}}"></script>
    <script src="{{asset('assets/vendors/colorSwatch/colorSwatch.js')}}"></script>
    <script src="{{asset('assets/js/admin/setting/colorMenuCreate.js')}}"></script>
@endsection
