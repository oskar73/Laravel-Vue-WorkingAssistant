@extends('layouts.master')

@section('title', 'TODO List')
@section('style')
@endsection
@section('breadcrumb')
    <div class="col-md-6">
        <x-layout.breadcrumb :menus="['ToDo List']" :menuLinks="[]" />
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-3 col-md-4">
        <div class="sidebar-tab">
            <ul class="sidebar-tab-ul">
                @foreach($types as $key=>$typeItem)
                    @if($typeItem)
                        <li class="tab-item">
                            <a class="tab-link @if($type===$key) tab-active @endif" href="{{route('user.todo.detail', $key)}}">
                                <span>{{todoTypeToName($key)}} </span> <div class="check_mark_area"><span class="m-badge m-badge--danger ml-1">{{$typeItem}}</span></div>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
    <div class="col-lg-9  col-md-8">
        <x-layout.portlet active="1" id="todo_area" label="{{todoTypeToName($type)}}">
            <div class="m-alert m-alert--icon m-alert--icon-solid m-alert--outline alert alert-info">
                <div class="m-alert__icon">
                    <i class="flaticon-exclamation-1"></i>
                    <span></span>
                </div>
                <div class="m-alert__text text-dark fs-16">
                    <strong>Hello, you have <span class="m-badge m-badge--danger ml-1">{{$count}}</span>
                        {{todoTypeToName($type)}} to make.</strong>
                </div>
            </div>

            <div class="result_area">
                <x-layoutItems.loading />
            </div>
        </x-layout.portlet>
    </div>
</div>
@endsection
@section('script')
    <script>var type="{{$type}}";</script>
    <script src="{{asset('assets/js/user/todo.js')}}"></script>
@endsection
