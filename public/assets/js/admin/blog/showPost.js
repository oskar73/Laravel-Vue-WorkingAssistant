$(".deny_btn").click(function(e) {
    e.preventDefault();
    $("#denied_reason_modal").modal('toggle');
});

$(".approve_btn").click(function(e) {
    e.preventDefault();
    askToast.question("Do you want to approve this post?", "", "approve");

});
function approve()
{
    $.ajax({
        url:"/admin/blog/post/switchPost",
        data:{ids:[id], action:"approve"},
        method:"get",
        success:function(result) {
            console.log(result)
            if(result.status===0)
            {
                dispErrors(result.data)
            }else {
                itoastr("success", 'Success');
                reloadAfterDelay();
            }
        },
        error:function(e) {
            console.log(e);
        }
    })
}

$('#denied_reason_form').on('submit', function (event) {
    event.preventDefault();
    btnLoading();
    $.ajax({
        url:$(this).attr("action"),
        method:"get",
        data:{ids:[id], denied_reason:$("#denied_reason").val(), action:"deny"},
        success:function(result) {
            btnLoadingStop();
            clearError();
            if(result.status===0)
            {
                dispErrors(result.data)
            }else {
                itoastr("success", 'Success');
                reloadAfterDelay();
            }
        },
        error:function(e) {
            console.log(e);
        }
    })
});
