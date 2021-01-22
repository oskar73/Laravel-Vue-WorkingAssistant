<div class="m-radio-inline text-center d-inline-block ml-4 product_item_area">
    <a  href="{{route('admin.purchase.blog.index')}}" class="m-radio hover-none">
        <input type="radio" name="type" value="blog" @if($item=='blog') checked @endif> Blog Package
        <span></span>
    </a>
    <a  href="{{route('admin.purchase.directory.index')}}" class="m-radio hover-none">
        <input type="radio" name="type" value="directory" @if($item=='directory') checked @endif> Directory Package
        <span></span>
    </a>
    <a  href="{{route('admin.purchase.ecommerce.index')}}" class="m-radio hover-none">
        <input type="radio" name="type" value="ecommerce" @if($item=='ecommerce') checked @endif> Ecommerce
        <span></span>
    </a>
</div>
