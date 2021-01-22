var frontside_head_code,frontside_bottom_code,backside_head_code,backside_bottom_code;

$(function () {
    frontside_head_code = ace.edit("frontside_head_code", {
        theme:"ace/theme/twilight",
        mode:"ace/mode/html",
        autoScrollEditorIntoView: true
    });
    frontside_bottom_code = ace.edit("frontside_bottom_code", {
        theme:"ace/theme/twilight",
        mode:"ace/mode/html",
        autoScrollEditorIntoView: true
    });

    backside_head_code = ace.edit("backside_head_code", {
        theme:"ace/theme/twilight",
        mode:"ace/mode/html",
        autoScrollEditorIntoView: true
    });
    backside_bottom_code = ace.edit("backside_bottom_code", {
        theme:"ace/theme/twilight",
        mode:"ace/mode/html",
        autoScrollEditorIntoView: true
    });
});
    $(document).on("submit", "#submit_form", function(e) {
        e.preventDefault();
        $(this).find(".smtBtn").prop("disabled", true).html("<i class='fa fa-spinner fa-spin'></i>");

        var formData = new FormData(this);
        formData.append("frontside_head_code", frontside_head_code.getValue());
        formData.append("frontside_bottom_code", frontside_bottom_code.getValue());
        formData.append("backside_head_code", backside_head_code.getValue());
        formData.append("backside_bottom_code", backside_bottom_code.getValue());

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

