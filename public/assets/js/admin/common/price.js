
var delPrice_id;
getPrice();

$(".addPriceBtn").click(function() {
    $("#edit_price").val(null)
    $(".disable_item").prop("disabled", false);
    $(".selectpicker").selectpicker("refresh");
    $("#priceModal").modal("toggle")
})
$(document).on("blur", ".price", function() {
    if($(this).val()!=='')
    {
        $(this).val(parseFloat($(this).val()).toFixed(2))
    }
})
function getPrice()
{
    $.ajax({
        url:getPriceUrl,
        method: 'get',
        dataType:'JSON',
        contentType:false,
        cache:false,
        processData:false,
        success: function(result)
        {
            console.log(result)
            if(result.status===0)
            {
                dispValidErrors(result.data)
            }else {
                $(".price_area").html(result.data);
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });
}

$(document).on("click", ".editBtn", function() {
    var price = $(this).data("price");

    $("#edit_price").val(price.id);
    $("#payment_type").val(price.recurrent);
    $("#period").val(price.period);
    $("#period_unit").val(price.period_unit);
    $("#price").val(price.price);
    $("#slashed_price").val(price.slashed_price);
    $("#price_standard").prop("checked", price.standard==1? true: false);
    $("#price_status").prop("checked", price.status==1? true: false);

    $(".disable_item").prop("disabled", true);
    $(".selectpicker").selectpicker("refresh")

    if(price.recurrent==0)
    {
        $("#price").prop("disabled", false)
    }
    $("#priceModal").modal("toggle")
})

$(document).on("click", ".delBtn", function() {
    delPrice_id = $(this).data("id");
    askToast.question("Confirm", "Do you want to delete this item?", "delPerform");
});
function delPerform()
{
    $.ajax({
        headers:{
            "X-CSRF-TOKEN":token
        },
        url:delPriceUrl,
        method: 'delete',
        data:{id:delPrice_id},
        success: function(result)
        {
            if(result.status===0)
            {
                dispValidErrors(result.data)
            }else {
                itoastr('success', 'Successfully deleted!');
                getPrice();
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });
}
$("#addPriceModalForm").on("submit", function(event) {
    event.preventDefault();
    $(".smtBtn").html("<i class='fa fa-spinner fa-spin fa-2x fa-fw'></i>").attr("disabled", true);
    $.ajax({
        url:$(this).attr("action"),
        method: 'post',
        data: new FormData(this),
        dataType:'JSON',
        contentType:false,
        cache:false,
        processData:false,
        success: function(result)
        {
            console.log(result);
            $(".smtBtn").html("Submit").attr("disabled", false);
            $(".form-control-feedback").html("");

            if(result.status===0)
            {
                dispValidErrors(result.data)
                dispErrors(result.data)
            }else {
                itoastr('success', 'Success!');
                $("#priceModal").modal("toggle")
                getPrice();
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });
});
