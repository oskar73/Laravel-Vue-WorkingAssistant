var isInitialized = false;
var previewCropped = '';
var cropper = '';
var file = '';

var oFReader;
$("#thumbnail").change(function (event) {
    file = this.files[0];
    var output = document.getElementById($(this).data("target"));

    if (file) {
        var img = new Image();

        oFReader = new FileReader();

        img.src = window.URL.createObjectURL(file);

        img.onload = function () {
            if (roundFloat(ratio_height / ratio_width) == roundFloat(this.height / this.width)) {
                if (isInitialized === true) {
                    cropper.destroy();
                }
                output.src = img.src;
                previewCropped = '';
                itoastr("success", "Image radio is fine");
                return true;
            } else {
                output.src = "";
                $("#thumbnail").val("");

                iziToast.info({
                    title: 'Info',
                    displayMode: 2,
                    message: `Image width to height ratio should be ${ratio_width}:${ratio_height} . You can either upload an image of this ratio or `,
                    position: 'topRight',
                    timeout: false,
                    buttons: [
                        ['<button>crop your image here.</button>', function (instance, toast) {
                            instance.hide({transitionOut: 'fadeOutUp'}, toast);

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
                                    initialAspectRatio: ratio_width / ratio_height,
                                    aspectRatio: ratio_width / ratio_height,
                                    autoCropArea: 1,
                                    checkOrientation: true,
                                    cropBoxMovable: true,
                                    cropBoxResizable: true,
                                    zoomOnTouch: true,
                                    zoomOnWheel: true,
                                    guides: true,
                                    highlight: true,
                                    crop: async () => {
                                        const canvas = cropper.getCroppedCanvas();
                                        previewCropped = canvas.toDataURL();
                                        const fileSize = getSizeOfBase64Image(previewCropped)
                                        if (fileSize > 1000) {
                                            previewCropped = await resizeImage(previewCropped, 1000, 0.1)

                                            console.log(getSizeOfBase64Image(previewCropped))
                                        }
                                    }
                                });
                                isInitialized = true;
                            };

                        }, true],
                    ]
                });
                return true;
            }

        }
    }
});

function getSizeOfBase64Image(base64Image) {
    const stringLength = base64Image.length - 'data:image/png;base64,'.length;
    const sizeInBytes = 4 * Math.ceil((stringLength / 3)) * 0.5624896334383812;
    return sizeInBytes / 1000;
}

function resizeImage(image, width) {
    return new Promise(resolve => {
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d')

        const img = new Image();
        img.onload = () => {

            if (img.width > width) {
                canvas.width = width
                canvas.height = width / img.width * img.height

                context.drawImage(img, 0, 0, img.width, img.height, 0, 0, canvas.width, canvas.height);

                resolve(canvas.toDataURL());
            }

            resolve(image)
        };

        img.src = image;
    })
}

var i = 0;
var j = 0;
var k = 0;

$(document).on("click", "#addImage", function () {
    $("#image_area").append("<tr><td><input type=\"file\" accept=\"image/*\" name='images[]' class=\"form-control m-input--square uploadImageBox\" data-target='image-" + i + "'></td><td><img id='image-" + i + "' class='width-150' /></td><td><button class='btn btn-danger btn-sm delBtn'>X</button></td></tr>");
    i++;
});
$(document).on("click", "#addVideo", function () {
    $("#video_area").append("<tr><td><input type=\"file\" accept=\"video/*\" name='videos[]' class=\"form-control m-input--square\"></td><td><button class='btn btn-danger btn-sm delBtn'>X</button></td></tr>");
    j++;
});
$(document).on("click", "#addLink", function () {
    $("#link_area").append("<tr><td><input type=\"url\" name='links[]' class=\"form-control m-input--square\"></td><td><button class='btn btn-danger btn-sm delBtn'>X</button></td></tr>");
    k++;
});
$(document).on("click", ".delBtn", function () {
    $(this).parent().parent().remove();
})
