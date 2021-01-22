
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
        url:"/admin/directoryAds/position",
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
                $(".all_count").html(result.count.all)
                $(".active_count").html(result.count.active)
                $(".inactive_count").html(result.count.inactive)
                $(".datatable").dataTable(dataTblSet());

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

$(".createBtn").click(function() {
    $("#position_id").val(null);
    $("#create_modal_form").find("input[type=text], textarea").val("");
    $("#create_modal").modal("toggle");
});

$("#create_modal_form").submit(function(event) {
    event.preventDefault();

    mApp.block("#create_modal .modal-content", {});
    $.ajax({
        url:"/admin/directoryAds/position",
        method: 'POST',
        data: new FormData(this),
        dataType:'JSON',
        contentType:false,
        cache:false,
        processData:false,
        success: function(result)
        {
            mApp.unblock("#create_modal .modal-content");
            if(result.status===0)
            {
                dispErrors(result.data)
                dispValidErrors(result.data)
            }else {
                itoastr('success', 'Success!');
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

$(document).on('click', '.edit_btn', function() {
    $("#position_id").val($(this).data("id"));
    $("#name").val($(this).data("name"));

    if ($(this).data("status") == 1) {
        $("#status").prop("checked", true);
    } else {
        $("#status").prop("checked", false);
    }

    document.getElementById("thumbnail").value = ""
    $("#thumbnail_image").attr("src", $(this).data("image"));
    $("#create_modal").modal("toggle");
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

function switchAlert(item) {
    var msg;

    switch(switch_action) {
        case 'active':
            msg = 'Do you want to activate '+item+'?';
            break;
        case 'inactive':
            msg = 'Do you want to make inactivate '+item+'?';
            break;
    }
    askToast.question('Confirm', msg, 'switchAction');
}
function switchAction()
{
    $.ajax({
        url:"/admin/directoryAds/position/switch",
        data:{ids:checkedIds(), action:switch_action},
        method:"get",
        success:function(result) {
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
