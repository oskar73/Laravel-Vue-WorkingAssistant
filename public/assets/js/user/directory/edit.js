var i = 0;
var j = 0;
var k = 0;
var previewCropped = '';
var isInitialized = false;
var cropper = '';
var file = '';

$(document).ready(function() {
    $(".selectpicker").selectpicker();
    addTinymce();
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

    $("#expire_date").datepicker({
        format: 'yyyy-mm-dd',
        startDate: '0d',
        todayHighlight: !0,
        autoclose: !0,
    });
    $("#customer").select2(ajaxSelect2(`/admin/selectUser?user=user`, 'Search user by name or email','id', 'nameEmail'));
});

$("#category").change(function (event) {
    var $tags = $(this).find(':selected').attr('data-tags');
    $("#tag").val(JSON.parse($tags)).trigger('change.select2')
});

function addTinymce() {
    tinymce.init({
        selector: '#description',  // change this value according to the HTML
        inline:false,
        placeholder: "Description",
        plugins: 'link autolink emoticons wordcount paste autoresize lists',
        toolbar: 'bold link unlink emoticons blockquote | styleselect  fontselect fontsizeselect forecolor backcolor | alignleft aligncenter alignright bullist numlist outdent indent',
        menubar:false,
        statusbar:false,
    });
}
$(document).on("click", "#addImage", function() {
    $("#image_area").append("<tr><td><input type=\"file\" accept=\"image/*\" name='images[]' class=\"form-control m-input--square uploadImageBox\" data-target='image-"+i+"'></td><td><img id='image-"+i+"' class='width-150' /></td><td><button class='btn btn-danger btn-sm delBtn'>X</button></td></tr>");
    i++;
});
$(document).on("click", "#addVideo", function() {
    $("#video_area").append("<tr><td><input type=\"file\" accept=\"video/*\" name='videos[]' class=\"form-control m-input--square\"></td><td><button class='btn btn-danger btn-sm delBtn'>X</button></td></tr>");
    j++;
});
$(document).on("click", "#addLink", function() {
    $("#link_area").append("<tr><td><input type=\"url\" name='links[]' class=\"form-control m-input--square\"></td><td><button class='btn btn-danger btn-sm delBtn'>X</button></td></tr>");
    k++;
});
$(document).on("click", ".delBtn", function() {
    $(this).parent().parent().remove();
})

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
                    initialAspectRatio:1,
                    aspectRatio:1,
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

$("#submit_form").on('submit', function(event) {
    event.preventDefault();
    tinyMCE.triggerSave();
    var formData = new FormData(this);
    if(previewCropped!=='')
    {
        formData.append("thumbnail", previewCropped);
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
                itoastr('success', 'Success!');
                setTimeout(function() {
                    window.location.href="/account/directory"
                }, 1000);
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });

});

