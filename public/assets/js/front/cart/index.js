$(document).ready(function() {
   getCartTable();
});

function getCartTable()
{
    $.ajax({
        url:"/cart/getData",
        success:function(result)
        {
            console.log(result);
            if(result.status===1)
            {
                $(".cart_item_area").html(result.data.view);
                $(".c_onetotal_price").html(result.data.oneTotal);
                $(".c_subtotal_price").html(result.data.subTotal);
                $(".c_total_price").html(result.data.total);
            }else {
                dispErrors(result.data);
            }
        },
        error:function(e)
        {
            console.log(e);
        }
    })
}
$(document).on('click', '.c_rm_btn', function(e){
    e.preventDefault();
    $.ajax({
        url:`/cart/remove`,
        data:{id:$(this).data("id")},
        success:function(result) {
            $(".loading_div").remove();
            if(result.status===0)
            {
                dispErrors(result.data);
            }else {
                itoastr("success", "Successfully removed!");
                $("#header_area").html(result.data);

                getCartTable();
            }
        },
        error:function(e)
        {
            console.log(e);
        }
    })
});

$(document).on("click", "#emptyCrtBtn", function() {
    askToast.question("Do you want to clear all the cart items?", "", "emptyCart")
});
function emptyCart()
{
    $.ajax({
        url:`/cart/empty`,
        success:function(result) {
            $(".loading_div").remove();
            if(result.status===0)
            {
                dispErrors(result.data);
            }else {
                itoastr("success", "Successfully removed!");
                $("#header_area").html(result.data);

                getCartTable();
            }
        },
        error:function(e)
        {
            console.log(e);
        }
    })
}

$("#updateCartForm").submit(function(event) {
    event.preventDefault();
    $(".updateCrtBtn").append("<i class=\"loading_div fas fa-spinner fa-spin fa-fw\"></i>");
    $(".updateCrtBtn").attr("disabled", true);
    $.ajax({
        url:$(this).attr("action"),
        method: 'POST',
        data: new FormData(this),
        dataType:'JSON',
        contentType:false,
        cache:false,
        processData:false,
        success: function(result)
        {
            console.log(result);
            $(".loading_div").remove();
            $(".updateCrtBtn").attr("disabled", false);
            if(result.status===0)
            {
                dispErrors(result.data)
            }else {
                itoastr('success', 'Successfully Updated!');
                $("#header_area").html(result.data);

                getCartTable();
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });
});
