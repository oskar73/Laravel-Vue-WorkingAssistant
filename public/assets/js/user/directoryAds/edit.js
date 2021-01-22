
var type = JSON.parse(g_type);
var width = type.width;
var height = type.height;
var i=1;

$(document).ready(function() {

});


$("#image").change(function(event) {
    var target = $(this).data("target");

    var reader = new FileReader();
    reader.onload = function(e)
    {
        var image = new Image();
        image.src = e.target.result;

        image.onload = function () {
            var img_h = this.height;
            var img_w = this.width;

            if (img_h === height && img_w === width) {
                var output = document.getElementById(target);
                output.src=reader.result;
                itoastr("success", "Image size is fine");
                return true;
            }else {
                iziToast.info({
                    title: 'Info',
                    displayMode:2,
                    message: 'Image width and height should be match.' + `${width}x${height}px`,
                    position:'topRight',
                    timeout:false,
                    buttons:[
                        ['<button>Click Here for resize</button>', function (instance, toast) {
                            instance.hide({ transitionOut: 'fadeOutUp' }, toast);
                            window.open("https://www.iloveimg.com/crop-image");
                        }, true],
                    ]
                });
                $("#image").val('');
                return false;
            }
        }
    }
    reader.readAsDataURL(event.target.files[0]);
})

$("#submitForm").on("submit", function(e) {
    e.preventDefault();
    $(".smtBtn").html("<i class='fa fa-spin fa-spinner fa-2x'></i>").prop("disabled", true);

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
            $(".smtBtn").prop("disabled", false).html("Submit");

            if(result.status===0)
            {
                dispErrors(result.data);
                dispValidErrors(result.data);
            }else {
                itoastr('success', 'Success!');
                window.setTimeout(function() {
                    window.location.href="/account/directoryAds"
                }, 1000)
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });
});
