
var table1, table2, table3;

$(function () {
    hashUpdate(window.location.hash);
    table1 = $('.datatable-all').DataTable(setParam("all"));
    table2 = $('.datatable-active').DataTable(setParam("active"));
    table3 = $('.datatable-inactive').DataTable(setParam("inactive"));
});

function setParam(status)
{
    let ajax = {
        url:"/admin/purchase/subscription",
        type:"get",
        data: {status:status},
    };

    let columns=[
        { data: 'user', name: 'user' },
        { data: 'product_type', name: 'product_type' },
        { data: 'product_name', name: 'product_name' },
        { data: 'price_detail', name: 'price_detail' },
        { data: 'order_id', name: 'order_id' },
        { data: 'status', name: 'status' },
        { data: 'due_date', name: 'due_date' },
        { data: 'created_at', name: 'created_at' },
        { data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns, 7, false);
}

$('.datatable-all').on('draw.dt', function() {
    $(".all_count").html(table1.ajax.json().recordsTotal)
});
$('.datatable-active').on('draw.dt', function() {
    $(".active_count").html(table2.ajax.json().recordsTotal)
});
$('.datatable-inactive').on('draw.dt', function() {
    $(".inactive_count").html(table3.ajax.json().recordsTotal)
});
