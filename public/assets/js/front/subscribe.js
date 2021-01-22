
$(function(){
    window.setTimeout(function() {
        getSubscribeForm();
    }, 3000);

    function getSubscribeForm()
    {
        $.ajax({
            url:"/getSubscribeForm",
            success:function(result)
            {
                console.log(result);
                if(result.status===1)
                    $(".newsletter_area").html(result.data);
            }
        });
    }
    $(document).on("click", ".newsletter_container .close_btn", function(e) {
        e.preventDefault();
        $(".newsletter_container").remove();
        $.ajax({
            url:"/closeSubscribeForm",
        });
    })
    $(document).on("submit", ".newsletter_subscribe_form", function(e) {
        e.preventDefault();

        $.ajax({
            url:$(this).attr("action"),
            method:"POST",
            data:new FormData(this),
            dataType:'JSON',
            contentType:false,
            cache:false,
            processData:false,
            success:function(result)
            {
                console.log(result);
                if(result.status===1)
                {
                    $(".newsletter_area").html(result.data);
                }else {
                    dispValidErrors(result.data);
                }
            }
        });
    });
});
