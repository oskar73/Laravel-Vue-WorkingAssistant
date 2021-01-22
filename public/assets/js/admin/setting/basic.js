$(document).ready(function() {
    $("#loading").val(loading).selectpicker();
});
$(document).on("submit", "#submit_form", function(e) {
    e.preventDefault();
    $(this).find(".smtBtn").append(" <i class='fa fa-spinner fa-spin'></i>").prop("disabled", true);

    $.ajax({
        url:$(this).attr("action"),
        method: 'POST',
        data: new FormData(this),
        dataType:'JSON',
        contentType:false,
        cache:false,
        processData:false,
        success: function(result)
        {
            console.log(result)
            $(".smtBtn").prop("disabled", false).html("Submit");
            $(".form-control-feedback").html("");
            if(result.status===0)
            {
                dispErrors(result.data);
                dispValidErrors(result.data);
            }else {
                itoastr('success', 'Successfully Updated!');
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });

})
