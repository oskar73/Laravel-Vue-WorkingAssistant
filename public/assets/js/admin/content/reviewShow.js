var item_id;

$(document).on("click", '.editBtn', function() {
    $.ajax({
        url:"/admin/content/review/edit",
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
                $("#rating").val(result.data.rating);
                $("#rating").selectpicker("refresh");
                $("#comment").val(result.data.comment);
                $("#item_modal #status").prop("checked", result.data.status===1? true: false);
            }
        },
        error:function(e) {
            console.log(e);
        }
    })
});

$("#item_modal_form").submit(function(event) {
    event.preventDefault();
    mApp.block("#item_modal .modal-content", {});
    $.ajax({
        url:"/admin/content/review/edit",
        method: 'POST',
        data: new FormData(this),
        dataType:'JSON',
        contentType:false,
        cache:false,
        processData:false,
        success: function(result)
        {
            mApp.unblock("#item_modal .modal-content");
            if(result.status===0)
            {
                dispErrors(result.data)
                dispValidErrors(result.data)
            }else {
                $("#item_modal").modal('toggle');
                itoastr("success", 'Success!');
                reloadAfterDelay();
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });
});
$(".updateBtn").on("click", function(e) {
    e.preventDefault();
    item_id = $(this).data("id");
    askToast.question("confirm", "Are you sure?", "switchAction")
})
function switchAction()
{
    $.ajax({
        url:"/admin/content/review/switch",
        data:{ids:[item_id], action:$("#status").val()==1? 'active':'inactive'},
        method:"get",
        success:function(result) {
            console.log(result)
            if(result.status===0)
            {
                dispErrors(result.data)
            }else {
                itoastr("success", 'Success!');
                reloadAfterDelay();
            }
        },
        error:function(e) {
            console.log(e);
        }
    })
}
