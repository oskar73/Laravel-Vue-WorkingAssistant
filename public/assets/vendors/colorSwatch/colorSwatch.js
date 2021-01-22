$(".lightModeClk").click(function() {
    $("#color_body").removeClass().addClass("light");
    $("#dark-icon").show();
    $("#light-icon").hide();
});
$(".darkModeClk").click(function() {
    $("#color_body").removeClass();
    $("#dark-icon").hide();
    $("#light-icon").show();
});
$(".setRdmClk").click(function() {
    setRandomColor();
    updatePreview();
});
function setRandomColor() {
    $(".jfa-lock").each(function(index2, item) {
        if(!$(this).hasClass("active"))
        {
            let uniqColor = getRandomColor();
            $(this).parent().parent().find(".child-color .jscolor").css("background-color", "#"+uniqColor);;
            $(this).parent().parent().find(".child-color .jscolor").val(uniqColor);
            $(this).parent().find("h3").html(uniqColor);
        }
    });
}
function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

$(".jscolor").change(function() {
    var value = $(".jscolor.jscolor-active").val();
    $(this).parent().parent().find(".hexcolor h3").html(value);
    updatePreview();
})
$(".jfa-copy").click(function() {
    var element = $(this).parent().find("h3").get( 0 );
    copyText(element);
    $(".tipso_content").html("Copied")
});
$(".jfa-lock").click(function() {
    $(this).toggleClass("active")
});
function copyText(element) {
    var range, selection;
    if (window.getSelection) {
        selection = window.getSelection();
        range = document.createRange();
        range.selectNodeContents(element);
        selection.removeAllRanges();
        selection.addRange(range);
    }

    try {
        document.execCommand('copy');
    }
    catch (err) {
        alert('unable to copy color');
    }
}

function toHex(n) {
    n = parseInt(n, 10);
    if (isNaN(n))  return "00";
    n = Math.max(0, Math.min(n, 255));
    return "0123456789ABCDEF".charAt((n - n % 16) / 16)  + "0123456789ABCDEF".charAt(n % 16);
}

function rgbToHex(R, G, B) {
    return toHex(R) + toHex(G) + toHex(B);
}

function imageIsLoaded(e) {
    var img = new Image();
    img.onload = function(){
        canvas.width  = this.width;
        canvas.height = this.height;
        var old_width = canvas.width;
        context.drawImage(this, 0, 0);
        if ($(window).width() > 1000) {
            canvas.width=1000;
        }else if($(window).width() >600 && $(window).width() < 1000)
        {
            canvas.width=800;
        }else if($(window).width() < 600)
        {
            canvas.width=400;
        }

        canvas.height=(canvas.height*canvas.width)/old_width;
        context.drawImage(img,0,0,img.width,img.height,0,0,canvas.width,canvas.height);
    };
    img.src = e.target.result;
}
