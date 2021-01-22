var page = 1;
$(document).ready(function() {
    getReplies();
});
function getReplies()
{
    $('.item_result').load(`/admin/ticket/item/reply/${item_id}`);
}
$(document).on('click', '.pagination_area .pagination a', function(e){
    e.preventDefault();
    $('.item_result').load($(this).attr("href"));
});

$("#submit_form").on('submit', function(event) {
    event.preventDefault();
    $(".smtBtn").html("<i class='fa fa-spinner fa-spin fa-2x fa-fw'></i>").attr("disabled", true);
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
                    window.location.reload()
                }, 1000);
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });

});
