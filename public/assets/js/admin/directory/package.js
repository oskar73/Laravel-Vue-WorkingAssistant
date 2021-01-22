
var switch_action;
var checkbox_count;
var alone=0;
var selected;

$(function () {
    hashUpdate(window.location.hash);
    getDatatableTable();
});

function getDatatableTable()
{
    $.ajax({
        url:"/admin/directory/package",
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
                $(".datatable").dataTable(dataTblSet())

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
        case 'featured':
            msg = 'Do you want to featured '+item+'?';
            break;
        case 'unfeatured':
            msg = 'Do you want to unfeature '+item+'?';
            break;
        case 'delete':
            msg = 'Do you want to delete '+item+'? Please make sure you already delete all price plans in this item.';
            break;
        case 'new':
            msg = 'Do you want to set as new '+item+'?';
            break;
        case 'undonew':
            msg = 'Do you want to undo as new '+item+'?';
            break;
    }
    askToast.question('Confirm', msg, 'switchAction');
}
function switchAction()
{
    $.ajax({
        url:"/admin/directory/package/switch",
        data:{ids:checkedIds(), action:switch_action},
        method:"get",
        success:function(result) {
            console.log(result)
            if(result.status===0)
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

$(".sortBtn").click(function() {
    mApp.blockPage();
    $.ajax({
        url:"/admin/directory/package/sort",
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
        url:"/admin/directory/package/sort",
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
