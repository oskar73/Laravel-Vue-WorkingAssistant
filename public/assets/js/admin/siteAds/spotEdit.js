var selected = 0;
var del_price_id;

$(function () {
    hashUpdate(window.location.hash);
    getPrice();
});
$("#submit_form").on("submit", function(e) {
    e.preventDefault();
    $(".smtBtn").html("<i class='fa fa-spin fa-spinner fa-2x'></i>").prop("disabled", true);

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
            $(".smtBtn").prop("disabled", false).html("Next");

            if(result.status===0)
            {
                dispErrors(result.data);
                dispValidErrors(result.data);
            }else {
                itoastr('success', 'Successfully Created!');

                setTimeout(function() {
                    window.location.href=result.data;
                }, 1000);

            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });
});

function getPrice()
{
    $.ajax({
        url:"/admin/siteAds/spot/edit/"+g_item_id,
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

$(".addPriceBtn").click(function() {
    $("#edit_price").val(null);
    $("#price_modal").modal("toggle");
});

$("#price_modal_form").on("submit", function(event) {
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
                $("#price_modal").modal("toggle")
                getPrice();
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });
});

$(document).on("blur", ".price", function() {
    if($(this).val()!=='')
    {
        console.log($(this).val())
        $(this).val(parseFloat($(this).val()).toFixed(2))
    }
})

$(document).on("click", ".editPriceBtn", function() {
    var price = $(this).data("price");

    $("#edit_price").val(price.id);
    $("#payment_type").val(price.type);
    $("#period").val(price.period);
    $("#impression").val(price.impression);
    $("#price").val(price.price);
    $("#slashed_price").val(price.slashed_price);
    $("#price_standard").prop("checked", price.standard==1? true: false);
    $("#price_status").prop("checked", price.status==1? true: false);
    $(".payment_type_select").addClass("d-none");
    $(`.${price.type}_select`).removeClass("d-none");
    $(".selectpicker").selectpicker("refresh")

    $("#price_modal").modal("toggle")
})
$("#payment_type").on("change", function() {
    $(`.payment_type_select`).toggleClass("d-none");
})
$(document).on("click", ".delPriceBtn", function() {
    del_price_id = $(this).data("id");
    askToast.question("Confirm", "Do you want to delete this item?", "delPerform");
});
function delPerform()
{
    $.ajax({
        headers:{
            "X-CSRF-TOKEN":token
        },
        url:"/admin/siteAds/spot/deletePrice/"+g_item_id,
        method: 'delete',
        data:{id:del_price_id},
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

$("input[name=google_ads]").on("change", function()
{
    console.log($(this).val())
    if($(this).val()==-1)
    {
        $(".google_ads_select").addClass("d-none");
        $(".default_listing_select").addClass("d-none");
    }else if($(this).val()==0)
    {
        $(".google_ads_select").addClass("d-none");
        $(".default_listing_select").removeClass("d-none");
    }else if($(this).val()==1)
    {
        $(".default_listing_select").addClass("d-none");
        $(".google_ads_select").removeClass("d-none");
    }
});


$(".ads_image").change(function(event) {
    var target = $(this).data("target");

    var reader = new FileReader();
    reader.onload = function(e)
    {
        var image = new Image();
        image.src = e.target.result;

        image.onload = function () {
            var img_h = this.height;
            var img_w = this.width;

            if (img_h == height && img_w == width) {
                var output = document.getElementById(target);
                output.src=reader.result;
                itoastr("success", "Image size is fine");
                return true;
            }else {
                iziToast.info({
                    title: 'Info',
                    displayMode:2,
                    message: 'Image width and height should be match.' + `${width}x${height}px`,
                    position:'topRight',
                    timeout:false,
                    buttons:[
                        ['<button>Click Here for resize</button>', function (instance, toast) {
                            instance.hide({ transitionOut: 'fadeOutUp' }, toast);
                            window.open("https://www.iloveimg.com/crop-image");
                        }, true],
                    ]
                });
                $("#image").val('');
                return false;
            }
        }
    }
    reader.readAsDataURL(event.target.files[0]);
})

$("#listing_form").on("submit", function(event) {
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
                setTimeout(function() {
                    window.location.href=result.data;
                    window.location.reload();
                }, 1000)
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });
});
