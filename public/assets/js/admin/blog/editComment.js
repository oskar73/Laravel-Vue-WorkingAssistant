$(document).ready(function() {
    addTinymce();
});

function addTinymce() {
    tinymce.init({
        selector: '.comment_box',  // change this value according to the HTML
        inline:true,
        placeholder: "Leave your comment",
        plugins: 'link autolink emoticons wordcount paste',
        toolbar: 'bold link unlink emoticons blockquote',
        menubar:false,
        statusbar:false,
        paste_preprocess: function (plugin, args) {
            console.log("Attempted to paste: ", args.content);
            // replace copied text with empty string
            args.content = '';
        },
    });
}

$(document).on("submit", ".comment_form", function(e) {
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
