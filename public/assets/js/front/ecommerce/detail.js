var selected_color=0;
var selected_size=0;
var selected_custom=0;

$(document).ready(function() {
    $('.lightgallery').lightGallery();
});

$(".variant_select_item").click(function() {
    var variant = $(this).data("variant");
    $(`.variant_select_item[data-variant=${variant}]`).removeClass("active");
    $(this).addClass("active");
    if(variant==='size') selected_size = $(this).data("id");
    else if(variant==='color') selected_color = $(this).data("id");
    else if(variant==='custom') selected_custom = $(this).data("id");
    updateVariantPrice();
});

function updateVariantPrice()
{
    var key = selected_size +''+ selected_color +''+ selected_custom;

    if(mix[key]!==undefined)
    {
        $(".i_slashed_price_area").html(parseFloat(mix[key]['slashed_price']).toFixed(2));
        $(".i_price_area").html(parseFloat(mix[key]['price']).toFixed(2));
    }else {
       $(".i_slashed_price_area").html(parseFloat(d_slashed_price).toFixed(2));
       $(".i_price_area").html(parseFloat(d_price).toFixed(2));
    }
}

$(document).on("click", ".addToCartBtn", function(e) {
    e.preventDefault();

    if(is_size==="1"&&selected_size===0) return itoastr("info", 'Please choose one size.');
    if(is_color==="1"&&selected_color===0) return itoastr("info", 'Please choose one color.');
    if(is_custom==="1"&&selected_custom===0) return itoastr("info", `Please choose one ${custom_name}.`);

    var quantity = $("#quantity").val();
    $(this).find("span").append("<i class=\"loading_div fas fa-spinner fa-spin fa-fw\"></i>");
    var goto = $(this).data("cart");

    console.log(selected_size);
    console.log(selected_color);
    console.log(selected_custom);

    $.ajax({
        url:add_to_cart_url,
        data:{quantity:quantity,size:selected_size,color:selected_color,custom:selected_custom},
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
