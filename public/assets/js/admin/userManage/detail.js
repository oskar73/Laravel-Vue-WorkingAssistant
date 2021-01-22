var websiteTable, domainTable, readyMadeTable, packageTable, pluginTable, serviceTable, lacarteTable, blogTable, blogAdsTable;

$(function () {
    hashUpdate(window.location.hash);
    $(".selectpicker").selectpicker();
    $(".select2").select2({
        'width':'100%'
    });
    $(".front-dt").DataTable();
    websiteTable = $('#website_area .datatable-all').DataTable(websiteSetParam("all"));
    domainTable = $('#domain_area .datatable-all').DataTable(domainSetParam("all"));
    readyMadeTable = $('#readyMadeBiz_area .datatable-all').DataTable(readyMadeSetParam("all"));
    packageTable = $('#package_area .datatable-all').DataTable(packageSetParam("all"));
    pluginTable = $('#plugin_area .datatable-all').DataTable(pluginSetParam("all"));
    serviceTable = $('#service_area .datatable-all').DataTable(serviceSetParam("all"));
    lacarteTable = $('#lacarte_area .datatable-all').DataTable(lacarteSetParam("all"));
    blogTable = $('#blog_area .datatable-all').DataTable(blogSetParam("all"));
    blogAdsTable = $('#blogAds_area .datatable-all').DataTable(blogAdsSetParam("all"));
});
function websiteSetParam(status)
{
    let ajax = {
        url:"/admin/website/list",
        type:"get",
        data:{status:status, user:user_id},
    };

    let columns=[
        { data: 'name', name: 'name' },
        { data: 'domain', name: 'domain' },
        { data: 'status', name: 'status' },
        { data: 'storage', name: 'storage', orderable: false, searchable: false },
        { data: 'created_at', name: 'created_at' },
        { data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns, 4, false);
}
function domainSetParam(status)
{
    let ajax = {
        url:"/admin/domainList",
        type:"get",
        data:{status:status, user:user_id}
    };

    let columns=[
        { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
        { data: 'domainID', name: 'domainID' },
        { data: 'name', name: 'name' },
        { data: 'orderID', name: 'orderID' },
        { data: 'transactionID', name: 'transactionID' },
        { data: 'pointed', name: 'pointed' },
        { data: 'chargedAmountNC', name: 'chargedAmountNC' },
        { data: 'chargedAmountBB', name: 'chargedAmountBB' },
        { data: 'created_at', name: 'created_at' },
        { data: 'expired_at', name: 'expired_at' },
        { data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns, 8, false);
}
function readyMadeSetParam(status)
{
    let ajax = {
        url:"/admin/purchase/readymade",
        type:"get",
        data: {status:status, user:user_id},
    };

    let columns=[
        { data: 'order', name: 'order' },
        { data: 'itemName', name: 'itemName' },
        { data: 'payment', name: 'payment' },
        { data: 'status', name: 'status' },
        { data: 'created_at', name: 'created_at' },
        { data: 'due_date', name: 'due_date' },
        { data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns, 4, false);
}
function packageSetParam(status)
{
    let ajax = {
        url:"/admin/purchase/package",
        type:"get",
        data: {status:status, user:user_id},
    };

    let columns=[
        { data: 'order', name: 'order' },
        { data: 'itemName', name: 'itemName' },
        { data: 'payment', name: 'payment' },
        { data: 'status', name: 'status' },
        { data: 'created_at', name: 'created_at' },
        { data: 'due_date', name: 'due_date' },
        { data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns, 4, false);
}

function pluginSetParam(status)
{
    let ajax = {
        url:"/admin/purchase/plugin",
        type:"get",
        data: {status:status, user:user_id},
    };

    let columns=[
        { data: 'order', name: 'order' },
        { data: 'itemName', name: 'itemName' },
        { data: 'status', name: 'status' },
        { data: 'created_at', name: 'created_at' },
        { data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns, 4, false);
}

function serviceSetParam(status)
{
    let ajax = {
        url:"/admin/purchase/service",
        type:"get",
        data: {status:status, user:user_id},
    };

    let columns=[
        { data: 'order', name: 'order' },
        { data: 'itemName', name: 'itemName' },
        { data: 'status', name: 'status' },
        { data: 'created_at', name: 'created_at' },
        { data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns, 4, false);
}

function lacarteSetParam(status)
{
    let ajax = {
        url:"/admin/purchase/lacarte",
        type:"get",
        data: {status:status, user:user_id},
    };

    let columns=[
        { data: 'order', name: 'order' },
        { data: 'itemName', name: 'itemName' },
        { data: 'status', name: 'status' },
        { data: 'created_at', name: 'created_at' },
        { data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns, 4, false);
}
function blogSetParam(status)
{
    let ajax = {
        url:"/admin/blog/post",
        type:"get",
        data:{status:status, user:user_id}
    };

    let columns=[
        { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
        { data: 'category', name: 'category'},
        { data: 'title', name: 'title'},
        { data: 'view_count', name: 'view_count'},
        { data: 'favoriters', name: 'favoriters'},
        { data: 'comments', name: 'comments'},
        { data: 'subscribers', name: 'subscribers'},
        { data: 'is_free', name: 'is_free' },
        { data: 'featured', name: 'featured' },
        { data: 'is_published', name: 'is_published' },
        { data: 'status', name: 'status' },
        { data: 'visible_date', name: 'visible_date' },
        { data: 'created_at', name: 'created_at' },
        { data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns, 12, false);
}
function blogAdsSetParam(status)
{
    let ajax = {
        url:"/admin/blogAds/listing",
        type:"get",
        data:{status:status, user:user_id}
    };

    let columns=[
        { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
        { data: 'spot', name: 'spot'},
        { data: 'page', name: 'page'},
        { data: 'price', name: 'price' },
        { data: 'status', name: 'status' },
        { data: 'created_at', name: 'created_at' },
        { data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns, 5, false);
}
