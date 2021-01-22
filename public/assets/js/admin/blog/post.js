
var switch_action;
var checkbox_count;
var table1,table2,table3,table4,table5;
var alone=0;
var selected;

$(function () {
    hashUpdate(window.location.hash);
    $(".select_picker").selectpicker();
    table1 = $('.datatable-pending').DataTable(setParam('pending'));
    table2 = $('.datatable-all').DataTable(setParam('all'));
    table3 = $('.datatable-approved').DataTable(setParam('approved'));
    table4 = $('.datatable-draft').DataTable(setParam('draft'));
    table5 = $('.datatable-denied').DataTable(setParam('denied'));
});
$('.datatable-pending').on('draw.dt', function() {
    $(".pending_count").html(table1.ajax.json().recordsTotal)
});
$('.datatable-all').on('draw.dt', function() {
    $(".all_count").html(table2.ajax.json().recordsTotal)
});
$('.datatable-approved').on('draw.dt', function() {
    $(".approved_count").html(table3.ajax.json().recordsTotal)
});
$('.datatable-draft').on('draw.dt', function() {
    $(".draft_count").html(table4.ajax.json().recordsTotal)
});
$('.datatable-denied').on('draw.dt', function() {
    $(".denied_count").html(table5.ajax.json().recordsTotal)
});
$(".createBtn").click(function() {
    modalClearToggle();
});
function modalClearToggle()
{
    $(".notify_area").hide();
    $("#item_id").val(null);
    $('#item_modal').modal('toggle');
}

function setParam(status)
{
    let ajax = {
        url:"/admin/blog/post",
        type:"get",
        data:{status:status, user:"all"}
    };

    let columns=[
        { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
        { data: 'category', name: 'category'},
        { data: 'title', name: 'title'},
        { data: 'user', name: 'user', orderable: false, searchable: false },
        { data: 'view_count', name: 'view_count'},
        { data: 'favoriters', name: 'favoriters'},
        { data: 'comments', name: 'comments'},
        { data: 'subscribers', name: 'subscribers'},
        { data: 'is_free', name: 'is_free' },
        { data: 'featured', name: 'featured' },
        { data: 'is_published', name: 'is_published' },
        { data: 'status', name: 'status' },
        { data: 'visible_date', name: 'visible_date' },
        { data: 'created_at', name: 'created_at' },
        { data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns, 13, false);
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
        case 'approve':
            msg = 'Do you want to approve '+item+'?';
            break;
        case 'deny':
            msg = 'Do you want to deny '+item+'?';
            break;
        case 'publish':
            msg = 'Do you want to publish '+item+'?';
            break;
        case 'featured':
            msg = 'Do you want to set as featured '+item+'?';
            break;
        case 'unfeatured':
            msg = 'Do you want to set as unfeatured '+item+'?';
            break;
        case 'draft':
            msg = 'Do you want to set as draft '+item+'?';
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
        url:"/admin/blog/post/switchPost",
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
                table4.ajax.reload();
                table5.ajax.reload();

            }
        },
        error:function(e) {
            console.log(e);
        }
    })
}
