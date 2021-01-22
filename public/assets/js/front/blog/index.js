$(document).ready(function() {
    $('.all_post_area').load(blogAjaxUrl);
});
$(document).on('click', '.all_post_area .pagination a', function(e){
    e.preventDefault();
    $('.all_post_area').load($(this).attr('href'));
});

