$( document ).ready(function() {
    $('.all_author_post_area').load(blog_ajaxAuthor);
});

$(document).on('click', '.all_author_post_area .pagination a', function(e){
    e.preventDefault();
    $('.all_author_post_area').load($(this).attr('href'))
});
