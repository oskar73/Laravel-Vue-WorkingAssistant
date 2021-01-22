
$(document).ready(function() {
    $('.lightgallery').lightGallery();
});

$(document).on("click", ".addToCartBtn", function(e) {
    e.preventDefault();
    var price = $("input[type=radio][name=price]:checked").val();
    if(price==null) return itoastr("info", 'Please choose one price plan');
    var quantity = $("#quantity").val();
    $(this).find("span").append("<i class=\"loading_div fas fa-spinner fa-spin fa-fw\"></i>");
    var goto = $(this).data("cart");
    $.ajax({
        url:blog_package+`/${model_id}/addtocart`,
        data:{price:price,quantity:quantity},
        success:function(result) {
            $(".loading_div").remove();
            if(result.status===0)
            {
                dispErrors(result.data);
            }else {
                if(goto===1)
                {
                    window.location.href="/cart";
                }else {
                    itoastr("success", "Successfully added!");
                    $("#header_area").html(result.data);
                    $(".toggleBtn").toggleClass("d-none");
                }
            }
        },
        error:function(e)
        {
            console.log(e);
        }
    })
});
