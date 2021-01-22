
var table1, table2, table3, table4;

$(function () {
    hashUpdate(window.location.hash);
    table1 = $('.datatable-all').DataTable(setParam("all"));
});

function setParam(status)
{
    let ajax = {
        url:"/account/purchase/transaction",
        type:"get",
        data: {status:status},
    };

    let columns=[
        { data: 'gateway', name: 'gateway' },
        { data: 'amount', name: 'amount' },
        { data: 'invoice', name: 'invoice' },
        { data: 'created_at', name: 'created_at' },
        { data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns, 3, false);
}

$('.datatable-all').on('draw.dt', function() {
    $(".all_count").html(table1.ajax.json().recordsTotal)
});
