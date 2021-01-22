<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn">
    <i class="la la-close"></i>
</button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-light ">

    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-light m-aside-menu--submenu-skin-light position-static" m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500">
        <ul class="m-menu__nav ">

            <li class="m-menu__item {{ Request::is('admin/todo*') ? 'm-menu__item--active ' : '' }}" aria-haspopup="true">
                <a href="{{route('admin.todo.index')}}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-list-3"></i>
                    <span class="m-menu__link-text todo_list_font"><b>TODO List</b></span>
                    <span class="m-badge m-badge--danger mr-1 sidebar_todo_count" style="display:none;"></span>
                </a>
            </li>

            <li class="m-menu__item {{ Request::is('admin/dashboard*') ? 'm-menu__item--active ' : '' }}" aria-haspopup="true">
                <a href="{{route('admin.dashboard')}}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon">
                        <img src="{{asset('assets/img/dashboard.svg')}}" alt="">
                    </i>
                    <span class="m-menu__link-text">Dashboard</span>
                </a>
            </li>

            <li class="m-menu__item {{ Request::is('admin/quick-tours*') ? 'm-menu__item--active ' : '' }}" aria-haspopup="true">
                <a href="{{route('admin.quick-tours.index')}}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">Quick Tour</span>
                </a>
            </li>

            <li class="m-menu__item  {{ Request::is('admin/setting/*') ? 'm-menu__item--open m-menu__item--active ' : '' }} m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">Setting</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true">
                            <span class="m-menu__link">
                                <span class="m-menu__item-here"></span>
                                <span class="m-menu__link-text">Setting</span>
                            </span>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/setting/basic*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.setting.basic.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Basic Setting</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/setting/social*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.setting.social.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Social Login</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/setting/seo*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.setting.seo.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">SEO Setting</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/setting/script*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.setting.script.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Custom Script</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/setting/analytics*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.setting.analytics.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Google Analytics</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/setting/color*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.setting.color.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Color Setting</span>
                            </a>
                        </li>
                        {{-- <li class="m-menu__item {{ Request::is('admin/setting/payment*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.setting.payment.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Payment Setting</span>
                            </a>
                        </li> --}}
                    </ul>
                </div>
            </li>
            <li class="m-menu__item {{ Request::is('admin/purchase/*') ? 'm-menu__item--active m-menu__item--open' : '' }} m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover" m-menu-link-redirect="1">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">Purchase Management</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item {{ Request::is('admin/purchase/order*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.purchase.order.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Orders</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/purchase/subscription*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.purchase.subscription.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Subscriptions</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/purchase/transaction*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.purchase.transaction.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Transactions</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/purchase/form*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.purchase.form.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Submitted Forms</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is(['admin/purchase/blog*', 'admin/purchase/directory*', 'admin/purchase/ecommerce*']) ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.purchase.blog.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">User Products</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            @activeModule(["simple_blog", "advanced_blog"])
            <li class="m-menu__item {{ Request::is('admin/blog/*') ? 'm-menu__item--active m-menu__item--open' : '' }} m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover" m-menu-link-redirect="1">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">Blog</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item {{ Request::is('admin/blog/front*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.blog.front.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Front Setting</span>
                            </a>
                        </li>
                        @activeModule("advanced_blog")
                        <li class="m-menu__item {{ Request::is('admin/blog/setting*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.blog.setting.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Blogging Setting</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/blog/package*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.blog.package.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Packages</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/blog/author*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.blog.author.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Authors</span>
                            </a>
                        </li>
                        @endactiveModule
                        <li class="m-menu__item {{ Request::is('admin/blog/category*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.blog.category.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Categories</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/blog/tag*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.blog.tag.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Tags</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/blog/post*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.blog.post.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Posts</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/blog/comment*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.blog.comment.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Comments</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endactiveModule

            @activeModule("blogAds")
            <li class="m-menu__item {{ Request::is('admin/blogAds/*') ? 'm-menu__item--active m-menu__item--open' : '' }} m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover" m-menu-link-redirect="1">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">Blog Advertisement</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item {{ Request::is('admin/blogAds/front*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.blogAds.front.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Front Setting</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/blogAds/type*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.blogAds.type.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Ads Types</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/blogAds/position*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.blogAds.position.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Ads Positions</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/blogAds/spot*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.blogAds.spot.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Ads Spots</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/blogAds/listing*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.blogAds.listing.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Ads Listings</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endactiveModule

            @activeModule("siteAds")
            <li class="m-menu__item {{ Request::is('admin/siteAds/*') ? 'm-menu__item--active m-menu__item--open' : '' }} m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover" m-menu-link-redirect="1">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">Site Advertisement</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item {{ Request::is('admin/siteAds/front*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.siteAds.front.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Front Setting</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/siteAds/type*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.siteAds.type.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Ads Types</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/siteAds/spot*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.siteAds.spot.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Ads Spots</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/siteAds/listing*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.siteAds.listing.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Ads Listings</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endactiveModule

            @activeModule("email")
            <li class="m-menu__item {{ Request::is('admin/email/*') ? 'm-menu__item--active m-menu__item--open' : '' }} m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover" m-menu-link-redirect="1">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">Email Campaign</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item {{ Request::is('admin/email/category*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.email.category.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Category</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/email/template*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.email.template.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Templates</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/email/campaign*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.email.campaign.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Campaigns</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/email/subscriber*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.email.subscriber.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Subscribers</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endactiveModule

            @activeModule("directory")
            <li class="m-menu__item {{ Request::is('admin/directory/*') ? 'm-menu__item--active m-menu__item--open' : '' }} m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover" m-menu-link-redirect="1">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">Directory Listing</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item {{ Request::is('admin/directory/front*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.directory.front.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Front Setting</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/directory/setting*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.directory.setting.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Directory Setting</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/directory/category*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.directory.category.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Categories</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/directory/tag*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.directory.tag.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Tags</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/directory/package*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.directory.package.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Packages</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/directory/listing*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.directory.listing.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Listings</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endactiveModule

            @activeModule("directoryAds")
            <li class="m-menu__item {{ Request::is('admin/directoryAds/*') ? 'm-menu__item--active m-menu__item--open' : '' }} m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover" m-menu-link-redirect="1">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">Directory Advertisement</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item {{ Request::is('admin/directoryAds/front*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.directoryAds.front.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Front Setting</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/directoryAds/type*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.directoryAds.type.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Ads Types</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/directoryAds/position*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.directoryAds.position.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Ads Positions</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/directoryAds/spot*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.directoryAds.spot.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Ads Spots</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/directoryAds/listing*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.directoryAds.listing.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Listings</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endactiveModule

            @publishedModule("ecommerce")
            <li class="m-menu__item {{ Request::is('admin/ecommerce/*') ? 'm-menu__item--active m-menu__item--open' : '' }} m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover" m-menu-link-redirect="1">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">Ecommerce Store</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item {{ Request::is('admin/ecommerce/front*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.ecommerce.front.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Front Setting</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/ecommerce/category*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.ecommerce.category.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Categories</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/ecommerce/product*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.ecommerce.product.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Products</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/ecommerce/customer*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.ecommerce.customer.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Customers</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/ecommerce/order*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.ecommerce.order.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Orders</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/ecommerce/payment*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.ecommerce.payment.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Payments</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/ecommerce/setting*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.ecommerce.setting.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Setting</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endpublishedModule

            <li class="m-menu__item {{ Request::is('admin/content*')? 'm-menu__item--active m-menu__item--open' : '' }} m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover" m-menu-link-redirect="1">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">Content Management</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item {{ Request::is('admin/content/header*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.content.header.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Header Items</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/content/footer*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.content.footer.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Footer Design</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/content/page*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.content.page.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Pages</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/content/legalPage*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.content.legalPage.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Legal Pages</span>
                            </a>
                        </li>

                        @activeModule("review")
                        <li class="m-menu__item {{ Request::is('admin/content/review*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.content.review.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Reviews</span>
                            </a>
                        </li>
                        @endactiveModule
                    </ul>
                </div>
            </li>

            @activeModule("portfolio")
            <li class="m-menu__item {{ Request::is('admin/portfolio*') ? 'm-menu__item--active m-menu__item--open' : '' }} m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover" m-menu-link-redirect="1">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">Portfolio</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item {{ Request::is('admin/portfolio/front*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.portfolio.front.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Front Setting</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/portfolio/category*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.portfolio.category.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Category</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/portfolio/item*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.portfolio.item.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Items</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endactiveModule

            @activeModule("appointment")
            <li class="m-menu__item {{ Request::is('admin/appointment*') ? 'm-menu__item--active m-menu__item--open' : '' }} m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover" m-menu-link-redirect="1">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">Appointments</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        {{-- <li class="m-menu__item {{ Request::is('admin/appointment/setting*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.appointment.setting.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Available Dates</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/appointment/unavailable-dates*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.appointment.blockDate.index', ["type"=>"appointment", "id"=>0])}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Unavailable Dates</span>
                            </a>
                        </li> --}}
                        <li class="m-menu__item {{ Request::is('admin/appointment/category*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.appointment.category.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Category</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/appointment/listing*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.appointment.listing.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Listings</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endactiveModule

            @activeModule("ticket")
            <li class="m-menu__item {{ Request::is('admin/ticket*') ? 'm-menu__item--active m-menu__item--open' : '' }} m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover" m-menu-link-redirect="1">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">Tickets</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item {{ Request::is('admin/ticket/category*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.ticket.category.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Category</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/ticket/item*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.ticket.item.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Tickets</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endactiveModule

            <li class="m-menu__item {{ Request::is('admin/purchasefollowup*') || Request::is('admin/coupon*') ? 'm-menu__item--active m-menu__item--open' : '' }} m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover" m-menu-link-redirect="1">
                <a href="javascript:;" class="m-menu__link m-menu__toggle">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">Purchase Follow-up</span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu ">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item {{ Request::is('admin/purchasefollowup/email*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.purchasefollowup.email.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Emails</span>
                            </a>
                        </li>
                        <li class="m-menu__item {{ Request::is('admin/purchasefollowup/form*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">
                            <a href="{{route('admin.purchasefollowup.form.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">Forms</span>
                            </a>
                        </li>
{{--                        <li class="m-menu__item {{ Request::is('admin/coupon*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true">--}}
{{--                            <a href="{{route('admin.coupon.index')}}" class="m-menu__link ">--}}
{{--                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">--}}
{{--                                    <span></span>--}}
{{--                                </i>--}}
{{--                                <span class="m-menu__link-text">Coupon</span>--}}
{{--                            </a>--}}
{{--                        </li>--}}

                    </ul>
                </div>
            </li>
            <li class="m-menu__item {{ Request::is('admin/userManage*') ? 'm-menu__item--active ' : '' }}" aria-haspopup="true">
                <a href="{{route('admin.userManage.index')}}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">User Management</span>
                </a>
            </li>
            <li class="m-menu__item {{ Request::is('admin/notification/template*') ? 'm-menu__item--active ' : '' }}" aria-haspopup="true">
                <a href="{{route('admin.notification.template.index')}}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">Notification Management</span>
                </a>
            </li>
            <li class="m-menu__item {{ Request::is('admin/storage*') ? 'm-menu__item--active ' : '' }}" aria-haspopup="true">
                <a href="{{route('admin.storage.index')}}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">Storage Management</span>
                </a>
            </li>
            <li class="m-menu__item {{ Request::is('admin/module*') ? 'm-menu__item--active ' : '' }}" aria-haspopup="true">
                <a href="{{route('admin.module.index')}}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">Module Management</span>
                </a>
            </li>
            <li class="m-menu__item {{ Request::is('admin/contacts*') ? 'm-menu__item--active ' : '' }}" aria-haspopup="true">
                <a href="{{route('admin.contacts.index')}}" class="m-menu__link ">
                    <span class="m-menu__item-here"></span>
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">Contacts</span>
                </a>
            </li>
            <li class="m-menu__item" aria-haspopup="true">
                <a href="javascript:void(0);" class="m-menu__link" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="m-menu__link-icon fa fa-sign-out-alt"></i>
                    <span class="m-menu__link-text">Log out</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- END: Aside Menu -->
</div>

<!-- END: Left Aside -->
