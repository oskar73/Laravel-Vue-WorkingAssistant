
var switch_action;
var checkbox_count;
var alone=0;
var selected;
var table1, table2, table3;

$(function () {
    hashUpdate(window.location.hash);
    table1 = $('.datatable-all').DataTable(setParam("all"));
    table2 = $('.datatable-unread').DataTable(setParam("unread"));
    table3 = $('.datatable-read').DataTable(setParam("read"));
});

function setParam(status)
{
    let ajax = {
        url:"/admin/purchase/form",
        type:"get",
        data: {status:status, user:"all"},
    };

    let columns=[
        { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
        { data: 'user', name: 'user' },
        { data: 'model_type', name: 'model_type', orderable: false, searchable: false},
        { data: 'model_name', name: 'model_name', orderable: false, searchable: false},
        { data: 'title', name: 'title' },
        { data: 'description', name: 'description' },
        { data: 'status', name: 'status' },
        { data: 'read_at', name: 'read_at' },
        { data: 'created_at', name: 'created_at' },
        { data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns, 8, false);
}

$('.datatable-all').on('draw.dt', function() {
    $(".all_count").html(table1.ajax.json().recordsTotal)
});
$('.datatable-unread').on('draw.dt', function() {
    $(".unread_count").html(table2.ajax.json().recordsTotal)
});
$('.datatable-read').on('draw.dt', function() {
    $(".read_count").html(table3.ajax.json().recordsTotal)
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
        case 'filled':
            msg = 'Do you want to set as filled '+item+'?';
            break;
        case 'needtofill':
            msg = 'Do you want to set as need to fill '+item+'?';
            break;
        case 'needrevision':
            msg = 'Do you want to set as needed revision '+item+'?';
            break;
        case 'completed':
            msg = 'Do you want to set as completed '+item+'?';
            break;
        case 'read':
            msg = 'Do you want to mark as read '+item+'?';
            break;
        case 'unread':
            msg = 'Do you want to mark as unread '+item+'?';
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
        url:"/admin/purchase/form/switch",
        data:{ids:checkedIds(), action:switch_action},
        method:"get",
        success:function(result) {
            console.log(result)
            if(result.error)
            {
                dispErrors(result.message)
            }else {
                itoastr("success", 'Successfully updated!');
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
