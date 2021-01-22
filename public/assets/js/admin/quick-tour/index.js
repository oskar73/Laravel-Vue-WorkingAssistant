
var switch_action;
var checkbox_count;
var alone=0;
var selected;

$(function () {
    hashUpdate(window.location.hash);
    getDatatableTable();
});

function getDatatableTable()
{
    $.ajax({
        url:"/admin/quick-tours",
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

                $("#all_area .m-portlet__body").html(result.all);
                $("#active_area .m-portlet__body").html(result.active);
                $("#inactive_area .m-portlet__body").html(result.inactive);
                $(".all_count").html(result.count.all)
                $(".active_count").html(result.count.active)
                $(".inactive_count").html(result.count.inactive)
                $(".datatable").dataTable(dataTblSet())
                $(".select2").select2({
                    width:'100%'
                });
            }
        },
        error:function(e) {
            console.log(e);
        }
    })
}

function initializeSelect2(data) {
    $('.select2.select2-container').remove()
    $("#targetID").select2({
        placeholder: "Select Target",
        allowClear: true,
        tags: false,
        minimumResultsForSearch: -1,
        dropdownAutoWidth: true,
        ajax: {
            url: '/admin/quick-tours/get-target-ids',
            dataType: 'json',
            type: "GET",
            data: function(params) {
                return {
                    selected: data
                }
            }
        }
    });
}

$(".createBtn").click(function() {
    $("#item_id").val(null);
    $("#title").val('');
    $("#description").val('');
    $("#targetID").val('').trigger('change');
    initializeSelect2(null)
    $("#create_modal").modal('toggle')
});
$("#create_modal_form").submit(function(event) {
    event.preventDefault();

    mApp.block("#create_modal .modal-content", {});
    $.ajax({
        url:"/admin/quick-tours",
        method: 'POST',
        data: new FormData(this),
        dataType:'JSON',
        contentType:false,
        cache:false,
        processData:false,
        success: function(result)
        {
            mApp.unblock("#create_modal .modal-content");
            if(result.status===0)
            {
                dispErrors(result.data)
            }else {
                itoastr('success', 'Successfully Updated!');
                getDatatableTable();
                $("#create_modal").modal('toggle')
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });
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
$(document).on('click', '.edit_btn', function() {
    var item = $(this).data("item");
    $("#item_id").val(item.id);
    $("#title").val(item.title);
    $("#description").val(item.description);
    $("#targetID").val(item.targetID);
    if(item.status===1)
    {
        $("#status").prop("checked", true);
    }else {
        $("#status").prop("checked", false);
    }
    initializeSelect2(item.targetID)
    $("#create_modal").modal('toggle');
})
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
        url:"/admin/quick-tours/switch",
        data:{ids:checkedIds(), action:switch_action},
        method:"get",
        success:function(result) {
            console.log(result)
            if(result.error)
            {
                dispErrors(result.message)
            }else {
                itoastr("success", 'Successfully updated!');
                getDatatableTable()

            }
        },
        error:function(e) {
            console.log(e);
        }
    })
}
$('.sortBtn').click(function () {
    mApp.blockPage()
    $.ajax({
        url: '/admin/quick-tours/sort',
        method: 'GET',
        success: function (result) {
        //   console.log(result)
            mApp.unblockPage()
            $('#sortable').html(result.view)
            $('#sort-modal').modal('toggle')
            $('#sortable').sortable()
            $('#sortable').disableSelection()
        },
        error: function (err) {
            console.log('Error!', err)
        }
    })
})
$('#sort_submit').click(function () {
    mApp.block('#sort-modal .modal-content', {})
    var sorts = []
    $('#sortable li').each(function (index) {
        sorts.push($(this).data('id'))
    })
    $.ajax({
        url: '/admin/quick-tours/sort',
        method: 'POST',
        data: { _token: token, sorts: sorts },
        success: function (result) {
            itoastr('success', 'Successfully Updated!')
            mApp.unblock('#sort-modal .modal-content', {})
            $('#sort-modal').modal('toggle')
            getDatatableTable()
        },
        error: function (err) {
            console.log('Error!', err)
        }
    })
})
