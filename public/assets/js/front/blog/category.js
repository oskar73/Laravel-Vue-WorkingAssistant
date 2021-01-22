$( document ).ready(function() {
    $('.all_category_post_area').load(blog_AjaxCategory);
});

$(document).on('click', '.all_category_post_area .pagination a', function(e){
    e.preventDefault();
    $('.all_category_post_area').load($(this).attr('href'))
});
