$(document).ready(function() {
    $("#guest_blog").change(function() {
        if($(this).val()==='both'||$(this).val()==='free')
        {
            $(".post_number_area").css('display', 'block');
        }else {
            $(".post_number_area").css('display', 'none');
        }
    });
    $('#submit_form').on('submit', function(event) {
        event.preventDefault();
        mApp.blockPage();
        $.ajax({
            url:$(this).action,
            method: 'POST',
            data: new FormData(this),
            dataType:'JSON',
            contentType:false,
            cache:false,
            processData:false,
            success: function(result)
            {
                mApp.unblockPage();
                $(".form-control-feedback").html("");
                if(result.status===0)
                {
                    dispErrors(result.data);
                    dispValidErrors(result.data)
                }else {
                    itoastr('success', 'Successfully Updated!');
                }
            },
            error: function(e)
            {
                console.log(e)
            }
        })
    });
});
