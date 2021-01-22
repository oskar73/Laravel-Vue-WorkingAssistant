
$(function () {
    hashUpdate(window.location.hash);
    if(body==1)
    {
        tinymceInit("#tem_body", true, edit_id);
    }
});

$("#submit_form").on('submit', function(event) {
    event.preventDefault();
    $(".smtBtn").html("<i class='fa fa-spinner fa-spin fa-2x fa-fw'></i>").attr("disabled", true);
    $.ajax({
        url:"/admin/email/template/create",
        method: 'POST',
        data: new FormData(this),
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
                    window.location.href=result.data
                }, 1000);
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });

});

$("#body_form").on('submit', function(event) {
    event.preventDefault();
    $(".smtBtn").html("<i class='fa fa-spinner fa-spin fa-2x fa-fw'></i>").attr("disabled", true);
    if(body==1)
    {
        tinyMCE.triggerSave();
    }
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
                    window.location.reload();
                }, 1000);
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });
});

