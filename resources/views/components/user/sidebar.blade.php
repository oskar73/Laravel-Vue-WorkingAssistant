<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
    <i class="la la-close"></i>
</button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-light ">

@php
$quickTourItems = App\Models\QuickTour::where('status', 1)->orderBy('order')->get();
$quickTourItemsFormatted = [];
foreach ($quickTourItems as $index => $item) {
    $quickTourItemsFormatted[$item->targetID] = $item;
}
@endphp
    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-light m-aside-menu--submenu-skin-light position-static" m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500">
        <ul class="m-menu__nav ">
{{--            <li id="getting-started" class="m-menu__item {{ Request::is('account/started*') ? 'm-menu__item--active ' : '' }}" aria-haspopup="true">--}}
{{--                <a href="{{route('user.started')}}" class="m-menu__link ">--}}
{{--                    <span class="m-menu__item-here"></span>--}}
{{--                    <i class="m-menu__link-icon">--}}
{{--                        <img src="{{asset('assets/img/dashboard.svg')}}" alt="">--}}
{{--                    </i>--}}
{{--                    <span class="m-menu__link-text" style="color:#0cabf0 !important;font-size:16px;"><b>Getting Started</b></span>--}}
{{--                </a>--}}
{{--            </li>--}}

            @php
                $menuID = \Str::slug('My TODO List');
                $quickTourItem = isset($quickTourItemsFormatted[$menuID]) ? $quickTourItemsFormatted[$menuID] : null;
            @endphp
            <li id="my-todo-list" class="m-menu__item {{ Request::is('account/todo*') ? 'm-menu__item--active ' : '' }}" aria-haspopup="true" @if( $quickTourItem ) data-title="{{$quickTourItem->title}}" data-intro="{{ $quickTourItem->description }}" data-step="{{ $quickTourItem->order }}" @endif >
                <a href="{{route('user.todo.index')}}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-list-3"></i>
                    <span class="m-menu__link-text todo_list_font"><b>My TODO List</b></span>
                    <span class="m-badge m-badge--danger mr-1 sidebar_todo_count"></span>
                </a>
            </li>

            @php
                $menuID = \Str::slug('Dashboard');
                $quickTourItem = isset($quickTourItemsFormatted[$menuID]) ? $quickTourItemsFormatted[$menuID] : null;
            @endphp
            <li id="dashboard" class="m-menu__item {{ Request::is('account/dashboard*') ? 'm-menu__item--active ' : '' }}" aria-haspopup="true" @if( $quickTourItem ) data-title="{{$quickTourItem->title}}" data-intro="{{ $quickTourItem->description }}" data-step="{{ $quickTourItem->order }}" @endif >
                <a href="{{route('user.dashboard')}}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon">
                        <img src="{{asset('assets/img/dashboard.svg')}}" alt="">
                    </i>
                    <span class="m-menu__link-text">Dashboard</span>
                </a>
            </li>

            @publishedModule("advanced_blog")
            @php
                $menuID = \Str::slug('Blog Posts');
                $quickTourItem = isset($quickTourItemsFormatted[$menuID]) ? $quickTourItemsFormatted[$menuID] : null;
            @endphp
            <li id="blog-posts" class="m-menu__item {{ Request::is('account/blog*') && !Request::is('account/blogAds*')? 'm-menu__item--active' : '' }}" aria-haspopup="true" @if( $quickTourItem ) data-title="{{$quickTourItem->title}}" data-intro="{{ $quickTourItem->description }}" data-step="{{ $quickTourItem->order }}" @endif >
                <a href="{{route('user.blog.index')}}" class="m-menu__link" >
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">Blog Posts</span>
                </a>
            </li>
            @endpublishedModule

            @publishedModule("blogAds")
            @php
                $menuID = \Str::slug('Blog Ads Listings');
                $quickTourItem = isset($quickTourItemsFormatted[$menuID]) ? $quickTourItemsFormatted[$menuID] : null;
            @endphp
            <li id="blog-ads-listings" class="m-menu__item {{ Request::is('account/blogAds*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true" @if( $quickTourItem ) data-title="{{$quickTourItem->title}}" data-intro="{{ $quickTourItem->description }}" data-step="{{ $quickTourItem->order }}" @endif >
                <a href="{{route('user.blogAds.index')}}" class="m-menu__link" >
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">Blog Ads Listings</span>
                </a>
            </li>
            @endpublishedModule

            @publishedModule("blogAds")
            @php
                $menuID = \Str::slug('Site Ads Listings');
                $quickTourItem = isset($quickTourItemsFormatted[$menuID]) ? $quickTourItemsFormatted[$menuID] : null;
            @endphp
            <li id="site-ads-listings" class="m-menu__item {{ Request::is('account/siteAds*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true" @if( $quickTourItem ) data-title="{{$quickTourItem->title}}" data-intro="{{ $quickTourItem->description }}" data-step="{{ $quickTourItem->order }}" @endif >
                <a href="{{route('user.siteAds.index')}}" class="m-menu__link" >
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">Site Ads Listings</span>
                </a>
            </li>
            @endpublishedModule

            @publishedModule("directory")
            @php
                $menuID = \Str::slug('Directory Listings');
                $quickTourItem = isset($quickTourItemsFormatted[$menuID]) ? $quickTourItemsFormatted[$menuID] : null;
            @endphp
            <li id="directory-listings" class="m-menu__item {{ Request::is('account/directory*') && !Request::is('account/directoryAds*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true" @if( $quickTourItem ) data-title="{{$quickTourItem->title}}" data-intro="{{ $quickTourItem->description }}" data-step="{{ $quickTourItem->order }}" @endif >
                <a href="{{route('user.directory.index')}}" class="m-menu__link" >
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">Directory Listings</span>
                </a>
            </li>
            @endpublishedModule

            @publishedModule("directoryAds")
            @php
                $menuID = \Str::slug('Directory Ads Listings');
                $quickTourItem = isset($quickTourItemsFormatted[$menuID]) ? $quickTourItemsFormatted[$menuID] : null;
            @endphp
            <li id="directory-ads-listings" class="m-menu__item {{ Request::is('account/directoryAds*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true" @if( $quickTourItem ) data-title="{{$quickTourItem->title}}" data-intro="{{ $quickTourItem->description }}" data-step="{{ $quickTourItem->order }}" @endif >
                <a href="{{route('user.directoryAds.index')}}" class="m-menu__link" >
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">Directory Ads Listings</span>
                </a>
            </li>
            @endpublishedModule

            @publishedModule("ecommerce")
            @php
                $menuID = \Str::slug('Ecommerce Products');
                $quickTourItem = isset($quickTourItemsFormatted[$menuID]) ? $quickTourItemsFormatted[$menuID] : null;
            @endphp
            <li id="ecommerce-products" class="m-menu__item {{ Request::is('account/ecommerce*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true" @if( $quickTourItem ) data-title="{{$quickTourItem->title}}" data-intro="{{ $quickTourItem->description }}" data-step="{{ $quickTourItem->order }}" @endif >
                <a href="{{route('user.ecommerce.index')}}" class="m-menu__link" >
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">Ecommerce Products</span>
                </a>
            </li>
            @endpublishedModule

            @publishedModule("appointment")
            @php
                $menuID = \Str::slug('Appointments');
                $quickTourItem = isset($quickTourItemsFormatted[$menuID]) ? $quickTourItemsFormatted[$menuID] : null;
            @endphp
            <li id="appointments" class="m-menu__item {{ Request::is('account/appointment*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true" @if( $quickTourItem ) data-title="{{$quickTourItem->title}}" data-intro="{{ $quickTourItem->description }}" data-step="{{ $quickTourItem->order }}" @endif >
                <a href="{{route('user.appointment.index')}}" class="m-menu__link" >
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">Appointments</span>
                </a>
            </li>
            @endpublishedModule
            @publishedModule("ticket")
            @php
                $menuID = \Str::slug('Tickets');
                $quickTourItem = isset($quickTourItemsFormatted[$menuID]) ? $quickTourItemsFormatted[$menuID] : null;
            @endphp
            <li id="tickets" class="m-menu__item {{ Request::is('account/ticket*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true" @if( $quickTourItem ) data-title="{{$quickTourItem->title}}" data-intro="{{ $quickTourItem->description }}" data-step="{{ $quickTourItem->order }}" @endif >
                <a href="{{route('user.ticket.index')}}" class="m-menu__link" >
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">Tickets</span>
                </a>
            </li>
            @endpublishedModule

            @php
                $menuID = \Str::slug('Purchase Management');
                $quickTourItem = isset($quickTourItemsFormatted[$menuID]) ? $quickTourItemsFormatted[$menuID] : null;
            @endphp
            <li id="purchase-management" class="m-menu__item  {{ Request::is('account/purchase*') ? 'm-menu__item--open m-menu__item--active' : '' }} m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover" @if( $quickTourItem ) data-title="{{$quickTourItem->title}}" data-intro="{{ $quickTourItem->description }}" data-step="{{ $quickTourItem->order }}" @endif >
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">Purchase Management</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true">
                            <span class="m-menu__link">
                                <span class="m-menu__item-here"></span>
                                <span class="m-menu__link-text">Purchase Management</span>
                            </span>
                        </li>
                        <li class="m-menu__item {{ Request::is('account/purchase/order*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('user.purchase.order.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Orders</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('account/purchase/subscription*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('user.purchase.subscription.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Subscriptions</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('account/purchase/transaction*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('user.purchase.transaction.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Transactions</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('account/purchase/form*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('user.purchase.form.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Forms</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('account/purchase/product*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('user.purchase.product.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Products</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            @php
                $menuID = \Str::slug('Log out');
                $quickTourItem = isset($quickTourItemsFormatted[$menuID]) ? $quickTourItemsFormatted[$menuID] : null;
            @endphp
            <li id="log-out" class="m-menu__item" aria-haspopup="true" @if( $quickTourItem ) data-title="{{$quickTourItem->title}}" data-intro="{{ $quickTourItem->description }}" data-step="{{ $quickTourItem->order }}" @endif >
                <a href="javascript:void(0);" class="m-menu__link" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon fa fa-sign-out-alt"></i>
                    <span class="m-menu__link-text">Log out</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- END: Aside Menu -->
</div>

<!-- END: Left Aside -->
