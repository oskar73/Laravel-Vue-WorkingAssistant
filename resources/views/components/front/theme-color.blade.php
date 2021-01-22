<style id="s_theme_color">
    :root {
        --second-color: #{{$theme_color['second']?? ''}};
    }
    .themecolor{
        background-color:#{{$theme_color['primary']?? ''}} !important;
        color:#{{$theme_color['theme_font']?? ''}} !important;
    }
    .themefont {
        color:#{{$theme_color['font']?? ''}} !important;
    }
    body{
        color:#{{$theme_color['font']?? ''}} !important;
        background-color:#{{$theme_color['background']?? ''}} !important;
    }
    a, a:hover, a:active, a:visited, a:focus {
        color:#{{$theme_color['link']?? ''}} !important;
    }
    a:hover {
        color:#{{$theme_color['link']?? ''}} !important;
    }
    .favorite_posts .thumb-icon, .favorite_posts .clap_area, .favorite_posts, .color-primary, .icon_color {
        color:#{{$theme_color['active_icon']?? ''}} !important;
        border-color:#{{$theme_color['active_icon']?? ''}} !important;
    }
</style>
