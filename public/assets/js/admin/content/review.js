
var switch_action;
var checkbox_count;
var table1,table2,table3,table4;
var alone=0;
var selected;

$(function () {
    hashUpdate(window.location.hash);
    table1 = $('.datatable-all').DataTable(setParam('all'));
    table2 = $('.datatable-active').DataTable(setParam('active'));
    table3 = $('.datatable-inactive').DataTable(setParam('inactive'));
});

function setParam(status)
{
    let ajax = {
        url:"/admin/content/review",
        type:"get",
        data:{status:status}
    };

    let columns=[
        { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
        { data: 'model', name: 'model', orderable: false, searchable: false },
        { data: 'product', name: 'Product', orderable: false, searchable: false },
        { data: 'user', name: 'User', orderable: false, searchable: false },
        { data: 'rating', name: 'Rating' },
        { data: 'comment', name: 'Comment' },
        { data: 'status', name: 'Status' },
        { data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns);
}

$('.datatable-all').on('draw.dt', function() {
    $(".all_count").html(table1.ajax.json().recordsTotal)
});
$('.datatable-active').on('draw.dt', function() {
    $(".active_count").html(table2.ajax.json().recordsTotal)
});
$('.datatable-inactive').on('draw.dt', function() {
    $(".inactive_count").html(table3.ajax.json().recordsTotal)
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
$(document).on("click", '.editBtn', function() {
    $.ajax({
        url:"/admin/content/review/edit",
        data:{id:$(this).data("id")},
        method:"get",
        success:function(result) {
            console.log(result)
            if(result.status===0)
            {
                dispErrors(result.data)
            }else {
                $("#item_modal").modal("toggle");
                $("#item_id").val(result.data.id);
                $("#rating").val(result.data.rating);
                $("#rating").selectpicker("refresh");
                $("#comment").val(result.data.comment);
                $("#status").prop("checked", result.data.status===1? true: false);
            }
        },
        error:function(e) {
            console.log(e);
        }
    })
});

$("#item_modal_form").submit(function(event) {
    event.preventDefault();
    mApp.block("#item_modal .modal-content", {});
    $.ajax({
        url:"/admin/content/review/edit",
        method: 'POST',
        data: new FormData(this),
        dataType:'JSON',
        contentType:false,
        cache:false,
        processData:false,
        success: function(result)
        {
            mApp.unblock("#item_modal .modal-content");
            if(result.status===0)
            {
                dispErrors(result.data)
                dispValidErrors(result.data)
            }else {
                $("#item_modal").modal('toggle');
                itoastr("success", 'Successfully updated');
                table1.ajax.reload();
                table2.ajax.reload();
                table3.ajax.reload();
            }
        },
        error: function(e)
        {
            console.log(e)
        }
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
        url:"/admin/content/review/switch",
        data:{ids:checkedIds(), action:switch_action},
        method:"get",
        success:function(result) {
            console.log(result)
            if(result.status===0)
            {
                dispErrors(result.data)
            }else {
                itoastr("success", 'Successfully updated');
                table1.ajax.reload();
                table2.ajax.reload();
                table3.ajax.reload();

            }
        },
        error:function(e) {
            console.log(e);
        }
    })
}
