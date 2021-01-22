
var table1, table2, table3, table4;

$(function () {
    hashUpdate(window.location.hash);
    table1 = $('.datatable-all').DataTable(setParam("all"));
    table2 = $('.datatable-onetime').DataTable(setParam("onetime"));
    table3 = $('.datatable-recurrent').DataTable(setParam("recurrent"));
    table4 = $('.datatable-refunded').DataTable(setParam("refunded"));
});

function setParam(status)
{
    let ajax = {
        url:"/admin/purchase/transaction",
        type:"get",
        data: {status:status},
    };

    let columns=[
        { data: 'user', name: 'user' },
        { data: 'gateway', name: 'gateway' },
        { data: 'amount', name: 'amount' },
        { data: 'invoice', name: 'invoice' },
        { data: 'created_at', name: 'created_at' },
        { data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns, 4, false);
}

$('.datatable-all').on('draw.dt', function() {
    $(".all_count").html(table1.ajax.json().recordsTotal)
});
$('.datatable-onetime').on('draw.dt', function() {
    $(".onetime_count").html(table2.ajax.json().recordsTotal)
});
$('.datatable-recurrent').on('draw.dt', function() {
    $(".recurrent_count").html(table3.ajax.json().recordsTotal)
});
$('.datatable-refunded').on('draw.dt', function() {
    $(".refunded_count").html(table4.ajax.json().recordsTotal)
});
