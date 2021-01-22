var page = 1;
var checkbox_count = 0;
var alone = 0;
var host, search;
var categories = {};
var tags = {};
var authors = {};
var username, password;

$("#import_form").submit(async function (event) {
    event.preventDefault();
    const input = $("#host").val();
    username = $("#username").val();
    password = $("#password").val();
    if (!input || !username || !password) return;

    $(".smtBtn").prop("disabled", true);
    const [wpHost] = input.split("/");
    host = wpHost;
    search = $("#search").val();
    page = 1;
    getCategories(host);
    getTags(host);
    getAuthors(host);
    renderPosts(page);
});

async function getCategories(host, page = 1) {
    const res = await fetch(
        `https://${host}/wp-json/wp/v2/categories?page=${page}&per_page=100`
    ).then((_) => _.json());
    if (res?.length) {
        categories = res.reduce(
            (acc, cat) => ({ ...acc, [cat.id]: cat.name }),
            categories
        );

        if (res.length == 100) {
            getCategories(host, page + 1);
        } else {
            renderCategories();
        }
    }
}

async function getTags(host, page = 1) {
    const res = await fetch(
        `https://${host}/wp-json/wp/v2/tags?page=${page}&per_page=100`
    ).then((_) => _.json());
    if (res?.length) {
        tags = res.reduce((acc, tag) => ({ ...acc, [tag.id]: tag.name }), tags);
        if (res.length == 100) {
            getTags(host, page + 1);
        } else {
            renderTags();
        }
    }
}

async function getAuthors(host, page = 1) {
    const res = await fetch(
        `https://${host}/wp-json/wp/v2/users?page=${page}&per_page=100`
    ).then((_) => _.json());
    if (res?.length) {
        authors = res.reduce((acc, u) => ({ ...acc, [u.id]: u.name }), authors);
        if (res.length == 100) {
            getAuthors(host, page + 1);
        } else {
            renderAuthors();
        }
    }
}

function renderPosts(p = 1) {
    $.ajax({
        url: "/admin/blog/post/import/view",
        method: "POST",
        data: {
            _token: token,
            host,
            page: p,
            search,
            username,
            password,
        },
        success: function (result) {
            console.log(result);
            if (result.data.success) {
                $(".result_area").append(result.data.view);
                renderCategories();
                renderTags();
                renderAuthors();
                checkAll();
                if (result.data.hasMore) {
                    page = page + 1;
                    renderPosts(page);
                } else {
                    $(".smtBtn").prop("disabled", false);
                }
            } else {
                $(".smtBtn").prop("disabled", false);
            }
        },
        error: function (e) {
            console.log(e);
            $(".smtBtn").prop("disabled", false);
            if (e?.responseJSON.data.error) {
                window.itoastr("error", e?.responseJSON.data.error);
            }
        },
    });
}

function renderCategories() {
    var blogCategories = document.querySelectorAll(".blog-category");
    blogCategories.forEach(function (category) {
        var id = category.getAttribute("data-id");

        category.innerHTML = categories[id];
        if (categories[id]) {
            category.classList.remove("blog-category");
        }
    });
}

function renderTags() {
    var blogTags = document.querySelectorAll(".blog-tag");
    blogTags.forEach(function (category) {
        var ids = category.getAttribute("data-ids").split(",");
        var blogTag = [];
        ids.forEach((id) => {
            if (tags[id]) blogTag.push(tags[id]);
        });
        category.innerHTML = blogTag.join(",");
        if (blogTag.length) {
            category.classList.remove("blog-tag");
        }
    });
}

function renderAuthors() {
    var blogAuthors = document.querySelectorAll(".blog-author");
    blogAuthors.forEach(function (author) {
        var id = author.getAttribute("data-id");

        author.innerHTML = authors[id];
        if (authors[id]) {
            author.classList.remove("blog-author");
        }
    });
}

$(document).on("change", "tbody input[type=checkbox]", function () {
    checkbox_count = $(".datatable tbody input[type=checkbox]:checked").length;
    if (checkbox_count > 0) {
        $(".import-btn").show();
    } else {
        $(".datatable thead input[type=checkbox]").prop("checked", false);
        $(".import-btn").hide();
    }
});

$(document).on("click", ".select-all", function () {
    checkAll();
});

function checkAll() {
    if ($(".select-all").prop("checked") === true) {
        $(".datatable tbody input[type=checkbox]").prop("checked", true);
        $(".import-btn").show();
    } else {
        $(".datatable tbody input[type=checkbox]").prop("checked", false);
        $(".import-btn").hide();
    }
}

$(".import-btn").on("click", async function () {
    const ids = $(".select-all").prop("checked") ? "all" : checkedIds();

    $.ajax({
        url: "/admin/blog/post/import",
        method: "POST",
        data: { _token: token, ids, host, search },
        success: function (result) {
            window.itoastr(
                "success",
                "Import process is being  done in background. Please check in a few minutes"
            );
            setTimeout(() => {
                location.href = "/admin/blog/post";
            }, 5000);
        },
        error: function (e) {
            console.log(e);
            $(this).prop("disabled", false);
        },
    });
});
