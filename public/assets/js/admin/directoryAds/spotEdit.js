var selected = 0;
var del_price_id;
var type = JSON.parse(g_type);
var width = type.width;
var height = type.height;

$(document).ready(function() {
    hashUpdate(window.location.hash)
    if(g_fixed==0)
    {
        $("#page_type").val(g_page);
        if(g_page!=='home')
        {
            $(`.${g_page}_area`).removeClass("d-none");
            $(`#${g_page}`).val(g_page_id);
        }
    }

    $(".non_search_select2").select2({
        placeholder:"Choose",
        width: '100%',
        minimumResultsForSearch: -1
    });

    getPrice();
})
$("#position_type").on("change", function() {
    var type = $(this).val();
    if(type==='fixed')
    {
        $(".d-none-when-fixed").addClass("d-none");
    }else {
        $("#page_type").val("").trigger('change.select2');
        $(".page_type_area").removeClass("d-none");
    }
    $("#position").val("");
    $("#position_id").val("");
    selected = 0;
})
$("#page_type").on("change", function() {
    var type = $(this).val();
    $(".page_area").addClass("d-none");
    if(type==='category')
    {
        $(".category_area").removeClass("d-none");
    }else if(type==='tag')
    {
        $(".tag_area").removeClass("d-none");
    }else if(type==='detail')
    {
        $(".detail_area").removeClass("d-none");
    }
    $("#position").val("");
    $("#position_id").val("");
    selected = 0;
})
$(".page_area").on("change", function() {
    selected = 0;
});
$("#select_position").on("click", function() {
    var position_type = $("#position_type").val();
    var page_type = $("#page_type").val();
    var page=null;

    if(page_type==='category')
    {
        page = $("#category").val();
    }else if(page_type==='tag')
    {
        page = $("#tag").val();
    }else if(page_type==='detail')
    {
        page = $("#detail").val();
    }
    if(position_type==='fixed') return getPosition(position_type, page_type, page);
    if(page_type==null||page_type==='') return itoastr("info", "Please choose page type.");
    if(page_type!=='home'&&page==null) return itoastr("info", "Please choose page.");
    if(selected===1) return $("#position_modal").modal("toggle");
    else return getPosition(position_type, page_type, page);
})
function getPosition(position_type, page_type, page)
{

    $.ajax({
        url:"/admin/directoryAds/spot/getPosition",
        data:{position_type:position_type,type:page_type,page:page, item_id:g_item_id},
        success:function(result)
        {
            console.log(result)
            if(result.status===1)
            {
                $(".position_area").html("");

                $.each(result.data, function(index, item) {
                    $(".position_area").append(`<div class="position_item tipso2 available${item.available}" data-tipso-title='Position Image' data-tipso='<img src="${item.image}" style="width:100%;height:auto;">' data-id="${item.id}" data-name="${item.name}" data-image="${item.image}">${item.name}</div>`);
                });


                jQuery(".tipso2").tipso({
                    speed             : 400,
                    background        : '#000',
                    titleBackground   : '#86bc42',
                    color             : '#ffffff',
                    titleColor        : '#ffffff',
                    titleContent      : '',
                    size: 'default',
                    showArrow         : true,
                    position: 'top',
                    width: '300',
                });

                $("#position_modal").modal("toggle");

                selected = 1;
            }else {
                dispErrors(result.data);
                dispValidErrors(result.data);
            }
        },
        error:function(e)
        {
            console.log(e)
        }
    })
}
$(document).on("click", ".position_item.available1", function() {
    $(".position_item").removeClass("active");
    $(this).addClass("active");
    $("#position").val($(this).data("name"));
    $("#position_id").val($(this).data("id"));

    $(".preview_position").html(`<img src="${$(this).data("image")}" class="w-100">`);
    $("#position_modal").modal("toggle");
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
            $(".smtBtn").prop("disabled", false).html("Submit");

            if(result.status===0)
            {
                dispErrors(result.data);
                dispValidErrors(result.data);
            }else {
                itoastr('success', 'Successfully Updated!');

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
        url:"/admin/directoryAds/spot/edit/"+g_item_id,
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
        url:"/admin/directoryAds/spot/deletePrice/"+g_item_id,
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

            if (img_h === height && img_w === width) {
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
