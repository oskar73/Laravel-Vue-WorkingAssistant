
var switch_action;
var checkbox_count;
var table1,table2,table3,table4,table5,table6;
var alone=0;
var selected;

$(function () {
    hashUpdate(window.location.hash);
    $(".select_picker").selectpicker();
    table1 = $('.datatable-pending').DataTable(setParam('pending'));
    table2 = $('.datatable-all').DataTable(setParam('all'));
    table3 = $('.datatable-approved').DataTable(setParam('approved'));
    table4 = $('.datatable-denied').DataTable(setParam('denied'));
    table5 = $('.datatable-expired').DataTable(setParam('expired'));
    table6 = $('.datatable-new').DataTable(setParam('new'));
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
$('.datatable-denied').on('draw.dt', function() {
    $(".denied_count").html(table4.ajax.json().recordsTotal)
});
$('.datatable-expired').on('draw.dt', function() {
    $(".expired_count").html(table5.ajax.json().recordsTotal)
});
$('.datatable-new').on('draw.dt', function() {
    $(".new_count").html(table6.ajax.json().recordsTotal)
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
        url:"/admin/directory/listing",
        type:"get",
        data:{status:status, user:'all'}
    };

    let columns=[
        { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
        { data: 'category', name: 'category'},
        { data: 'title', name: 'title'},
        { data: 'user', name: 'user', orderable: false, searchable: false },
        { data: 'purchased', name: 'purchased' },
        { data: 'property', name: 'property' },
        { data: 'view_count', name: 'view_count' },
        { data: 'featured', name: 'featured' },
        { data: 'status', name: 'status' },
        { data: 'expired_at', name: 'expired_at' },
        { data: 'created_at', name: 'created_at' },
        { data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns, 9, false);
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
$(document).on("change", '#switchAction', function() {
    switch_action = $(this).val();
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
        case 'pending':
            msg = 'Do you want to set pending '+item+'?';
            break;
        case 'paid':
            msg = 'Do you want to set as newly paid '+item+'?';
            break;
        case 'expired':
            msg = 'Do you want to set as expired '+item+'?';
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
        url:"/admin/directory/listing/switch",
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
                table6.ajax.reload();
                $("#switchAction").val(null).selectpicker("refresh")

            }
        },
        error:function(e) {
            console.log(e);
        }
    })
}
