$(document).ready(function() {
    getBlogAds(ads_type, ads_item_id);
});
function getBlogAds($type, $id=null){
    $.ajax({
        url: blogAds_getData,
        method: "POST",
        data:{_token:token,type:$type,id:$id},
        success: function(result) {
            console.log(result);
            if(result.status===1)
            {
                $.each(result.data, function(index, item) {
                    if(item!==null)
                    {
                        $(".blog-ads-position-111"+item.position_id).html(item.frame);
                    }
                })
            }
        },
        error: function(err) {
            console.log('Error!', err);
        },
    });
}
$(document).on("click", ".blogAds-click-funnel", function(e) {
    e.preventDefault();
    var id = $(this).data("id");
    window.open($(this).data("url"), '_blank');
    $.ajax({
        url: blogAds_impClick,
        method: "POST",
        data:{_token:token,id:id},
        success:function(result)
        {
            console.log(result)
        }
    });
});
