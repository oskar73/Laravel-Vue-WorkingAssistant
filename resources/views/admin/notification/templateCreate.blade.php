@extends('layouts.master')

@section('title', 'Notification Template')
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
                    <span class="m-nav__link-text">Notification</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Template</span>
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
            <li class="tab-item"><a class="tab-link tab-active" data-area="#all" href="#/all">Template Detail</a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active md-pt-50" id="all_area">
        <form action="{{route('admin.notification.template.store')}}" id="submit_form">
            @csrf
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-group">
                            <label for="subject" class="form-control-label">Subject:</label>
                            <input type="text" class="form-control" name="subject" id="subject">
                        </div>
                        <div class="form-group">
                            <div class="border border-success minh-100px" paddingwidth="0" paddingheight="0" style="background-repeat: repeat; padding-top: 0; padding-bottom: 0; padding-top: 0; padding-bottom: 0; margin: 0; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased; width: 100%;background-color: #edf2f7;" offset="0" toppadding="0" leftpadding="0">
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tableContent" align="center" style="font-family:Helvetica, Arial,serif;">
                                    <tbody>
                                    <tr><td height="25"></td></tr>
                                    <tr>
                                        <td>
                                            @include("components.mail.header")
                                            <div id="message_body" >
                                                <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#ffffff" class="MainContainer"
                                                       style="box-shadow: 0 2px 0 rgba(0, 0, 150, 0.025), 2px 4px 0 rgba(0, 0, 150, 0.015);">
                                                    <tbody>
                                                    <tr><td height="25"></td></tr>
                                                    <tr>
                                                        <td>
                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                <tbody>
                                                                <tr>
                                                                    <td valign="top" width="40">&nbsp;</td>
                                                                    <td>
                                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                            <tbody>
                                                                            <tr>
                                                                                <td class="movableContentContainer " valign="top">
                                                                                    <div class="movableContent" style="margin: 0; border: 0px; padding-top: 0px; position: relative;">
                                                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                                                                                            <tr>
                                                                                                <td align="left">
                                                                                                    <div class="contentEditableContainer contentTextEditable" style="margin: 0;">
                                                                                                        <div class="contentEditable" style="margin: 0;font-size:15px" contentEditable>
                                                                                                            <h4>Hello!</h4>
                                                                                                            <p style="margin-bottom:5px;">Here text go...</p>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>

                                                                                            <tr><td height="30"></td></tr>
                                                                                            <tr>
                                                                                                <td align="center">
                                                                                                    <table>
                                                                                                        <tr>
                                                                                                            <td align="center" bgcolor="#289CDC" style="background:#32a506;box-shadow: 1px 4px 8px #4444; padding:15px 18px;-webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 5px;">
                                                                                                                <div class="contentEditableContainer contentTextEditable" style="margin: 0;">
                                                                                                                    <div class="contentEditable" align="center" style="margin: 0;">
                                                                                                                        <a target="_blank" href="{url}" class="link2" style="font-size: 16px; text-decoration: none; color: #ffffff;" contentEditable>Click Here</a>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                    </table>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr><td height="30"></td></tr>
                                                                                            <tr>
                                                                                                <td align="left">
                                                                                                    <div class="contentEditableContainer contentTextEditable" style="margin: 0;">
                                                                                                        <div class="contentEditable" style="margin: 0;font-size:15px" contentEditable>
                                                                                                            Best wishes, <br>
                                                                                                            {website_name}
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr><td height="30" style="border-bottom:1px solid #dfe3e8;"></td></tr>
                                                                                            <tr>
                                                                                                <td height="20" style="font-size:12px;padding-top:15px;line-height:20px;" contentEditable>
                                                                                                    If you’re having trouble clicking the "Click Here" button, copy and paste the URL below into your web browser:
                                                                                                    <a href="{url}">{url}</a>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </div>
                                                                                    <!-- =============================== footer ====================================== -->
                                                                                </td>
                                                                            </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                    <td valign="top" width="20">&nbsp;</td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr><td height="25"></td></tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                @include("components.mail.footer")
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="category">Select Category</label>
                            <select class="form-control m-bootstrap-select selectpicker" name="category" id="category" data-live-search="true">
                                <option selected disabled hidden>Choose Category</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                            <div class="form-control-feedback error-category"></div>
                        </div>
                        <div class="form-group">
                            <label for="fromMail" class="form-control-label">From Email Address:</label>
                            <div class="input-group">
                                <input type="text" class="form-control m-input text-right" name="fromMail" id="fromMail" aria-describedby="basic-addon2" value="info">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">{{'@' . config("custom.bizinabox.mail_domain")}}</span>
                                </div>
                            </div>
                            <div class="form-control-feedback error-fromMail"></div>
                        </div>
                        <div class="form-group">
                            <label for="fromName" class="form-control-label">From Name:</label>
                            <input type="text" class="form-control" name="fromName" id="fromName" value="{{tenant("name")}}">
                            <div class="form-control-feedback error-fromName"></div>
                        </div>
                        <br>
                        <hr>
                        <br>
                        <div class="form-group">
                            <label for="name" class="form-control-label">Name:</label>
                            <input type="text" class="form-control" name="name" id="name">
                            <div class="form-control-feedback error-name"></div>
                        </div>
                        <div class="form-group">
                            <label for="slug" class="form-control-label">Slug:</label>
                            <input type="text" class="form-control" name="slug" id="slug">
                            <div class="form-control-feedback error-slug"></div>
                        </div>
                        <div class="mt-3 text-right">
                            <a href="{{route('admin.notification.template.index')}}" class="btn m-btn--square  btn-outline-primary">Back</a>
                            <button type="submit" class="btn m-btn--square  btn-outline-info smtBtn">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/js/admin/notification/templateCreate.js')}}"></script>
@endsection
