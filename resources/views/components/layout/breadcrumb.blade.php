@props(["menus"=>[], "menuLinks"=>[]])
<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
    <li class="m-nav__item m-nav__item--home">
        <a href="" class="m-nav__link m-nav__link--icon">
            <i class="m-nav__link-icon la la-home"></i>
        </a>
    </li>
    @foreach($menus as $key=>$menu)
    <li class="m-nav__separator">/</li>
    <li class="m-nav__item">
        <a href="{{$menuLinks[$key]?? ''}}" class="m-nav__link">
            <span class="m-nav__link-text">{{$menu}}</span>
        </a>
    </li>
    @endforeach
</ul>
