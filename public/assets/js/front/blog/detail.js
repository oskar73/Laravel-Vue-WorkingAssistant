

$(document).ready(function() {
   addTinymce();

   loadComments();
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
function loadComments()
{
    $('.all_comment_area').load(blog_ajaxComment);
}
$(document).on("submit", ".post_comment_form", function(e) {
    e.preventDefault();
    tinyMCE.triggerSave();
    var comment = $(this).find(".comment_box").html();

    if(comment==''||comment=='<p><br data-mce-bogus="1"></p>')
    {
        itoastr('error', "Please leave comment!");
        $(".error-comment").html("Please leave comment!");
    }else {
        $(this).find(".smtBtn").prop("disabled", true).html("<i class='fa fa-spinner fa-spin'></i>");

        var formData = new FormData(this);
        formData.append("comment", comment);

        console.log(comment)
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
                console.log(result)
                $(".smtBtn").prop("disabled", false).html("Submit");
                $(".form-control-feedback").html("");
                if(result.status===0)
                {
                    dispErrors(result.data);
                    dispValidErrors(result.data);
                }else {
                    itoastr('success', 'Successfully Created!');
                    $(".reply.post_comment_form").remove();
                    loadComments();
                    $(".comment_box").html("");
                }
            },
            error: function(e)
            {
                console.log(e)
            }
        });
    }

})

$(document).on("click", ".response_btn", function() {
    var area = $(this).data("id");
   $(".subcomment_area[data-area='"+area+"']").slideToggle();
});
$(document).on("click", ".reply_btn", function() {
   var id = $(this).data("id");
    $.ajax({
        url:blog_getCommentForm,
        data:{comment_id:id},
        success: function(result)
        {
            if(result.status===1)
            {
                $(".reply.post_comment_form").remove();
                $(".reply_btn[data-id='"+id+"']").closest(".comment_card").after(result.data);
                tinyMCE.execCommand('mceRemoveEditor', false, 'comment');
                addTinymce();
            }

        },
        error: function(e)
        {
            console.log(e)
        }
    });
});
$(document).on('click', '.blog_comment_ajax_area .pagination a', function(e){
    e.preventDefault();
    $('.all_comment_area').load($(this).attr('href'))
});
function favoriteComment(id, like)
{
    event.preventDefault();
    $.ajax({
        url:blog_favoriteComment,
        method: 'get',
        data:{id:id, like:like},
        success:function(result)
        {
            if(result.status===1)
            {
                console.log(result.data)
                if(result.data==1)
                {
                    $("#like-comment-"+id).removeClass('favorite_post');
                }else if(result.data ==2)
                {
                    $("#like-comment-"+id).addClass('favorite_post');
                    $("#dislike-comment-"+id).removeClass('favorite_post');
                }else if(result.data==3)
                {
                    $("#dislike-comment-"+id).removeClass('favorite_post');
                }else if(result.data==4)
                {
                    $("#dislike-comment-"+id).addClass('favorite_post');
                    $("#like-comment-"+id).removeClass('favorite_post');
                }
                $("#like-comment-"+id+" span").html(result.like_count);
                $("#dislike-comment-"+id+" span").html(result.dislike_count);
            }else{
                if(result.data==='login')
                {
                    window.location.href="/login";
                }
            }
        },
        error:function(e)
        {
            console.log(e);
        }
    })
}
