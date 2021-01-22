
var switch_action;
var checkbox_count;
var table1,table2,table3;
var alone=0;
var selected;

$(function () {
    hashUpdate(window.location.hash);
    $(".select_picker").selectpicker();
    table1 = $('.datatable-active').DataTable(setParam('active'));
    table2 = $('.datatable-inactive').DataTable(setParam('inactive'));
    table3 = $('.datatable-used').DataTable(setParam('used'));

    $("#expire_date").datetimepicker({
        todayHighlight:!0,
        autoclose:!0,
        format:"yyyy-mm-dd hh:ii"
    });
});
$('.datatable-active').on('draw.dt', function() {
    $(".active_count").html(table1.ajax.json().recordsTotal)
});
$('.datatable-inactive').on('draw.dt', function() {
    $(".inactive_count").html(table2.ajax.json().recordsTotal)
});
$('.datatable-used').on('draw.dt', function() {
    $(".used_count").html(table3.ajax.json().recordsTotal)
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

$("#generateCode").click(function() {
    var code = makeid(8);
    $("#code").val(code);
});
$(document).on("change", "#type", function() {
    var type = $(this).val();
    if(type==='all')
    {
        $(".product_area").addClass("d-none");
    }else {
        $(".product_area").removeClass("d-none");
        getType(type, 0);
    }
});
function getType(type, value)
{
    $.ajax({
        url:"/admin/coupon/product",
        data:{type:type},
        method:"get",
        success:function(result) {
            console.log(result)
            if(result.status===0)
            {
                dispErrors(result.data)
            }else {
                var obj = $("#product");
                obj.html(result.data);
                obj.val(value);
                obj.selectpicker('refresh');
            }
        },
        error:function(e) {
            console.log(e);
        }
    })
}
$("#item_modal_form").on("submit", function(e) {
   e.preventDefault();
   $(".smtBtn").append("<i class=\"loading_div fas fa-spinner fa-spin fa-fw\"></i>").attr("disabled", true);
    $.ajax({
        url:"/admin/coupon",
        method: 'POST',
        data: new FormData(this),
        dataType:'JSON',
        contentType:false,
        cache:false,
        processData:false,
        success: function(result)
        {
            console.log(result)
            $(".smtBtn").attr("disabled", false);
            $(".loading_div").remove();
            $(".form-control-feedback").html("");
            if(result.status===0)
            {
                dispErrors(result.data)
                dispValidErrors(result.data)
            }else {
                $("#item_modal").modal('toggle');
                itoastr("success", 'Success!');
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
function setParam(status)
{
    let ajax = {
        url:"/admin/coupon",
        type:"get",
        data:{status:status}
    };

    let columns=[
        { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
        { data: 'name', name: 'name'},
        { data: 'code', name: 'code'},
        { data: 'type', name: 'type', orderable: false, searchable: false },
        { data: 'product', name: 'product', orderable: false, searchable: false },
        { data: 'user', name: 'User', orderable: false, searchable: false },
        { data: 'discount', name: 'discount' },
        { data: 'reusable', name: 'reusable' },
        { data: 'status', name: 'Status' },
        { data: 'expired_at', name: 'expired_at' },
        { data: 'created_at', name: 'created_at' },
        { data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns);
}
$(document).on("click", ".view_code", function() {
    let code = $(this).data("code");
    $(this).html(code);
})
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
        url:"/admin/coupon/edit",
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
                $("#name").val(result.data.name);
                $("#code").val(result.data.code);
                $("#discount").val(result.data.discount);
                $("#type").val(result.data.type);
                if(result.data.type!='all')
                {
                    $(".product_area").removeClass("d-none");
                    getType(result.data.type, result.data.product_id);
                }else {
                    $(".product_area").addClass("d-none");
                }
                $("#user").val(result.data.user_id);
                $("#expire_date").val(result.data.expired_at).datetimepicker('update');
                $("#reusable").val(result.data.reusable);
                $("#status").val(result.data.status);
                $(".select_picker").selectpicker("refresh");
            }
        },
        error:function(e) {
            console.log(e);
        }
    })
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
        url:"/admin/coupon/switch",
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
