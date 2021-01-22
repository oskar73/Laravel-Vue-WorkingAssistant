
var table1;

$(function () {
    table1 = $('.datatable-all').DataTable(setParam());
});

function setParam()
{
    let ajax = {
        url:"/account/purchase/order",
        type:"get",
    };

    let columns=[
        { data: 'id', name: 'id' },
        { data: 'gateway', name: 'gateway' },
        { data: 'price', name: 'price' },
        { data: 'total_qty', name: 'total_qty' },
        { data: 'created_at', name: 'created_at' },
        { data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns, 4, false);
}

$('.datatable-all').on('draw.dt', function() {
    $(".all_count").html(table1.ajax.json().recordsTotal)
});
