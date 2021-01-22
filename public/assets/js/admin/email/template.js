
var switch_action;
var checkbox_count;
var table1;
var alone=0;
var selected;

$(function () {
    hashUpdate(window.location.hash);
    getMyDatatableTable();
    table1 = $('.datatable-online').DataTable(setParam());
    $("#category").selectpicker();
});

function getMyDatatableTable()
{
    $.ajax({
        url:"/admin/email/template",
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

                $("#my_area .m-portlet__body").html(result.my);
                $(".my_count").html(result.count.my)
                $(".datatable-my").dataTable(dataTblSet());

            }
        },
        error:function(e) {
            console.log(e);
        }
    })
}

function setParam()
{
    let ajax = {
        url:"/admin/email/template/onlineTemplate",
        type:"get",
    };

    let columns=[
        { data: 'category', name: 'category', orderable: false, searchable: false },
        { data: 'name', name: 'name', orderable: false, searchable: false },
        { data: 'image', name: 'image', orderable: false, searchable: false },
        { data: 'downloads', name: 'downloads' },
        { data: 'new', name: 'new' },
        { data: 'featured', name: 'featured' },
        { data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns, 2);
}

$(document).on("click", '.previewBtn', function(e) {
    e.preventDefault();
    var url = $(this).attr("href");
    $("#preview_modal .modal-content").load(url);
    $("#preview_modal").modal("toggle");
});
$(document).on("click", '.saveBtn', function(e) {
    e.preventDefault();
    $("#template_slug").val($(this).data("slug"));
    $("#name").val($(this).data("name"));
    $("#description").val($(this).data("description"));
    $("#save_modal").modal("toggle");
});
$('.datatable-online').on('draw.dt', function() {
    $(".online_count").html(table1.ajax.json().recordsTotal)
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
        url:"/admin/email/template/switch",
        data:{ids:checkedIds(), action:switch_action},
        method:"get",
        success:function(result) {
            console.log(result)
            if(result.status===0)
            {
                dispErrors(result.data);
            }else {
                itoastr("success", 'Successfully updated');
                getMyDatatableTable();
            }
        },
        error:function(e) {
            console.log(e);
        }
    })
}

$("#save_modal_form").submit(function(event) {
    event.preventDefault();
    mApp.block("#save_modal .modal-content", {});
    $.ajax({
        url:"/admin/email/template/saveOnlineTemplate",
        method: 'POST',
        data: new FormData(this),
        dataType:'JSON',
        contentType:false,
        cache:false,
        processData:false,
        success: function(result)
        {
            mApp.unblock("#save_modal .modal-content");
            if(result.status===0)
            {
                dispErrors(result.data);
                dispValidErrors(result.data);
            }else {
                itoastr('success', 'Successfully Updated!');
                $("#save_modal").modal('toggle');
                getMyDatatableTable();
                table1.ajax.reload();
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });
});
