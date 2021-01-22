
var iframe = document.getElementById("preview_iframe");
iframe.onload = function(){
    setTimeout(function(){
        iframe.style.height = iframe.contentWindow.document.body.scrollHeight + 'px';
    }, 1000);
    updatePreview();
}

$(document).ready(function() {
    $("body").toggleClass("m-brand--minimize m-aside-left--minimize");
    $("#m_aside_left_minimize_toggle").toggleClass("m-brand__toggler--active");

    setRandomColor();

    updatePreview();
    $(".preview_area").draggable().resizable({
        handles: 'n, e, s, w, se, ne, sw, nw',
        alsoResize: '#preview_iframe',
    });
});

var target;
var canvas = $('#canvas_picker')[0];
var context = canvas.getContext('2d');
$(".from_file").change(function (e) {
    target = $(this).data("id");
    var F = this.files[0];
    var reader = new FileReader();
    reader.onload = imageIsLoaded;
    reader.readAsDataURL(F);
    $('#myModal').modal('show');
});
$('#canvas_picker').click(function(event){
    var x = event.pageX - $(this).offset().left;
    var y = event.pageY - $(this).offset().top;
    var img_data = context.getImageData(x,y , 1, 1).data;
    var R = img_data[0];
    var G = img_data[1];
    var B = img_data[2];
    var rgb = R + ',' + G + ',' + B ;
    var hex = rgbToHex(R,G,B);
    $('.jgjpickedcolor').val('#' + hex);
    document.getElementById(target).jscolor.fromRGB(R, G, B)
    $("#"+target).parent().parent().find(".hexcolor h3").html(hex);
    updatePreview();
});

$("#submit_form").submit(function(e) {
    e.preventDefault();
    $(".smtBtn").append(" <i class='fa fa-spin fa-spinner'></i>").prop("disbled", true);
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
            $(".smtBtn").html("Submit").prop("disbled", false);
            if(result.status===0)
            {
                dispErrors(result.data)
            }else {
                itoastr('success', 'Success');
                window.setTimeout(function(){
                    window.location.href="/admin/setting/color"
                }, 1000)
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });
})

function updatePreview()
{
    var js1 = $("#js1").val();
    var js2 = $("#js2").val();
    var js3 = $("#js3").val();
    var js4 = $("#js4").val();
    var js5 = $("#js5").val();
    var js6 = $("#js6").val();
    var js7 = $("#js7").val();
    var js8 = $("#js8").val();

    var css1 = '.is-wrapper > div.is-section-100 {height:auto !important;}:root {--second-color: #'+js3+';}.themecolor{background-color:#'+js1+' !important;color:#'+js2+' !important;}.themefont {color:#'+js5+' !important;} body{color:#'+js5+' !important;;background-color:#'+js4+' !important;;} a, a:hover, a:active, a:visited, a:focus {color:#'+js6+' !important;} a:hover {color:#'+js7+' !important;} .favorite_posts .thumb-icon, .favorite_posts .clap_area, .favorite_posts, .color-primary, .icon_color {color:#'+js8+' !important;;border-color:#'+js8+' !important;;}';

    $('.preview_iframe').contents().find('#s_theme_color').html(css1);

}
