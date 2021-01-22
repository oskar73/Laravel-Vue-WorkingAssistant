
$(document).ready(function() {
    hashUpdate(window.location.hash);
    $(".selectpicker").selectpicker();
});

$("#submit_form").on('submit', function(event) {
    event.preventDefault();
    var formData = new FormData(this);
    if(previewCropped!=='')
    {
        formData.append("thumbnail", previewCropped);
    }
    btnLoading();
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
            btnLoadingStop();
            clearError();
            if(result.status===0)
            {
                dispValidErrors(result.data)
                dispErrors(result.data)
            }else {
                itoastr('success', 'Success!');
                window.location.hash="#/price";
                reloadAfterDelay()
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });

});



