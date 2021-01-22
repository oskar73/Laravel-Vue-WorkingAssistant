
var pageUrl = get_review+"?page=1";
var model_data = {type:type,model_id:model_id};

$(document).ready(function() {
    getReviews(pageUrl);

    $("#rating").rateYo({
        rating: 0,
        ratedFill: "#86bc42",
        fullStar: true,
        onChange: function (rating, rateYoInstance) {

            $(this).next().val(rating);
        }
    });

});



function getReviews(url)
{
    $.ajax({
        url:url,
        type:"get",
        data:model_data,
        success:function(result)
        {
            console.log(result)
            if(result.status===1)
            {
                $(".review_result").html(result.data);
                $(".review_count").html(result.count);
                var rating = $("#review_rating");
                if(result.avgRating<1||result.avgRating==null)
                {
                    rating.html("No review yet.");
                }else {
                    rating.rateYo().rateYo("destroy");

                    rating.rateYo({
                        rating: parseFloat(result.avgRating).toFixed(2),
                        readOnly: true,
                        starWidth: "20px",
                        ratedFill: "#86bc42"
                    }).attr("title", parseFloat(result.avgRating).toFixed(2));
                }
                $(".review_rating_item").each(function(index, item) {
                    $(this).rateYo({
                        rating: parseFloat($(this).data("rating")).toFixed(2),
                        readOnly: true,
                        starWidth: "20px",
                        ratedFill: "#86bc42"
                    }).attr("title", parseFloat($(this).data("rating")).toFixed(2));
                })
            }
        },
        error:function(e) {
            console.log(e);
        }
    })
}

$("#review_form").on("submit", function(e) {
    e.preventDefault();
    console.log('here')
    $(".smtBtn").html("<i class='fa fa-spinner fa-spin fa-fw'></i>").attr("disabled", true);
    $.ajax({
        url:$(this).attr("action"),
        data:new FormData(this),
        method:'POST',
        dataType:'JSON',
        contentType:false,
        cache:false,
        processData:false,
        success: function(result)
        {
            console.log(result);
            $(".smtBtn").html("Leave Review").attr("disabled", false);
            $(".form-control-feedback").html("");
            if(result.status===0)
            {
                dispValidErrors(result.data)
                dispErrors(result.data)
            }else {
                itoastr('success', "Success!");
                getReviews(pageUrl);
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    })
});
