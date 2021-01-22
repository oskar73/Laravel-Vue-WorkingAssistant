var directoryAdsUrl = directoryads_url+"?page=1";

$(document).ready(function() {
    updateDirectoryAdsItems();
});

function updateDirectoryAdsItems()
{
    $.ajax({
        url:directoryAdsUrl,
        success:function(result)
        {
            console.log(result);
            if(result.status===1)
            {
                $(".directory_ads_append_area").html(result.view);
            }else {
            }
        },
        error:function(e)
        {
            console.log(e);
        }
    })
}
$(document).on('click', '.directory_ads_append_area .pagination a.page-link', function(e){
    e.preventDefault();
    directoryAdsUrl = $(this).attr('href');
    updateDirectoryAdsItems();
});
