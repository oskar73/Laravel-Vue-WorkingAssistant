var page = 1;
var end = 0;
var category = 'all';

$( document ).ready(function() {
    hashApply(window.location.hash);
});
$(".category-menu li a").on("click", function() {
    hash = $(this).attr("href");
    hashApply(hash);
});
function hashApply(hash)
{
    if(hash==='')
    {
        hash = "#/all";
    }
    console.log(hash)
    $(".category-menu li").removeClass("menu-active");
    $(".category-menu li a[href='"+hash+"']").parent().addClass("menu-active");
    var a = hash.split("/");
    category = a[1];
    load_more(page);
}
function load_more(page)
{
    $(".loading_text").show();
    $('.all_post_ajax_area').load(blog_allPosts + "?page="+page+"&&category="+category);
}
$(document).on('click', '.all_post_ajax_area .pagination a', function(e){
    e.preventDefault();
    $('.all_post_ajax_area').load($(this).attr('href')+"&&category="+category)
});


