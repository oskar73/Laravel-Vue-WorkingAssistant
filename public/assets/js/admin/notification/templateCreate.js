
$("#submit_form").on('submit', function(event) {
    event.preventDefault();
    var formData = new FormData(this);
    formData.append("body", $("#message_body").html());
    $(".smtBtn").html("<i class='fa fa-spinner fa-spin fa-2x fa-fw'></i>").attr("disabled", true);
    $.ajax({
        url:$(this).attr("action"),
        method: 'POST',
        data: formData,
        dataType:'JSON',
        contentType:false,
        cache:false,
        processData:false,
        success: function(result)
        {
            console.log(result);
            $(".smtBtn").html("Submit").attr("disabled", false);
            $(".form-control-feedback").html("");

            if(result.status===0)
            {
                dispValidErrors(result.data)
                dispErrors(result.data)
            }else {
                itoastr('success', 'Success!');
                setTimeout(function() {
                    window.location.href="/admin/notification/template"
                }, 1000);
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });

});

