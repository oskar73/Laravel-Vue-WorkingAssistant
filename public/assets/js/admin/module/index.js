var switch_action;
var get_module;

$(function () {
    hashUpdate(window.location.hash);
    getMyDatatableTable();
    getAllDatatableTable();
});

function getMyDatatableTable() {
    $.ajax({
        url: "/admin/module/getMyModules",
        type: "get",
        dataType: "JSON",
        contentType: false,
        cache: false,
        processData: false,
        success: function (result) {
            if (result.status === 1) {
                $("#my_area .m-portlet__body").html(result.my);
                $(".my_count").html(result.count.my);
                $(".datatable-my").dataTable(dataTblSet());

                $("#canceled_area .m-portlet__body").html(result.canceled);
                $(".canceled_count").html(result.count.canceled);
                $(".datatable-canceled").dataTable(dataTblSet());

                $(".module_limit").html(result.limit.module);
                $(".fmodule_limit").html(result.limit.fmodule);
            }
        },
        error: function (e) {
            console.log(e);
        },
    });
}

function getAllDatatableTable() {
    $.ajax({
        url: "/admin/module/getAllModules",
        type: "get",
        dataType: "JSON",
        contentType: false,
        cache: false,
        processData: false,
        success: function (result) {
            if (result.status === 1) {
                $("#all_area .m-portlet__body").html(result.all);
                $(".all_count").html(result.count);
                $(".datatable-all").dataTable(dataTblSet());
            }
        },
        error: function (e) {
            console.log(e);
        },
    });
}
$(document).on("click", ".getModule", function () {
    get_module = $(this).data("slug");
    askToast.question(
        "Confirm",
        "Do you want to get this module?",
        "getModule"
    );
});

// Publish / un-publish
$(document).on("click", ".switchModule", function () {
    get_module = $(this).data("slug");
    switch_action = $(this).data("action");
    var message;
    if (switch_action === "publish") {
        message = "Do you want to publish this module?";
    } else if (switch_action === "unpublish") {
        message = "Do you want to unpublish this module?";
    } else if (switch_action === "cancel") {
        message =
            "Do you want to cancel this module? We will keep your data for 1 month. This means, if you get this module back in 1 month, you will get all data as same. But after 1 month, your data will be lost.";
    }
    askToast.question("Confirm", message, "switchModule");
});
function switchModule() {
    $.ajax({
        url: window.route("admin.module.switchModule"),
        type: "get",
        data: { module: get_module, action: switch_action },
        success: function (result) {
            if (result.status === 1) {
                itoastr("success", "Success!");
                getMyDatatableTable();
                getAllDatatableTable();
            } else {
                if (result.action) {
                    if (result.action == "payment") {
                        $("#confirm-modal").modal("toggle");
                    }
                } else {
                    dispErrors(result.data);
                }
            }
        },
        error: function (e) {
            console.log(e);
        },
    });
}
function getModule() {
    $.ajax({
        url: "/admin/module/getModule",
        type: "get",
        data: { module: get_module },
        success: function (result) {
            console.log(result);
            if (result.status === 1) {
                itoastr("success", "Success!");

                getMyDatatableTable();
                getAllDatatableTable();
                window.location.reload();
            } else {
                dispErrors(result.data);
            }
        },
        error: function (e) {
            console.log(e);
        },
    });
}
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
            console.log("result", result);
            if (result.success) {
                window.location.href = result.url;
            }
            $(_this).prop("disabled", false);
        },
        error: function (e) {
            console.log(e);
        },
    });
});
