$( document ).ready(function() {
    $('.all_tag_post_area').load(blog_ajaxTag);
});

$(document).on('click', '.all_tag_post_area .pagination a', function(e){
    e.preventDefault();
    $('.all_tag_post_area').load($(this).attr('href'));
});
