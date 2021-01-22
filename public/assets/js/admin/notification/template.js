
var switch_action;
var checkbox_count;
var table1;
var alone=0;
var selected;

$(function () {
    hashUpdate(window.location.hash);
    table1 = $('.datatable-all').DataTable(setParam());
});

function setParam()
{
    let ajax = {
        url:`/admin/notification/template?category=0`,
        type:"get",
    };

    let columns=[
        { data: 'category', name: 'category', orderable: false, searchable: false },
        { data: 'name', name: 'name' },
        { data: 'subject', name: 'subject' },
        { data: 'fromMail', name: 'fromMail' },
        { data: 'fromName', name: 'fromName' },
        { data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns, 1);
}
$(document).on("change", "#category_filter", function() {
    var category_id = $(this).val();
    table1 = $('.datatable-all').DataTable().ajax.url(`/admin/notification/template?category=${category_id}`).load();
})
$('.datatable-all').on('draw.dt', function() {
    $(".all_count").html(table1.ajax.json().recordsTotal)
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

$(document).on("click", '.switchOne', function() {
    switch_action = $(this).data("action");
    alone = 1;
    selected = $(this).data("id");
    switchAlert('this item');
});

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
        url:"/admin/notification/template/switch",
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

            }
        },
        error:function(e) {
            console.log(e);
        }
    })
}
