var pageUrl = directory_url+"?page=1";
var directory_keyword=null;
var directory_category = $("#category_id").val();
var directory_tag = $("#tag_id").val();
var filter=false;

$(document).ready(function() {
    if ($("#disable_listings").val() !=1) {
        updateItems();
    }
});

function updateItems()
{
    $.ajax({
        url:pageUrl,
        data:{category:directory_category, tag:directory_tag, keyword:directory_keyword},
        success:function(result)
        {
            console.log(result);
            if(result.status===1)
            {
                if(filter)
                {
                    $(".search_append_area").html(result.data);
                    $(".search_remove_area").remove();
                }else {

                    $(".featured_listing_area").html(result.data);
                }
            }
        },
        error:function(e)
        {
            console.log(e);
        }
    })
}
$(document).on('click', '.search_append_area .pagination a.page-link', function(e){
    e.preventDefault();
    pageUrl = $(this).attr('href');
    updateItems();
});

$(document).on('keyup', "#directory_search_input", function() {
    directory_keyword = $(this).val();
    directory_category = 0;
    directory_tag = 0;
    filter = true;
    updateItems();
});
