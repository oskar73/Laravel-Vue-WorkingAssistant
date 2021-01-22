
@forelse($reviews as $review)
<div class="margin-40px-bottom padding-35px-bottom border-bottom">
    <div class="media margin-20px-bottom product-review">
        <img class="mr-3 rounded-circle width-50px" src="{{$review->user_id!=null? $review->user->avatar():"https://ui-avatars.com/api/?size=30&&name=" . $review->name}}" loading="lazy">
        <div class="media-body">
            <a href="javascript:void(0);" class="margin-5px-bottom font-weight-600 text-extra-dark-gray">
                {{$review->user->name?? $review->name}}
            </a>
            <span class="d-block text-theme-color">
                {{$review->created_at}}
            </span>
        </div>

        <span class="text-theme-color">
            <div class="review_rating_item" data-rating="{{$review->rating}}"></div>
        </span>

    </div>

    <p class="no-margin-bottom">
       {{$review->comment}}
    </p>

</div>
@empty
    <div>No review, yet.</div>
@endforelse
<div class="text-left">
    {{$reviews->links()}}
</div>
