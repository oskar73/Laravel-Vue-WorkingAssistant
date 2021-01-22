
$(function () {
    $.ajax({
        url:"/account/purchase/transaction/invoice/"+invoice_id,
        type:"get",
        dataType:'JSON',
        contentType:false,
        cache:false,
        processData:false,
        success:function(result)
        {
            if(result.status===1)
            {
                $(".invoice_area").html(result.data)
            }
        }
    })
});

$("#downloadBtn").click(function() {
    $(this).append(" <i class='fa fa-spinner fa-spin'></i>");
})
