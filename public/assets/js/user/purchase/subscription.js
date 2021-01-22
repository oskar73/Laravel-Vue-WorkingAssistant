
var table1;

$(function () {
    hashUpdate(window.location.hash);
    table1 = $('.datatable-all').DataTable(setParam("all"));
});

function setParam(status)
{
    let ajax = {
        url:"/account/purchase/subscription",
        type:"get",
        data: {status:status},
    };

    let columns=[
        { data: 'product_type', name: 'product_type' },
        { data: 'product_name', name: 'product_name' },
        { data: 'price_detail', name: 'price_detail' },
        { data: 'order_id', name: 'order_id' },
        { data: 'status', name: 'status' },
        { data: 'due_date', name: 'due_date' },
        { data: 'created_at', name: 'created_at' },
        { data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns, 6, false);
}

$('.datatable-all').on('draw.dt', function() {
    $(".all_count").html(table1.ajax.json().recordsTotal)
});
