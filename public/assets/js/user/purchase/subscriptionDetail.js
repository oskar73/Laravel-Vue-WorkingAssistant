var subscription_id;

$(function () {
    $(".datatable").DataTable();
});

$(".cancel_subscription").click(function(e) {
    e.preventDefault();
    subscription_id = $(this).data("id");
    const msg = "Do you want to cancel this subscription? This will cancel all related products status.";
    askToast.question('Confirm', msg, 'cancelConfirm');
})
function cancelConfirm()
{
    $.ajax({
        url:"/account/purchase/subscription/cancel",
        method:"POSt",
        data:{_token:token, id:subscription_id},
        success:function(result)
        {
            if(result.status===1)
            {
                itoastr('success', 'Successfully canceled.');
                window.setTimeout(function() {
                    window.location.reload();
                }, 1000)
            }else {
                dispErrors(result.data);
            }
        }
    })
}
