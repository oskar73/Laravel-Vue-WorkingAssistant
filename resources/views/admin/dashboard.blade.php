@extends('layouts.master')

@section('title', 'Admin Dashboard')
@section('style')

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
    <div class="tabs-wrapper">
        <ul class="tab-nav">
            <li class="tab-item"><a class="tab-link tab-active" data-area="#reports" href="#/reports"> Reports</a></li>
            <li class="tab-item"><a class="tab-link" data-area="#analytics" href="#/analytics"> Google Analytics</a></li>
        </ul>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area area-active" id="reports_area" >
        <div class="m-portlet__body">
            <div class="row mb-3">
                <div class="col-sm-6 col-md-3 mb-2">
                    <a href="{{route('admin.userManage.index')}}" class="card card-body hover-none"
                         style="background-color: rgb(108, 178, 235); color: rgb(255, 255, 255);box-shadow:1px 5px 8px #3333;">
                        <div class="media">
                            <div class="media-body">
                                <h3 class="mb-0">{{$totalUsers-1}}</h3>
                                <small class="text-uppercase font-size-xs">Registered Users</small>
                            </div>
                            <div class="ml-3 align-self-center">
                                <i class="fa fa-users fa-3x opacity-75"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-md-3 mb-2">
                    <a href="{{route('admin.userManage.index')}}" class="card card-body hover-none"
                         style="background-color: rgb(23, 197, 203); color: rgb(255, 255, 255);box-shadow:1px 5px 8px #3333;">
                        <div class="media">
                            <div class="media-body">
                                <h3 class="mb-0">{{$verifiedUsers-1}}</h3>
                                <small class="text-uppercase font-size-xs">Verified Users</small>
                            </div>
                            <div class="ml-3 align-self-center">
                                <i class="fa fa-user-check fa-3x opacity-75"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-md-3 mb-2">
                    <a href="{{route('admin.userManage.index')}}" class="card card-body hover-none"
                         style="background-color: rgb(81, 216, 138); color: rgb(255, 255, 255);box-shadow:1px 5px 8px #3333;">
                        <div class="media">
                            <div class="media-body">
                                <h3 class="mb-0">{{$todayUsers}}</h3>
                                <small class="text-uppercase font-size-xs">Today New Users</small>
                            </div>
                            <div class="ml-3 align-self-center">
                                <i class="fa fa-user-plus fa-3x opacity-75"></i>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-md-3 mb-2">
                    <div class="card card-body"
                         style="background-color: rgb(250, 173, 99); color: rgb(255, 255, 255);box-shadow:1px 5px 8px #3333;">
                        <div class="media">
                            <div class="media-body">
                                <h3 class="mb-0">{{$totalSubscribers}}</h3>
                                <small class="text-uppercase font-size-xs">Total Verified Subscribers</small>
                            </div>
                            <div class="ml-3 align-self-center">
                                <i class="fa fa-users fa-3x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
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
                                @activeModule("advanced_blog")
                                <a href="{{route('admin.blog.post.index')}}#/pending" class="btn m-btn--square  btn-outline-dark m-btn m-btn--custom btn-block white-space-pre-line">
                                    Blog Posts @if($pendingPosts)<div class="float-right"><span class="m-nav__link-badge m-badge m-badge--danger">{{$pendingPosts}}</span></div> @endif
                                </a>
                                @endactiveModule

                                @activeModule(["simple_blog", "advanced_blog"])
                                <a href="{{route('admin.blog.comment.index')}}#/pending" class="btn m-btn--square  btn-outline-dark m-btn m-btn--custom btn-block white-space-pre-line">
                                    Blog Comments @if($pendingComments)<div class="float-right"><span class="m-nav__link-badge m-badge m-badge--danger">{{$pendingComments}}</span></div> @endif
                                </a>
                                @endactiveModule

                                @activeModule("blogAds")
                                <a href="{{route('admin.blogAds.listing.index')}}" class="btn m-btn--square  btn-outline-dark m-btn m-btn--custom btn-block white-space-pre-line">
                                    Blog Ads Listings @if($pendingBlogAdsListings)<div class="float-right"><span class="m-nav__link-badge m-badge m-badge--danger">{{$pendingBlogAdsListings}}</span></div> @endif
                                </a>
                                @endactiveModule

                                @activeModule("siteAds")
                                <a href="{{route('admin.siteAds.listing.index')}}" class="btn m-btn--square  btn-outline-dark m-btn m-btn--custom btn-block white-space-pre-line">
                                    Site Ads Listings @if($pendingSiteAdsListings)<div class="float-right"><span class="m-nav__link-badge m-badge m-badge--danger">{{$pendingSiteAdsListings}}</span></div> @endif
                                </a>
                                @endactiveModule

                                @activeModule("directory")
                                <a href="{{route('admin.directory.listing.index')}}" class="btn m-btn--square  btn-outline-dark m-btn m-btn--custom btn-block white-space-pre-line">
                                    Directory Listings @if($pendingDirectoryListings)<div class="float-right"><span class="m-nav__link-badge m-badge m-badge--danger">{{$pendingDirectoryListings}}</span></div> @endif
                                </a>
                                @endactiveModule

                                @activeModule("directoryAds")
                                <a href="{{route('admin.directoryAds.listing.index')}}" class="btn m-btn--square  btn-outline-dark m-btn m-btn--custom btn-block white-space-pre-line">
                                    Directory Ads Listings @if($pendingDirectoryAdsListings)<div class="float-right"><span class="m-nav__link-badge m-badge m-badge--danger">{{$pendingDirectoryAdsListings}}</span></div> @endif
                                </a>
                                @endactiveModule


{{--                                --}}
{{--                                <a href="{{route('admin.purchase.form.index')}}" class="btn m-btn--square  btn-outline-dark m-btn m-btn--custom btn-block white-space-pre-line">--}}
{{--                                    Purchase Followup Forms @if($pendingForms)<div class="float-right"><span class="m-nav__link-badge m-badge m-badge--danger">{{$pendingForms}}</span></div> @endif--}}
{{--                                </a>--}}
{{--                                <a href="{{route('admin.appointment.listing.index')}}" class="btn m-btn--square  btn-outline-dark m-btn m-btn--custom btn-block white-space-pre-line">--}}
{{--                                    Appointments @if($pendingAppointments)<div class="float-right"><span class="m-nav__link-badge m-badge m-badge--danger">{{$pendingAppointments}}</span></div> @endif--}}
{{--                                </a>--}}
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
                    <div class="m-portlet">
                        <div class="m-portlet__head bg-333">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text text-white">
                                        Opened Tickets ({{$openedTickets->count()}})
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-caption">
                                <a href="{{route('admin.ticket.item.index')}}" class="text-white underline">View All</a>
                            </div>
                        </div>
                        <div class="m-portlet__body p-2 p-md-3">
                            <div class="m-scrollable m-scroller" data-scrollable="true" style="max-height: 400px; overflow: auto;">
                                @forelse($openedTickets as $openedTicket)
                                    <a href="{{route('admin.ticket.item.edit', $openedTicket->id)}}" class="btn m-btn--square  btn-outline-dark m-btn m-btn--custom btn-block white-space-pre-line">
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

                {{--                <div class="col-md-6">--}}
                {{--                    <div class="m-portlet">--}}
                {{--                        <div class="m-portlet__head bg-333">--}}
                {{--                            <div class="m-portlet__head-caption">--}}
                {{--                                <div class="m-portlet__head-title">--}}
                {{--                                    <h3 class="m-portlet__head-text text-white">--}}
                {{--                                        Coming Approved Appointments ({{$comingAppointments->count()}})--}}
                {{--                                    </h3>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                            <div class="m-portlet__head-caption">--}}
                {{--                                <a href="{{route('admin.appointment.listing.index')}}" class="text-white underline">View All</a>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                        <div class="m-portlet__body p-2 p-md-3">--}}
                {{--                            <div class="m-scrollable m-scroller" data-scrollable="true" style="max-height: 400px; overflow: auto;">--}}
                {{--                                @forelse($comingAppointments as $appointment)--}}
                {{--                                    <a href="{{route('admin.appointment.listing.detail', $appointment->id)}}"--}}
                {{--                                       class="btn m-btn--square  btn-outline-dark m-btn m-btn--custom btn-block white-space-pre-line">--}}
                {{--                                        <span class="c-badge c-badge-success white-space-nowrap">{{$appointment->category->name}}</span>--}}
                {{--                                        <span class="c-badge c-badge-info white-space-nowrap"> {{$appointment->date}}</span>--}}
                {{--                                        <span class="c-badge c-badge-warning white-space-nowrap">{{$appointment->start_time}} - {{$appointment->end_time}}</span>--}}
                {{--                                        <span class="c-badge c-badge-info white-space-nowrap">({{$appointment->user->name}})</span>--}}
                {{--                                    </a>--}}
                {{--                                @empty--}}
                {{--                                    <div class="text-center">No coming appointment</div>--}}
                {{--                                @endforelse--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
            </div>
        </div>
    </div>
    <div class="m-portlet m-portlet--mobile tab_area" id="analytics_area">
        <div class="m-portlet__body">
            @if(optional(option("google_services"))['ga_view_id']&&optional(option("google_services"))['ga_file'])
                <x-admin.analytics></x-admin.analytics>
            @else
                <div class="alert alert-primary  m-alert m-alert--air m-alert--outline text-dark" role="alert">
                    You didn't set google analytics yet. If you would like to set it, please fill <a href="{{route('admin.setting.analytics.index')}}">this form</a>.
                </div>
            @endif
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('assets/js/admin/dashboard.js')}}"></script>
    <script src="{{asset('assets/vendors/chart/chart.min.js')}}"></script>
    @if(optional(option("google_services"))['ga_view_id']&&optional(option("google_services"))['ga_file'])
        <script src="{{asset('assets/js/admin/analytics.js')}}"></script>
    @endif
@endsection
