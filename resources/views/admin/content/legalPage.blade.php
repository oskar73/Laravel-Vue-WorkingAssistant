@extends('layouts.master')

@section('title', 'Legal Pages')
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
                    <span class="m-nav__link-text">Content</span>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Legal Pages</span>
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="m-portlet m-portlet--mobile md-pt-50">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Legal Pages
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">

            </div>
        </div>
        <div class="m-portlet__body" id="legal_page_area">
            <div class="table-responsive">
                <table class="table table-hover ajaxTable datatable ">
                    <thead>
                    <tr>
                        <th>
                            Name
                        </th>
                        <th>
                            Url
                        </th>
                        <th>
                            Status
                        </th>
                        <th class="no-sort">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($legalPages as $item)
                        <tr>
                            <td>{{$item->name}}</td>
                            <td>
                                <a href="{{Request::root() . "/" .$item->url}}" target="_blank">{{Request::root() . "/" .$item->url}}</a>
                            </td>
                            <td>
                               @if($item->status)
                                    <span class="c-badge c-badge-success">Active</span>
                               @else
                                    <span class="c-badge c-badge-danger">Inactive</span>
                               @endif
                            </td>
                            <td>
                                <a href="{{route('admin.content.legalPage.edit', $item->id)}}"
                                   class="tab-link btn btn-outline-info btn-sm m-1	p-2 m-btn m-btn--icon edit_btn"
                                >
                                <span>
                                    <i class="la la-edit"></i>
                                    <span>Edit</span>
                                </span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
