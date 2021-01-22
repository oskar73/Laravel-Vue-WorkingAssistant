
var isInitialized = false;
var previewCropped = '';
var cropper = '';
var file = '';

$(document).ready(function() {
    $("#category").select2({
        width:'100%',
        placeholder: 'Choose Category',
        minimumResultsForSearch: -1
    });
    $("#tag").select2({
        width:'100%',
        placeholder: 'Choose Tags',
        minimumInputLength: 1
    });
    tinymceInit("#description");
});

$("#thumbnail").change(function (event) {
    var file = this.files[0];
    if (file) {
        var img = new Image();

        img.src = window.URL.createObjectURL(file);

        img.onload = function () {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(file);
            window.URL.revokeObjectURL(img.src);
            oFReader.onload = function () {

                $("#thumbnail_image").attr('src', this.result);

                if (isInitialized === true) {
                    cropper.destroy();
                }

                cropper = new Cropper(document.getElementById("thumbnail_image"), {
                    viewMode: 2,
                    dragMode: 'crop',
                    initialAspectRatio:4/3,
                    aspectRatio:4/3,
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

$("#submit_form").submit(function(event) {
    event.preventDefault();
    tinyMCE.triggerSave();
    var formData = new FormData(this);
    if(previewCropped!=='')
    {
        formData.append("image", previewCropped);
    }
    $(".smtBtn").prop("disabled", true).html("<i class='fa fa-spinner fa-spin'></i>");
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
            $(".smtBtn").prop("disabled", false).html("Submit");
            console.log(result)
            if(result.status===0)
            {
                dispErrors(result.data);
                dispValidErrors(result.data);
            }else {
                itoastr('success', 'Successfully Created!');

                setTimeout(function() {
                    window.location.href="/account/blog";
                }, 1000)
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });
});

$("#category").change(function (event) {
    var $tags = $(this).find(':selected').attr('data-tags');
    $("#tag").val(JSON.parse($tags)).trigger('change.select2')
});


