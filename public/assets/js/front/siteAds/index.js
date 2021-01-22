var pageUrl = siteads_url+"?page=1";

$(document).ready(function() {
    updateItems();
});

function updateItems()
{
    $.ajax({
        url:pageUrl,
        success:function(result)
        {
            console.log(result);
            if(result.status===1)
            {
                $(".items_result").html(result.view);
            }else {
            }
        },
        error:function(e)
        {
            console.log(e);
        }
    })
}
$(document).on('click', '.items_result .pagination a.page-link', function(e){
    e.preventDefault();
    pageUrl = $(this).attr('href');
    updateItems();
});
