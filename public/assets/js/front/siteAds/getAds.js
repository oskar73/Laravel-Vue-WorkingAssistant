$(document).ready(function() {
    getSiteAds();
});
function getSiteAds(){
    $.ajax({
        url: siteads_getData,
        method: "POST",
        data:{_token:token,id:$("#page_id").val()},
        success: function(result) {
            console.log(result)
            if(result.status===1)
            {
                $.each(result.data, function(index, item) {
                    if(item!==null)
                    {
                        $("#site-ads-spot-"+item.position_id).html(item.frame);
                    }
                })
            }
        },
        error: function(err) {
            console.log('Error!', err);
        },
    });
}

$(document).on("click", ".siteAds-click-funnel", function(e) {
    e.preventDefault();
    var id = $(this).data("id");
    window.open($(this).data("url"), '_blank');
    $.ajax({
        url: siteads_impClick,
        method: "POST",
        data:{_token:token,id:id},
        success:function(result)
        {
            console.log(result)
        }
    });
});
