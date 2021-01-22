@extends('layouts.app')

@section('title', 'Portfolios')

@section('style')
@endsection
@section('content')
    <x-front.portfolio-hero></x-front.portfolio-hero>

    <div class="container container-lg">
        <div class="row">
            <div class="col-lg-3  pt-5">
                <form class="quform newsletter-form w-sm-90 mx-auto mx-lg-0" action="" method="post" enctype="multipart/form-data">
                    <div class="quform-elements">
                        <div class="quform-element mb-4">
                            <div class="quform-input">
                                <input class="form-control" id="keyword" type="text" name="keyword" placeholder="Search..." autocomplete="off">
                                <div class="quform-submit-inner">
                                    <button class="btn text-theme-color m-0" type="button">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="filter-widget mb-0 filter-box">
                    <p class="view_by_txt mb-2">Filter by</p>
                    <div class="fw-size-choose fw-filter-choose">
                        <div class="sc-item">
                            <input type="radio" name="filterBy" id="sort-featured" value="featured" checked>
                            <label for="sort-featured"><span>Featured</span></label>
                        </div>
                        <div class="sc-item">
                            <input type="radio" name="filterBy" id="sort-new" value="new">
                            <label for="sort-new"><span>New</span></label>
                        </div>
                        <div class="sc-item">
                            <input type="radio" name="filterBy" id="sort-popular" value="popular">
                            <label for="sort-popular"><span>Most Popular</span></label>
                        </div>
                    </div>
                </div>
                <div class="filter-widget">
                    <p class="view_by_txt">Filter by Category</p>
                    <ul class="category-menu">
                        <li class="all"><a href="#/all">All Categories</a></li>
                        @foreach($categories as $key=>$category)
                            <li class="{{$category->slug}}">
                                <a href="#/{{$category->slug}}">{{$category->name}}</a>
                                @if($category->approvedSubCategories->count()!==0)
                                    <ul class="sub-menu">
                                        @foreach($category->approvedSubCategories as $subcat)
                                            <li class="{{$subcat->slug}}">
                                                <a href="#/{{$category->slug}}/{{$subcat->slug}}">{{$subcat->name}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg-9 pt-5 pb-5">
                <div class="items_result">
                    <div class="text-center minh-100 pt-5"><i class="fa fa-spinner fa-spin fa-3x"></i></div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>var portfolio_url = "{{route('portfolio.index')}}"</script>
    <script src="{{asset('assets/js/front/portfolio/index.js')}}"></script>
@endsection
