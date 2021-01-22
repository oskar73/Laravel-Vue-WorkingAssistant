$(document).on("click", ".connect-account", function (e) {
    e.preventDefault();

    const _this = this;
    $(_this).prop("disabled", true);
    $.ajax({
        url: route("admin.ecommerce.setting.account.link"),
        method: "POST",
        data: {
            _token: token,
            type: $(_this).data("type"),
        },
        success: function (result) {
            $(_this).prop("disabled", false);
            if (result.success && result.url) {
                window.location.href = result.url;
            }
        },
        error: function (e) {
            console.log(e);
        },
    });
});

$(document).on("click", ".open-account", function (e) {
    e.preventDefault();

    const _this = this;
    $(_this).prop("disabled", true);
    $.ajax({
        url: route("admin.ecommerce.setting.account.login"),
        method: "POST",
        data: {
            _token: token,
            type: $(_this).data("type"),
        },
        success: function (result) {
            $(_this).prop("disabled", false);
            if (result.success) {
                window.open(result.url, "_blank");
            }
        },
        error: function (e) {
            console.log(e);
        },
    });
});
