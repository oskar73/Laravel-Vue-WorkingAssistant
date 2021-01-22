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
                    <span class="m-nav__link-text">Detail</span>
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
         <div class="m-portlet__body">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-group">
                            <label for="subject" class="form-control-label">Subject:</label>
                            <input type="text" class="form-control" name="subject" id="subject" value="{{$template->subject}}">
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
                                                {!! $template->body !!}
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
                            <label for="category" class="form-control-label">Category:</label>
                            <input type="text" class="form-control" name="category" id="category" value="{{$template->category->name}}" readonly>
                            <div class="form-control-feedback error-category"></div>
                        </div>
                        <div class="form-group">
                            <label for="fromMail" class="form-control-label">From Email Address:</label>
                            <input type="text" class="form-control" name="fromMail" id="fromMail" value="{{$template->fromMail}}" readonly>
                            <div class="form-control-feedback error-fromMail"></div>
                        </div>
                        <div class="form-group">
                            <label for="fromName" class="form-control-label">From Name:</label>
                            <input type="text" class="form-control" name="fromName" id="fromName" value="{{$template->fromName}}" readonly>
                            <div class="form-control-feedback error-fromName"></div>
                        </div>
                        <br>
                        <hr>
                        <br>
                        <div class="form-group">
                            <label for="name" class="form-control-label">Name:</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{$template->name}}" readonly>
                            <div class="form-control-feedback error-name"></div>
                        </div>
                        <div class="form-group">
                            <label for="slug" class="form-control-label">Slug:</label>
                            <input type="text" class="form-control" name="slug" id="slug" value="{{$template->slug}}" readonly>
                            <div class="form-control-feedback error-slug"></div>
                        </div>
                        <div class="mt-3 text-right">
                            <a href="{{route('admin.notification.template.index')}}" class="btn m-btn--square  btn-outline-primary">Back</a>
                            <a href="{{route('admin.notification.template.edit', $template->id)}}" class="btn m-btn--square  btn-outline-info smtBtn">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection
@section('script')
@endsection
