@extends('layouts.master')

@section('title', 'User Dashboard')
@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/5.1.0/introjs.min.css" />
@endsection
@section('breadcrumb')
    <div class="mr-auto">
        <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
            <li class="m-nav__item m-nav__item--home">
                <a href="" class="m-nav__link m-nav__link--icon">
                    <i class="m-nav__link-icon la la-home"></i>
                </a>
            </li>
            <li class="m-nav__separator">/</li>
            <li class="m-nav__item">
                <a href="" class="m-nav__link">
                    <span class="m-nav__link-text">Dashboard</span>
                </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="site-quick-tour-wrap">
                <div class="site-quick-tour-button-wrap">
                    <p><a href="#" class="site-quick-tour-button">Quick Tour</a></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="m-portlet">
                <div class="m-portlet__head bg-333">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text text-white">
                                InBasket
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body p-2 p-md-3">
                    <div class="m-scrollable m-scroller" data-scrollable="true" style="max-height: 400px; overflow: auto;">

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="m-portlet">
                <div class="m-portlet__head bg-333">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text text-white">
                                Unread Notifications ({{$notifications->count()}})
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-caption">
                        <a href="/admin/notifications" class="text-white underline">View All</a>
                    </div>
                </div>
                <div class="m-portlet__body p-2 p-md-3">
                    <div class="m-scrollable m-scroller" data-scrollable="true" style="max-height: 400px; overflow: auto;">
                        <div class="m-list-timeline m-list-timeline--skin-light">
                            <div class="m-list-timeline__items">
                                @forelse($notifications as $unread)
                                    <div class="m-list-timeline__item">
                                        <span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
                                        <span class="m-list-timeline__text">
                                            <a href="{{route('notification.detail', ['id'=>$unread->id, 'role'=>'admin'])}}" class="text-dark">{{$unread->data['subject']}}</a>
                                            <a href="{{route('notification.detail', ['id'=>$unread->id, 'role'=>'admin'])}}" class="btn m-btn--square m-btn btn-sm m-btn--custom btn-outline-black p-1">
                                                View
                                            </a>
                                        </span>
                                        <span class="m-list-timeline__time" style="width:100px;">{{$unread->created_at->diffForHumans()}}</span>
                                    </div>
                                @empty
                                    <div class="text-center">No Notification</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head  bg-333">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text text-white">
                                Recent Tickets ({{$openedTickets->count()}})
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="{{route('user.ticket.index')}}" class="text-white underline">View All</a>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-scrollable m-scroller" data-scrollable="true" style="max-height: 400px; overflow: auto;">
                        @forelse($openedTickets as $openedTicket)
                            <a href="{{route('user.ticket.edit', $openedTicket->id)}}" class="btn m-btn--square  btn-outline-dark m-btn m-btn--custom btn-block white-space-pre-line">
                                <div class="float-left"><span class="c-badge c-badge-success">#{{$openedTicket->id}}</span></div>
                                {{Str::limit($openedTicket->text, 40)}}
                                <div class="float-right"><span class="c-badge {{$openedTicket->status=='opened'? 'c-badge-danger':'c-badge-success'}}">{{ucfirst($openedTicket->status)}}</span></div>
                            </a>
                        @empty
                            <div class="text-center">No opened ticket</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head  bg-333">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text text-white">
                                Unread Notifications ({{$notifications->count()}})
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="/account/notifications" class="text-white underline">View All</a>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-scrollable m-scroller" data-scrollable="true" style="max-height: 400px; overflow: auto;">
                        <div class="m-list-timeline m-list-timeline--skin-light">
                            <div class="m-list-timeline__items">
                                @forelse($notifications as $unread)
                                    <div class="m-list-timeline__item">
                                        <span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
                                        <span class="m-list-timeline__text">
                                            <a href="{{route('notification.detail', ['id'=>$unread->id, 'role'=>'account'])}}" class="text-dark">{{$unread->data['subject']}}</a>
                                            <a href="{{route('notification.detail', ['id'=>$unread->id, 'role'=>'account'])}}" class="btn m-btn--square m-btn btn-sm m-btn--custom btn-outline-black p-1">
                                                View
                                            </a>
                                        </span>
                                        <span class="m-list-timeline__time" style="width:100px;">{{$unread->created_at->diffForHumans()}}</span>
                                    </div>
                                @empty
                                    <div class="text-center">No Notification</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/5.1.0/intro.min.js"></script>

    <script>
        $(document).ready(function () {
            $(document).on('click', '.site-quick-tour-button', function (e) {
                e.preventDefault();

                $('#m_ver_menu').scrollTop(0); //scroll top of menu div
                $('.m-menu__item.m-menu__item--submenu').removeClass('m-menu__item--open'); //Close all dropdown menus

                introJs().setOption("scrollToElement", " false ").start();
            });
            $(document).on('click', '.introjs-skipbutton', function () {
                introJs().exit();
            });
        });
    </script>
@endsection
