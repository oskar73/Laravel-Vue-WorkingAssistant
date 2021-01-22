$(document).ready(function () {
    $("#category").select2({
        width: "100%",
        placeholder: "Choose Category",
        minimumResultsForSearch: -1,
    });
    $("#tag").select2({
        width: "100%",
        placeholder: "Choose Tags",
        minimumInputLength: 1,
    });
    // tinymceInit("#description");
    Laraberg.init("description");

    $("#visible_date").datepicker({
        format: "yyyy-mm-dd",
        todayHighlight: "!0",
        autoclose: !0,
    });
});
$("#submit_form").submit(function (event) {
    event.preventDefault();
    // tinyMCE.triggerSave();
    var formData = new FormData(this);
    if (previewCropped !== "") {
        formData.append("image", previewCropped);
    }
    btnLoading();
    $.ajax({
        url: $(this).attr("action"),
        method: "POST",
        data: formData,
        dataType: "JSON",
        contentType: false,
        cache: false,
        processData: false,
        success: function (result) {
            btnLoadingStop();
            clearError();
            if (result.status === 0) {
                dispErrors(result.data);
                dispValidErrors(result.data);
            } else {
                itoastr("success", "Successfully Updated!");
                reloadAfterDelay();
            }
        },
        error: function (e) {
            console.log(e);
        },
    });
});

$("#category").change(function (event) {
    var $tags = $(this).find(":selected").attr("data-tags");
    $("#tag").val(JSON.parse($tags)).trigger("change.select2");
});
$("#status").change(function (event) {
    if ($(this).val() === "denied") {
        $(".reason_area").show();
    } else {
        $(".reason_area").hide();
    }
});
