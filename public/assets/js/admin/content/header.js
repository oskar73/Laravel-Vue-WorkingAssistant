
var result ;
var del_id;

$(document).ready(function() {
    getHeaderData();

});

function getHeaderData()
{
    $.ajax({
        url:"/admin/content/header",
        type:"get",
        dataType:'JSON',
        contentType:false,
        cache:false,
        processData:false,
        success:function(result)
        {
            if(result.status===1)
            {
                $(".result_area").html(result.data);

                $('#nestable').nestable({
                    group: 1
                }).on('change', function(e){
                    result = window.JSON.stringify($(e.target).nestable('serialize'));
                    console.log(result)
                    $.ajax({
                        url: '/admin/content/header/updateOrder',
                        method: 'get',
                        data: {result:result},
                        success: function(result)
                        {
                            if(result.status===1)
                            {
                                itoastr('success', 'Successfully updated!');
                                getHeaderData();

                            }else {
                                dispErrors(result.data);
                            }

                        },
                        error: function(data)
                        {
                            itoastr('error', data);
                        }
                    });
                });
            }
        },
        error:function(e) {
            console.log(e);
        }
    })
}
$(document).on('click', '.menu_switch', function() {
    $.ajax({
        url: '/admin/content/header/switchItem',
        method: 'get',
        data: {id:$(this).data("menu")},
        success: function(result)
        {
            console.log(result)
            if(result.status===1)
            {
                itoastr('success', 'Successfully updated!');
                getHeaderData();

            }else {
                dispErrors(result.data);
            }

        },
        error: function(data)
        {
            console.log(data);
        }
    });
});
$(".addCustomMenu").click(function() {
    $("#create_modal").modal("toggle");
});
$(document).on("click", ".menu_edit", function() {
    $.ajax({
        url: '/admin/content/header/edit',
        method: 'get',
        data: {id:$(this).data("menu")},
        success: function(result)
        {
            console.log(result)
            if(result.status===1)
            {
                $("#create_modal").modal("toggle");
                $("#menu_id").val(result.data.id);
                $("#name").val(result.data.name);
                $("#link").val(result.data.url);

            }else {
                dispErrors(result.data);
            }

        },
        error: function(data)
        {
            console.log(data);
        }
    });
});
$(document).on("click", ".menu_delete", function() {
    del_id = $(this).data("id");

    askToast.question('Confirm', "Do you want to delete this custom menu item?", 'deleteItem');
});
function deleteItem()
{
    $.ajax({
        url: '/admin/content/header/delete',
        method: 'delete',
        data: {id:del_id, _token:token},
        success: function(result)
        {
            console.log(result)
            if(result.status===1)
            {
                itoastr("success", "Successfully deleted!");
                getHeaderData();
            }else {
                dispErrors(result.data);
            }

        },
        error: function(data)
        {
            console.log(data);
        }
    });
}
$("#create_modal_form").on("submit", function(event) {
    event.preventDefault();
    mApp.block("#create_modal .modal-content", {});
    $.ajax({
        url: '/admin/content/header/store',
        method: 'POST',
        data: new FormData(this),
        dataType:'JSON',
        contentType:false,
        cache:false,
        processData:false,
        success: function(result)
        {
            mApp.unblock("#create_modal .modal-content", {});

            if(result.status===1)
            {
                itoastr('success', 'Success!');
                $("#create_modal").modal("toggle");
                getHeaderData();
            }else {
                dispErrors(result.data);
            }

        },
        error: function(data)
        {
            console.log(data);
        }
    });
});
