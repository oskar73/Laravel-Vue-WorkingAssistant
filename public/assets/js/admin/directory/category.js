
var switch_action;
var checkbox_count;
var alone=0;
var selected;
var previewCropped = '';
var isInitialized = false;
var cropper = '';
var file = '';

$(function () {
    hashUpdate(window.location.hash);
    getDatatableTable();
});

function getDatatableTable()
{
    $.ajax({
        url:"/admin/directory/category",
        type:"get",
        dataType:'JSON',
        contentType:false,
        cache:false,
        processData:false,
        success:function(result)
        {
            if(result.status===1)
            {
                $(".show_checked").addClass("d-none");

                $("#all_area .m-portlet__body").html(result.all);
                $("#active_area .m-portlet__body").html(result.active);
                $("#inactive_area .m-portlet__body").html(result.inactive);
                $("#subcategory_area .m-portlet__body").html(result.subcategory);
                $(".all_count").html(result.count.all)
                $(".active_count").html(result.count.active)
                $(".inactive_count").html(result.count.inactive)
                $(".subcategory_count").html(result.count.subcategory)
                $("#parent").html(result.parents);
                $(".datatable").dataTable(dataTblSet())
                $(".selectpicker").selectpicker('refresh');
                $(".select2").select2({
                    placeholder:'Choose recommended tags',
                    width:'100%'
                });
            }
        },
        error:function(e) {
            console.log(e);
        }
    })
}

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
                    initialAspectRatio:7/4,
                    aspectRatio:7/4,
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

$(document).on("change", "input[type=checkbox]", function() {
    checkbox_count = $(".datatable tbody input[type=checkbox]:checked").length;
    if(checkbox_count>0)
    {
        $(".show_checked").removeClass("d-none");
    }else {
        $(".show_checked").addClass("d-none");
        $(".datatable thead input[type=checkbox]").prop("checked", false);
    }
});
$(".createBtn").click(function() {
    $("#category_id").val(null);
    if (isInitialized === true) {
        cropper.destroy();
        previewCropped = '';
    }
    $("#name").val(null);
    $("#description").val(null);
    document.getElementById("thumbnail").value = ""
    document.getElementById("thumbnail_image").src = ""
    $("#create_modal").modal('toggle')
});
$("#create_modal_form").submit(function(event) {
    event.preventDefault();
    var formData = new FormData(this);
    if(previewCropped!=='')
    {
        formData.append("thumbnail", previewCropped);
    }
    mApp.block("#create_modal .modal-content", {});
    $.ajax({
        url:"/admin/directory/category",
        method: 'POST',
        data: formData,
        dataType:'JSON',
        contentType:false,
        cache:false,
        processData:false,
        success: function(result)
        {
            console.log(result)
            mApp.unblock("#create_modal .modal-content");
            if(result.status===0)
            {
                dispErrors(result.data)
            }else {
                itoastr('success', 'Successfully Updated!');
                $("#create_modal").modal('toggle');
                getDatatableTable();
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });
});
$(document).on("click", '.switchBtn', function() {
    switch_action = $(this).data("action");
    var item = checkbox_count+" items";
    alone = 0;
    switchAlert(item);
});
$(document).on("click", '.switchOne', function() {
    switch_action = $(this).data("action");
    alone = 1;
    selected = $(this).parent().parent().find(".checkbox").data("id");
    switchAlert('this item');
});
$(document).on('click', '.edit_btn', function() {
    var category = $(this).data("category");
    var tags = $(this).data("tags");
    $("#category_id").val(category.id);
    $("#parent").val(category.parent_id);
    $("#parent").selectpicker('refresh');
    $("#name").val(category.name);
    $("#description").val(category.description);
    if(category.status===1)
    {
        $("#status").prop("checked", true);
    }else {
        $("#status").prop("checked", false);
    }
    if (isInitialized === true) {
        cropper.destroy();
        previewCropped = '';

    }
    document.getElementById("thumbnail").value = ""
    $("#thumbnail_image").attr("src", $(this).data("thumbnail"));
    $("#tag").val(tags).trigger('change.select2');
    $("#create_modal").modal('toggle');
})
$(".sortBtn").click(function() {
    mApp.blockPage();
    $.ajax({
        url:"/admin/directory/category/sort",
        method:"GET",
        success:function(result)
        {
            console.log(result);
            mApp.unblockPage();
            $("#sortable").html(result.view);
            $("#sort-modal").modal('toggle');
            $("#sortable").sortable();
            $("#sortable").disableSelection();
        },
        error : function(err) {
            console.log('Error!', err);
        },
    });
});
$("#sort_submit").click(function() {
    mApp.block("#sort-modal .modal-content", {});
    var sorts = [];
    $( "#sortable li" ).each(function( index ) {
        sorts.push($(this).data("id"));
    });
    $.ajax({
        url:"/admin/directory/category/sort",
        method:"POST",
        data:{_token:token,sorts:sorts},
        success:function(result)
        {
            itoastr('success', 'Successfully Updated!');
            mApp.unblock("#sort-modal .modal-content", {});
            $("#sort-modal").modal('toggle');
        },
        error : function(err) {
            console.log('Error!', err);
        },
    });
});

function switchAlert(item) {
    var msg;

    switch(switch_action) {
        case 'active':
            msg = 'Do you want to activate '+item+'?';
            break;
        case 'inactive':
            msg = 'Do you want to make inactivate '+item+'?';
            break;
        case 'delete':
            msg = 'Do you want to delete '+item+'?';
            break;
    }
    askToast.question('Confirm', msg, 'switchAction');
}
function switchAction()
{
    $.ajax({
        url:"/admin/directory/category/switch",
        data:{ids:checkedIds(), action:switch_action},
        method:"get",
        success:function(result) {
            console.log(result)
            if(result.error)
            {
                dispErrors(result.message)
            }else {
                itoastr("success", 'Successfully updated!');
                getDatatableTable()

            }
        },
        error:function(e) {
            console.log(e);
        }
    })
}
