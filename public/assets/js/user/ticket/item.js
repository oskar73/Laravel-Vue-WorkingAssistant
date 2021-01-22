
var switch_action;
var checkbox_count;
var table1,table2,table3,table4;
var alone=0;
var selected;

$(function () {
    hashUpdate(window.location.hash);
    table1 = $('.datatable-opened').DataTable(setParam('opened'));
    table2 = $('.datatable-all').DataTable(setParam('all'));
    table3 = $('.datatable-answered').DataTable(setParam('answered'));
    table4 = $('.datatable-closed').DataTable(setParam('closed'));
});

$('.datatable-opened').on('draw.dt', function() {
    $(".opened_count").html(table1.ajax.json().recordsTotal)
});
$('.datatable-all').on('draw.dt', function() {
    $(".all_count").html(table2.ajax.json().recordsTotal)
});
$('.datatable-answered').on('draw.dt', function() {
    $(".answered_count").html(table3.ajax.json().recordsTotal)
});
$('.datatable-closed').on('draw.dt', function() {
    $(".closed_count").html(table4.ajax.json().recordsTotal)
});
function setParam(status)
{
    let ajax = {
        url:"/account/ticket",
        type:"get",
        data:{status:status}
    };

    let columns=[
        { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
        { data: 'id', name: 'id'},
        { data: 'category', name: 'category'},
        { data: 'text', name: 'text'},
        { data: 'priority', name: 'priority' },
        { data: 'status', name: 'status' },
        { data: 'created_at', name: 'created_at' },
        { data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns, 7, false);
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
    var item = checkbox_count+" tickets";
    alone = 0;
    switchAlert(item);
});
$(document).on("click", '.switchOne', function() {
    switch_action = $(this).data("action");
    alone = 1;
    selected = $(this).parent().parent().find(".checkbox").data("id");
    switchAlert('this ticket');
});
function switchAlert(item) {
    var msg;

    switch(switch_action) {
        case 'close':
            msg = 'Do you want to close '+item+'?';
            break;
    }
    askToast.question('Confirm', msg, 'switchAction');
}
function switchAction()
{
    $.ajax({
        url:"/account/ticket/switch",
        data:{ids:checkedIds(), action:switch_action},
        method:"get",
        success:function(result) {
            console.log(result)
            if(result.status===0)
            {
                dispErrors(result.message)
            }else {
                itoastr("success", 'Successfully updated!');

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
