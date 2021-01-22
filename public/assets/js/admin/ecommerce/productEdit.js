
var previewCropped = '';
var isInitialized = false;
var cropper = '';
var file = '';
var i = 0;
var j = 0;
var k = 0;

$(function () {
    hashUpdate(window.location.hash);

    tinymceInit("#description");
    $("#category").select2({
        width:'100%',
        placeholder: 'Choose Category',
        minimumResultsForSearch: -1
    });
    $("#visible_date").datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: !0,
        autoclose: !0,
    });

    getProductPrice();

});

$(document).on("click", "#addImage", function() {
    $("#image_area").append("<tr><td><input type=\"file\" accept=\"image/*\" name='images[]' class=\"form-control m-input--square uploadImageBox\" data-target='image-"+i+"'></td><td><img id='image-"+i+"' class='width-150' /></td><td><button class='btn btn-danger btn-sm delBtn'>X</button></td></tr>");
    i++;
});
$(document).on("click", "#addVideo", function() {
    $("#video_area").append("<tr><td><input type=\"file\" accept=\"video/*\" name='videos[]' class=\"form-control m-input--square\"></td><td><button class='btn btn-danger btn-sm delBtn'>X</button></td></tr>");
    j++;
});
$(document).on("click", "#addLink", function() {
    $("#link_area").append("<tr><td><input type=\"url\" name='links[]' class=\"form-control m-input--square\"></td><td><button class='btn btn-danger btn-sm delBtn'>X</button></td></tr>");
    k++;
});
$(document).on("click", ".delBtn", function() {
    $(this).parent().parent().remove();
})
$("#thumbnail").change(function (event) {
    var file = this.files[0];
    if (file) {
        var img = new Image();

        img.src = window.URL.createObjectURL(file);

        img.onload = function () {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(file);
            window.URL.revokeObjectURL(img.src);
            oFReader.onload = function () {

                $("#thumbnail_image").attr('src', this.result);

                if (isInitialized === true) {
                    cropper.destroy();
                }

                cropper = new Cropper(document.getElementById("thumbnail_image"), {
                    viewMode: 2,
                    dragMode: 'crop',
                    initialAspectRatio:1,
                    aspectRatio:1,
                    checkOrientation: false,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    zoomOnTouch: true,
                    zoomOnWheel: true,
                    guides: true,
                    highlight: true,
                    crop: function (event) {
                        const canvas = cropper.getCroppedCanvas();
                        previewCropped = canvas.toDataURL();
                    }
                });
                isInitialized = true;
            };
        }
    }
});

$("#submit_form").on('submit', function(event) {
    event.preventDefault();
    tinyMCE.triggerSave();
    var formData = new FormData(this);
    if(previewCropped!=='')
    {
        formData.append("thumbnail", previewCropped);
    }

    formData.append("sizes", $("#sizes").tagsinput("items"));
    formData.append("colors", $("#colors").tagsinput("items"));
    formData.append("variants", $("#variants").tagsinput("items"));

    $(".smtBtn").html("<i class='fa fa-spinner fa-spin fa-2x fa-fw'></i>").attr("disabled", true);
    $.ajax({
        url:$(this).attr("action"),
        method: 'POST',
        data: formData,
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
                }, 1000);
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });

});
$(document).on("click", ".addPriceBtn", function() {
    $("#edit_price").val(null)
    $(".disable_item").prop("disabled", false);
    $(".selectpicker").selectpicker("refresh");
    $("#priceModal").modal("toggle")
})

$("#addPriceModalForm").on('submit', function(event) {
    event.preventDefault();
    $("#addPriceModalForm .smtBtn").html("<i class='fa fa-spinner fa-spin fa-2x fa-fw'></i>").attr("disabled", true);
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
            $("#addPriceModalForm .smtBtn").html("Submit").attr("disabled", false);
            $(".form-control-feedback").html("");

            if(result.status===0)
            {
                dispValidErrors(result.data)
                dispErrors(result.data)
            }else {
                itoastr('success', 'Success!');
                $("#priceModal").modal("toggle")
                getProductPrice();
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });

});
function getProductPrice()
{
    $.ajax({
        url: "/admin/ecommerce/product/getPrice/"+item_id,
        success:function(result)
        {
            if(result.status===1)
            {
                $(".get_price_area").html(result.data);
            }
        },
        error:function(e)
        {
            console.log(e);
        }

    })
}

$(document).on("click", ".editBtn", function() {
    var price = $(this).data("price");

    $("#edit_price").val(price.id);
    $("#payment_type").val(price.recurrent);
    $("#period").val(price.period);
    $("#period_unit").val(price.period_unit);
    $("#price").val(price.price);
    $("#slashed_price").val(price.slashed_price);

    $(".selectpicker").selectpicker("refresh")

    $("#priceModal").modal("toggle")
})

$(document).on("click", ".updatePriceBtn", function(e) {
    e.preventDefault();

    $(this).html(" <i class='fa fa-spin fa-spinner'></i>");
    $(".updatePriceBtn").attr("disabled", true);

    var price = $(this).parent().parent().find(".price input").val();
    var slashed_price = $(this).parent().parent().find(".slashed_price input").val();
    var size = $(this).data("size");
    var color = $(this).data("color");
    var variant = $(this).data("variant");

    $.ajax({
        url: "/admin/ecommerce/product/updatePrice/"+item_id,
        method:"POST",
        data:{_token:token,price:price,slashed_price:slashed_price,size:size,color:color,variant:variant},
        success:function(result)
        {
            $(".updatePriceBtn").html("Update Price").attr("disabled", false)
            console.log(result);
            if(result.status===1)
            {
                itoastr("success", "Successfully updated!");
                getProductPrice();
            }
        },
        error:function(e)
        {
            console.log(e);
        }

    })
});

$(document).on("click", ".delPriceBtn", function(e) {
    e.preventDefault();
    askToast.question("Confirm", "Are you sure?", "deletePrice");
})

function deletePrice()
{
    $.ajax({
        url: "/admin/ecommerce/product/delPrice/"+item_id,
        method:"delete",
        data:{_token:token},
        success:function(result)
        {
            if(result.status===1)
            {
                itoastr("success", "Successfully deleted!");
                getProductPrice();
            }
        },
        error:function(e)
        {
            console.log(e);
        }

    })
}
