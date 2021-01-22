<div>

    <div class="page-nav-info bg-theme" x-data="{c_modal:false,c_cat:{img:null,name:null,slug:null,desc:null},t_modal:false,s_modal:false}">
        <ul class="list-style-none text-center">
            <li class="d-inline-block m-2"><a href="javascript:void(0);" class="text-white" x-on:click="c_modal=true">Categories</a></li>
            <li class="d-inline-block m-2"><a href="javascript:void(0);" class="text-white" x-on:click="t_modal=true">Tags</a></li>
            @if(in_array("directoryAds", tenant("p_modules")))
                <li class="d-inline-block m-2"><a href="{{route('directoryAds.index')}}" class="text-white">Directory Ads</a></li>
            @endif
            <li class="d-inline-block m-2"><a href="javascript:void(0);" class="text-white" x-on:click="s_modal=!s_modal">Search</a></li>
            <li class="d-inline-block m-2"><a href="{{route('directory.package')}}" class="text-white">Packages</a></li>
        </ul>
        <template
            x-if="s_modal"
        >
            <div class="d-flex mb-3"
            >
                <div class="m-auto pb-3 blog_search_box">
                    <input type="text" id="directory_search_input" class="blog_search_input" placeholder="Type keyword...">
                </div>
            </div>
        </template>
        <template
            x-if="c_modal"
        >
            <div class="c_modal_bg custom-scroll-h" style="min-height:100vh;"

            >
                <span class="position-fixed h-cursor text-white font-size40 c_modal_close" x-on:click="c_modal=!c_modal">&times;</span>
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 order-2 order-md-1">
                            <h5 class="text-white h5">Categories</h5>
                            <ul class="list-style-none mb-0 custom-scroll-h c_modal_item_list_ul">
                                @foreach($categories as $category)
                                    <li>
                                        <a href="{{route('directory.category', $category->slug)}}"
                                           x-on:mouseenter="c_cat.name='{{$category->name}}'; c_cat.slug='{{$category->slug}}';c_cat.img='{{$category->getFirstMediaUrl("image")}}';c_cat.desc=`{{$category->description}}`"
                                           x-bind:class="{'active':c_cat.slug=='{{$category->slug}}'}"
                                        >
                                            {{$category->name}}
                                        </a>
                                    </li>
                                    @foreach($category->approvedSubCategories as $subcat)
                                        <li>
                                            <a href="{{route('directory.subCategory', ['category'=>$category->slug, 'subCategory'=>$subcat->slug])}}"
                                               x-on:mouseenter="c_cat.name='{{$subcat->name}}'; c_cat.slug='{{$subcat->slug}}';c_cat.img='{{$subcat->getFirstMediaUrl("image")}}';c_cat.desc=`{{$subcat->description}}`"
                                               x-bind:class="{'active':c_cat.slug=='{{$subcat->slug}}'}"
                                            >
                                              &nbsp;&nbsp;&nbsp;  &rarr; {{$subcat->name}}
                                            </a>
                                        </li>

                                    @endforeach
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-9 order-1 order-md- mb-3">
                            <div >
                                <div class="text-center">
                                    <h3 class="mb-3 text-white" x-text="c_cat.name"></h3>
                                </div>
                                <img x-bind:src="c_cat.img" class="w-100">
                                <p x-text="c_cat.desc" class="mt-3 text-white"></p>
                                <hr class="border-top-1px-white">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <template
            x-if="t_modal"
        >
            <div class="c_modal_bg custom-scroll-h" style="min-height:100vh;"
            >
                <span class="position-fixed h-cursor text-white font-size40 c_modal_close" x-on:click="t_modal=!t_modal">&times;</span>
                <div class="container">
                    <h5 class="text-white h5">Tags</h5>
                    @foreach($tags as $tag)
                        <a href="{{route('directory.tag', $tag->slug)}}" class="btn rounded-0 btn-outline-info m-1">{{$tag->name}}</a>
                    @endforeach
                </div>
            </div>
        </template>
    </div>
</div>
