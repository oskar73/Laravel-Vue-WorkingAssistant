$(document).ready(function () {
    var $container = $("#m_ver_menu");
    var $scrollTo = $("#m_ver_menu .m-menu__item--active").not(
        ".m-menu__item--open"
    );
    if ($scrollTo.length) {
        var height = $scrollTo.offset().top - $container.height() / 2;

        if (height > 0) {
            $("#m_ver_menu").stop().animate(
                {
                    scrollTop: height,
                },
                300
            );
        }
    }
});
$(document).on("keydown", function (e) {
    // Keyboard Detection: Ctrl + /
    if (e.ctrlKey && e.keyCode === 191 && !$("#header_search").is(":focus")) {
        e.preventDefault();
        document.getElementById("header_search").focus();
    }
});
$(document).on("change", ".uploadImageBox", function (event) {
    var target = $(this).data("target");
    $("#" + target).show();
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById(target);
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
});
function makeid(length) {
    var result = "";
    var characters =
        "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    var charactersLength = characters.length;
    for (var i = 0; i < length; i++) {
        result += characters.charAt(
            Math.floor(Math.random() * charactersLength)
        );
    }
    return result;
}

$(document).on("click", ".selectAll", function () {
    var table = $(this).data("area");
    $(".datatable tbody input[type=checkbox]").prop("checked", false);
    $(".datatable:not(." + table + ") thead input[type=checkbox]").prop(
        "checked",
        false
    );

    if ($(this).prop("checked") === true) {
        $("." + table + " input[type=checkbox]").prop("checked", true);
    } else {
        $("." + table + " input[type=checkbox]").prop("checked", false);
    }
});
$(".m-menu__item .m-menu__link:not(.m-menu__toggle)").click(function () {
    $(".m-menu__item").removeClass("m-menu__item--active");
    $(this).parent().addClass("m-menu__item--active");
});
$(".datatable").on("draw.dt", function () {
    $(".datatable thead input[type=checkbox]").prop("checked", false);
    $(".show_checked").addClass("d-none");
});
$(document).on("mouseenter", ".hover-handle", function (e) {
    e.preventDefault();
    $(this).toggleClass("d-none");
    $(this).next().toggleClass("d-none");
});
$(document).on("mouseleave", ".down-handle", function (e) {
    e.preventDefault();
    $(this).toggleClass("d-none");
    $(this).prev().toggleClass("d-none");
});

var dataTblSet = () => {
    return {
        iDisplayLength: 10,
        aLengthMenu: [
            [10, 20, 50, 100, -1],
            [10, 20, 50, 100, "All"],
        ],
        deferRender: true,
        dom:
            "<'row'<'col-4'i><'col-8'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-7'p>>",
        language: {
            info: "Total: _TOTAL_",
            sLengthMenu: "_MENU_",
        },
        order: [],
        columnDefs: [{ targets: "no-sort", orderable: false }],
    };
};

function setTbl(ajax, columns, order = 1, asc = true) {
    return {
        processing: true,
        serverSide: true,
        retrieve: true,
        ajax: ajax,
        columns: columns,
        order: [[order, asc ? "asc" : "desc"]],
        iDisplayLength: 10,
        aLengthMenu: [
            [10, 20, 50, 100, -1],
            [10, 20, 50, 100, "All"],
        ],
        deferRender: true,
        dom:
            "<'row'<'col-4'i><'col-8'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-7'p>>",
        language: {
            info: "Total: _TOTAL_",
            sLengthMenu: "_MENU_",
            processing:
                '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="loading-txt">Loading...</span>',
        },
    };
}

function checkedIds() {
    let ids = [];
    if (alone === 0) {
        $(".datatable tbody input[type=checkbox]:checked").each(function (
            index
        ) {
            ids.push($(this).data("id"));
        });
    } else {
        ids.push(selected);
    }
    return ids;
}

function tinymceInit(selector = "textarea", inline = false, folder = null) {
    var path;
    if (folder == null) {
        path = "/uploadImage";
    } else {
        path = "/uploadImage/" + folder;
    }
    tinymce.init({
        selector: selector,
        inline: inline,
        menubar: false,
        resize: "both",
        statusbar: false,
        style_formats_autohide: true,
        toolbar:
            "undo redo | styleselect  fontselect fontsizeselect  forecolor backcolor | alignleft aligncenter alignright bullist numlist outdent indent code bold italic blockquote | link image preview media table",
        plugins:
            "image autolink autoresize code link lists fullscreen media preview autosave table legacyoutput",
        min_height: 150,
        remove_script_host: true,
        convert_urls: true,
        image_title: true,
        automatic_uploads: true,
        relative_urls: false,
        images_upload_url: path,
        file_picker_types: "image",
        file_picker_callback: function (cb, value, meta) {
            var input = document.createElement("input");
            input.setAttribute("type", "file");
            input.setAttribute("accept", "image/*");

            input.onchange = function () {
                var file = this.files[0];

                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function () {
                    var id = "blobid" + new Date().getTime();
                    var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(",")[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);
                    cb(blobInfo.blobUri(), { title: file.name });
                };
            };
            input.click();
        },
    });

    return true;
}

function ajaxSelect2(url, placeholder, id, name) {
    return {
        width: "100%",
        placeholder: placeholder,
        minimumInputLength: 1,
        ajax: {
            url: url,
            dataType: "json",
            data: function (params) {
                return {
                    q: $.trim(params.term),
                };
            },
            delay: 250,
            processResults: function (result) {
                console.log(result);
                return {
                    results: $.map(result.data, function (item) {
                        return {
                            text: item[name],
                            id: item[id],
                        };
                    }),
                };
            },
            cache: true,
        },
    };
}
