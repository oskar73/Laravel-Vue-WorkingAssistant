
$(document).ready(function() {
    $('.lightgallery').lightGallery();
});

$(document).on('change', '#status', function() {
    if($(this).val()==="deny"){
        $("#reason_modal").modal("toggle");
    }
});

$(".smtBtn").click(function(e) {
    var btn = $(".smtBtn");
    btn.html("<i class='fa fa-spin fa-spinner fa-2x'></i>").prop("disabled", true);
    $.ajax({
        url:"/admin/blogAds/listing/switch",
        data:{ids:[btn.data("id")], action:$("#status").val(), reason:$("#reason").val()},
        method:"get",
        success:function(result) {
            btn.prop("disabled", false).html("Submit");
            if(result.status===0)
            {
                dispErrors(result.data)
            }else {
                itoastr("success", 'Successfully updated');

            }
        },
        error:function(e) {
            console.log(e);
        }
    })

});
