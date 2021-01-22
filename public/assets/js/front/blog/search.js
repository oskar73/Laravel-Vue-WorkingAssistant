$(document).on('keyup', "#blog_search_input", function() {
    var $keyword = $(this).val();
    ajaxSearch(blogSearch, $keyword)
});
$(document).on('click', '.blog_append_section .search_result_area .pagination a', function(e){
    e.preventDefault();
    var $keyword = $("#blog_search_input").val();
    ajaxSearch($(this).attr('href'), $keyword);
});
function ajaxSearch($url, $keyword) {

    $.ajax({
        url: $url,
        method: "GET",
        data:{keyword:$keyword},
        success: function(result) {
            console.log(result);
            if(result.status===1)
            {
                $(".blog_search_remove_section").remove();
                $(".blog_append_section").html(result.data);
            }
        },
        error: function(err) {
            console.log('Error!', err);
        },
    });
}
