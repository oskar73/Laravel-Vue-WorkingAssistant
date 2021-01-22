
var switch_action;
var alone=0;
var selected;

$(function () {
    hashUpdate(window.location.hash);
    getDatatableTable();
});

function getDatatableTable()
{
    $.ajax({
        url:"/admin/notification/category",
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
                $(".all_count").html(result.count.all)
                $(".datatable").dataTable(dataTblSet())
            }
        },
        error:function(e) {
            console.log(e);
        }
    })
}

$(".createBtn").click(function() {
    $("#category_id").val(null);
    $("#create_modal").modal('toggle')
});
$("#create_modal_form").submit(function(event) {
    event.preventDefault();
    mApp.block("#create_modal .modal-content", {});
    $.ajax({
        url:"/admin/notification/category",
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
$(document).on("click", '.switchOne', function() {
    switch_action = $(this).data("action");
    alone = 1;
    selected = $(this).data("id");
    switchAlert('this item');
});
$(document).on('click', '.edit_btn', function() {
    var category = $(this).data("category");
    $("#category_id").val(category.id);
    $("#name").val(category.name);
    $("#description").val(category.description);
    $("#create_modal").modal('toggle');
})
function switchAlert(item) {
    var msg;

    switch(switch_action) {
        case 'delete':
            msg = 'Do you want to delete '+item+'?';
            break;
    }
    askToast.question('Confirm', msg, 'switchAction');
}
function switchAction()
{
    $.ajax({
        url:"/admin/notification/category/switch",
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
