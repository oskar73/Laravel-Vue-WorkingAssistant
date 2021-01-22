@if(isset($meta_description)) <meta name="description" content="{{$meta_description}}">@endif
@if(isset($meta_keywords)) <meta name="keywords" content="{{$meta_keywords}}">@endif
<link rel="canonical" href="{{url()->current()}}"/>

@if(isset($meta_title)) <meta property="og:title" content="{{$meta_title}}" />@endif
@if(isset($meta_description)) <meta property="og:description" content="{{$meta_description}}" />@endif
@if(isset($meta_type)) <meta property="og:type" content="{{$meta_type}}" />@endif
<meta property="og:url" content="{{url()->current()}}" />
@if(isset($meta_image)) <meta property="og:image" content="{{$meta_image}}" />@endif

@if(isset($meta_title)) <meta name="twitter:title" content="{{$meta_title}}" />@endif
@if(isset($meta_description)) <meta name="twitter:description" content="{{$meta_description}}" />@endif
<meta name="twitter:url" content="{{url()->current()}}" />
@if(isset($meta_type)) <meta name="twitter:card" content="{{$meta_type}}" />@endif
@if(isset($meta_image)) <meta name="twitter:image" content="{{$meta_image}}" /> @endif
