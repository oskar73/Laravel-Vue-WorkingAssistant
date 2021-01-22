<li class="m-nav__item m-topbar__notifications m-dropdown m-dropdown--large m-dropdown--arrow m-dropdown--align-center 	m-dropdown--mobile-full-width" m-dropdown-toggle="click" m-dropdown-persistent="1" >
    <a href="#" class="m-nav__link m-dropdown__toggle" id="m_topbar_notification_icon">
        <span class="m-nav__link-icon">
            <span class="m-nav__link-icon-wrapper">
                <i class="flaticon-alarm"></i>
            </span>
            @if($unreads->count())<span class="m-nav__link-badge m-badge m-badge--danger">{{$unreads->count()}}</span>@endif
        </span>
    </a>
    <div class="m-dropdown__wrapper ">
        <span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
        <div class="m-dropdown__inner border-bottom-radius-20">
            <div class="m-dropdown__header m--align-center">
                @if($unreads->count())<span class="m-dropdown__header-title">{{$unreads->count()}} New</span>@endif
                <a href="/{{user()->hasRole('admin') ? 'admin': 'account'}}/notifications" class="m-dropdown__header-subtitle">View all notifications</a>
            </div>
            <div class="m-dropdown__body border-bottom-radius-20">
                <div class="m-dropdown__content">
                    <div class="m-scrollable" data-scrollable="true" data-max-height="200" style="max-height:200px;">
                        <div class="m-list-timeline m-list-timeline--skin-light">
                            <div class="m-list-timeline__items">
                                @forelse($unreads as $unread)
                                    <div class="m-list-timeline__item">
                                        <span class="m-list-timeline__badge"></span>
                                        <a href="{{route('notification.detail', ['id'=>$unread->id, 'role'=>user()->hasRole("admin")?'admin':'account'])}}" class="m-list-timeline__text hover-underline">{{$unread->data['subject']}}</a>
                                        <span class="m-list-timeline__time">{{$unread->created_at->diffForHumans()}}</span>
                                    </div>
                                @empty
                                    <div class="m-list-timeline__item">
                                        <a href="javascript:void(0);" class="m-list-timeline__text text-center">No new notification</a>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</li>
