<!-- BEGIN: Header -->
<header id="m_header" class="m-grid__item    m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
    <div class="m-container m-container--fluid m-container--full-height">
        <div class="m-stack m-stack--ver m-stack--desktop">

            <!-- BEGIN: Brand -->
            <div class="m-stack__item m-brand  m-brand--skin-dark ">
                <div class="m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-stack__item--middle m-brand__logo text-center">
                        <a href="{{route('home')}}" class="m-brand__logo-wrapper">
                            <img alt="Logo" src="{{ empty($website->logo) ? asset('assets/img/default_logo.png') : $website->logo }}" class="maxw-100 pt-1 maxh-70px"/>
                        </a>
                    </div>
                    <div class="m-stack__item m-stack__item--middle m-brand__tools">

                        <!-- BEGIN: Left Aside Minimize Toggle -->
                        <a href="javascript:;" id="m_aside_left_minimize_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block  ">
                            <span></span>
                        </a>

                        <!-- END -->

                        <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                        <a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>

                        <!-- END -->


                        <!-- BEGIN: Topbar Toggler -->
                        <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                            <i class="flaticon-more"></i>
                        </a>

                        <!-- BEGIN: Topbar Toggler -->
                    </div>
                </div>
            </div>

            <!-- END: Brand -->
            <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">

                <!-- BEGIN: Horizontal Menu -->
                <button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-dark " id="m_aside_header_menu_mobile_close_btn">
                    <i class="la la-close"></i>
                </button>

                <div class="m-topbar float-left d-flex align-items-center ml-lg-5">
                    <div class="m-auto position-relative header_search_div">
                        <i class="fa fa-search position-absolute" style=""></i>
                        <input type="text" class="form-control" placeholder="Press Ctrl + / to search" id="header_search">
                    </div>
                </div>
                <!-- BEGIN: Topbar -->
                <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-topbar__nav-wrapper">
                        <ul class="m-topbar__nav m-nav m-nav--inline">


                            <x-account.notification></x-account.notification>

                            <li class="m-nav__item m-topbar__user-profile  m-dropdown m-dropdown--medium m-dropdown--arrow  m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light pr-0" m-dropdown-toggle="click" style="margin-right:10px;">
                                <a href="#" class="m-nav__link m-dropdown__toggle">
                                    <div class="m-topbar-dropdown_area">
                                        <span class="m-topbar__userpic">
                                            <img src="{{user()->avatar()}}"
                                                 class="m--img-rounded m--marginless m--img-centered" alt="avatar" />
                                        </span>
                                        <span class="m-topbar__name">
                                            {{user()->name}} <i class="fa fa-angle-down"></i>
                                        </span>
                                    </div>
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                    <div class="m-dropdown__inner profile-dropdown">
                                        <div class="m-dropdown__header m--align-center">
                                            <div class="m-card-user m-card-user--skin-light">
                                                <div class="m-card-user__details">
                                                    <span class="m-card-user__name m--font-weight-500">{{user()->name}}</span>
                                                    <a href="" class="m-card-user__email m--font-weight-300 m-link">{{user()->email}}</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="m-nav header_menu_dropdown">
                                                    @if(user()->hasRole('admin'))
                                                        <a href="{{route('admin.dashboard')}}" class="m-btn btn-outline-info btn btn-sm mb-1">Admin Area</a>
                                                    @endif
                                                    @if(user()->hasRole('employee'))
                                                        <a href="#" class="m-btn btn-outline-info btn btn-sm mb-1">Employee Area</a>
                                                    @endif
                                                    @if(user()->hasRole('client'))
                                                        <a href="#" class="m-btn btn-outline-info btn btn-sm mb-1">Client Area</a>
                                                    @endif
                                                    @if(user()->hasAnyRole(['admin', 'employee', 'client']))
                                                        <a href="{{route('user.dashboard')}}" class="m-btn btn-outline-info btn btn-sm mb-1">User Area</a>
                                                        <hr>
                                                    @endif
                                                    <li class="m-nav__item">
                                                        <a href="/{{user()->hasRole('admin') ? 'admin': 'account'}}/profile">
                                                            Profile & Security
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="/{{user()->hasRole('admin') ? 'admin': 'account'}}/notifications">
                                                            Notifications
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="/{{user()->hasRole('admin') ? 'admin': 'account'}}/subscribed">
                                                            Subscribed Status
                                                        </a>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="javascript:void(0);" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                            Log Out
                                                        </a>
                                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                            @csrf
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li id="m_quick_sidebar_toggle1" class="m-nav__item">
                                <a href="#" class="m-nav__link m-dropdown__toggle" title="Todo List">
                                <span class="m-nav__link-icon">
                                    <i class="flaticon-list"></i>
                                </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- END: Topbar -->
            </div>
        </div>
    </div>
</header>
<!-- END: Header -->
