
var switch_action;
var checkbox_count;
var table1,table2,table3,table4;
var alone=0;
var selected;

$(function () {
    hashUpdate(window.location.hash);
    table1 = $('.datatable-pending').DataTable(setParam('pending'));
    table2 = $('.datatable-all').DataTable(setParam('all'));
    table3 = $('.datatable-approved').DataTable(setParam('approved'));
    table4 = $('.datatable-denied').DataTable(setParam('denied'));
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
$(".createBtn").click(function() {
    modalClearToggle();
});

function setParam(status)
{
    let ajax = {
        url:"/admin/blog/comment",
        type:"get",
        data:{status:status}
    };

    let columns=[
        { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
        { data: 'title', name: 'title', orderable: false, searchable: false},
        { data: 'comment', name: 'comment'},
        { data: 'user', name: 'user', orderable: false, searchable: false },
        { data: 'liked_count', name: 'liked_count', orderable: false, searchable: false },
        { data: 'disliked_count', name: 'disliked_count', orderable: false, searchable: false },
        { data: 'status', name: 'status' },
        { data: 'created_at', name: 'created_at' },
        { data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns);
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
    selected = $(this).parents("tr").find(".checkbox").data("id");
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
        case 'delete':
            msg = 'Do you want to delete '+item+'?';
            break;
    }
    askToast.question('Confirm', msg, 'switchAction');
}
function switchAction()
{
    $.ajax({
        url:"/admin/blog/comment/switchComment",
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

            }
        },
        error:function(e) {
            console.log(e);
        }
    })
}
