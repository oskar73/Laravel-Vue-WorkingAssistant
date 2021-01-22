
var switch_action;
var checkbox_count;
var table1,table2,table3;
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
        url:"/admin/userManage",
        type:"get",
        data:{status:status}
    };

    let columns=[
        { data: 'avatar', name: 'avatar' },
        { data: 'name', name: 'name' },
        { data: 'email', name: 'email' },
        { data: 'role', name: 'role' },
        { data: 'status', name: 'status' },
        { data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns, 1, false);
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

function switchAlert(item) {
    var msg;

    switch(switch_action) {
        case 'active':
            msg = 'Do you want to verify '+item+'?';
            break;
        case 'inactive':
            msg = 'Do you want to unverify '+item+'?';
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
        url:"/admin/email/subscriber/switch",
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
