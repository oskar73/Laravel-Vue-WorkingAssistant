
$(function () {
    tinymceInit("#content", false);
    addTinymce();
});

function addTinymce() {
    tinymce.init({
        selector: '#nav_title',  // change this value according to the HTML
        inline:false,
        plugins: 'link',
        toolbar: 'styleselect  fontselect fontsizeselect  forecolor backcolor bold italic link',
        menubar:false,
        statusbar:false,
        height:"120px",
        paste_preprocess: function (plugin, args) {
            console.log("Attempted to paste: ", args.content);
            // replace copied text with empty string
            args.content = '';
        },
    });
}
$(document).on("submit", "#submit_form", function(e) {
    e.preventDefault();
    tinyMCE.triggerSave();

    $(this).find(".smtBtn").prop("disabled", true).html("<i class='fa fa-spinner fa-spin'></i>");

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
            console.log(result)
            $(".smtBtn").prop("disabled", false).html("Submit");
            $(".form-control-feedback").html("");
            if(result.status===0)
            {
                dispErrors(result.data);
                dispValidErrors(result.data);
            }else {
                itoastr('success', 'Successfully Updated!');
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });

})
