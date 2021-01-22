
var fbRenderOptions = {
    container: false,
    dataType: 'json',
    formData: formData,
    render: true,
}
$(document).ready(function() {
    $('#build-wrap').formRender(fbRenderOptions);

    if(result!=null&&result!=='')
    {
        var formResult = JSON.parse(result);
        for(var field in formResult)
        {
            $('[name="'+field+'"]').val(formResult[field]);
        }
    }
})

$("#submit_form").on("submit", function(e) {
    e.preventDefault();
    $(".smtBtn").append(" <i class='fa fa-spin fa-spinner'></i>").prop("disabled", true);
    $.ajax({
        url:$(this).attr("action"),
        method:"POST",
        data: new FormData(this),
        dataType:'JSON',
        contentType:false,
        cache:false,
        processData:false,
        success:function(result)
        {
            console.log(result)
            $(".smtBtn").html("Submit").prop("disabled", false);
            if(result.status===0)
            {
                dispErrors(result.data)
            }else {
                itoastr('success', 'Successfully Updated!');

            }
        }

    });

});
