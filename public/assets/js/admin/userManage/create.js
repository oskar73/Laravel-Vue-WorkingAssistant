var previewCropped = '';
var isInitialized = false;
var cropper = '';
var file = '';

$(function () {
    hashUpdate(window.location.hash);
    $(".selectpicker").selectpicker();
    $(".select2").select2({
        'width':'100%'
    });
});
$("#image").change(function (event) {
    var file = this.files[0];
    if (file) {
        var img = new Image();

        img.src = window.URL.createObjectURL(file);

        img.onload = function () {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(file);
            window.URL.revokeObjectURL(img.src);
            oFReader.onload = function () {
                $("#avatar").attr('src', this.result);

                if (isInitialized === true) {
                    cropper.destroy();
                }

                cropper = new Cropper(document.getElementById("avatar"), {
                    viewMode: 2,
                    dragMode: 'crop',
                    autoCropArea: 1,
                    aspectRatio: 1,
                    checkOrientation: false,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    zoomOnTouch: true,
                    zoomOnWheel: true,
                    guides: true,
                    highlight: true,
                    crop: function (event) {
                        const canvas = cropper.getCroppedCanvas();
                        previewCropped = canvas.toDataURL();
                    }
                });
                isInitialized = true;
            };
        }
    }
});
$("#profileForm").on('submit', function(event) {
    event.preventDefault();
    var formData = new FormData(this);
    if(previewCropped!=='')
    {
        formData.append("image", previewCropped);
    }
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
                itoastr('success', 'Successfully created!');
                setTimeout(function() {
                    window.location.href="/admin/userManage";
                }, 1000);
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });

});
