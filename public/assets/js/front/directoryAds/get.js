var adType = $("#adtype").val();
var adId = $("#adid").val();
$(document).ready(function() {
    getDirectoryAds();
})
function getDirectoryAds()
{
    $.ajax({
        url: directoryads_getData,
        method: "POST",
        data:{_token:token,type:adType,id:adId},
        success: function(result) {
            console.log(result);
            if(result.status===1)
            {
                $.each(result.data, function(index, item) {
                    if(item!==null)
                    {
                        $(".directory-ads-position-111"+item.position_id).html(item.frame);
                    }
                })
            }
        },
        error: function(err) {
            console.log('Error!', err);
        },
    });
}
