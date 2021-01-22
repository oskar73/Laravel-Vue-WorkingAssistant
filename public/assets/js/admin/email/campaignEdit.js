
$(function () {
    tinymceInit("#message_body", true);
    $("#promised_time").datetimepicker({
        todayHighlight: !0,
        autoclose: !0,
        format: "yyyy-mm-dd hh:ii",
        startDate: '0d',
    });

});

$("#notnow").change(function(){
    $(".promised_area").toggleClass('d-none');
});
$(document).on('change', '#category', function(){
    $.ajax({
        url:"/admin/email/campaign/getCategory",
        method:"GET",
        data:{id:$(this).val()},
        success:function(result)
        {
            if(result.status===1)
            {
                $(".template_area").removeClass("d-none");
                $("#template").html(result.data).selectpicker('refresh');
            }
        },
        error : function(err) {
            itoastr('error', err);
        },
    });
});
$(document).on('change', '#template', function(){
    $.ajax({
        url:"/admin/email/campaign/getTemplate",
        method:"GET",
        data:{id:$(this).val()},
        success:function(result)
        {
            if(result.status===1)
            {
                $("#message_body").html(result.data);
            }
        },
        error : function(err) {
            itoastr('error', err);
        },
    });
});
$("#submit_form").on('submit', function(event) {
    event.preventDefault();
    tinyMCE.triggerSave();
    $(".smtBtn").html("<i class='fa fa-spinner fa-spin fa-2x fa-fw'></i>").attr("disabled", true);
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
                    window.location.href="/admin/email/campaign"
                }, 1000);
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });

});

