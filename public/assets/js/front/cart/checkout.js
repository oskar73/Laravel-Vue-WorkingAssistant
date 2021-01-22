var type;

$(".submit-btn").on("click", function () {
    type = $(this).data("type");
});

$(document).on("submit", "#checkout_form", function (e) {
    e.preventDefault();

    $(".submit-btn").attr("disabled", true);
    var formData = new FormData(this);
    var shippingInfo = {};
    formData.forEach(function (value, key) {
        shippingInfo[key] = value;
    });

    $.ajax({
        url: $(this).action,
        method: "POST",
        data: {
            _token: token,
            type,
            shipping: shippingInfo,
        },
        success: function (res) {
            if (res.success) {
                window.location.href = res.url;
            } else {
                $(".submit-btn").attr("disabled", false);
            }
        },
        error: function (e) {
            $(".submit-btn").attr("disabled", false);
        },
    });
});
