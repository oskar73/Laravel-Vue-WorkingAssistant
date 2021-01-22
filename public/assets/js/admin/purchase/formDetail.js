
var fbRenderOptions = {
    container: false,
    dataType: 'json',
    formData: formData,
    render: true,
}

$('#build-wrap').formRender(fbRenderOptions);

if(result!=null&&result!=='')
{
    var formResult = JSON.parse(result);
    for(let field in formResult)
    {
        $('[name="'+field+'"]').val(formResult[field]);
    }
}

$(document).on('change', '#status', function() {
    if($(this).val()==="needrevision"){
        $("#reason_modal").modal("toggle");
    }
});

$(".smtBtn").click(function(e) {
    var btn = $(".smtBtn");
    btn.html("<i class='fa fa-spin fa-spinner fa-2x'></i>").prop("disabled", true);
    $.ajax({
        url:"/admin/purchase/form/switch",
        data:{ids:[btn.data("id")], action:$("#status").val(), reason:$("#reason").val()},
        method:"get",
        success:function(result) {
            btn.prop("disabled", false).html("Submit");
            if(result.status===0)
            {
                dispErrors(result.data)
            }else {
                itoastr("success", 'Successfully updated');
                window.setTimeout(function() {
                    window.location.reload();
                }, 1000)
            }
        },
        error:function(e) {
            console.log(e);
        }
    })

});
