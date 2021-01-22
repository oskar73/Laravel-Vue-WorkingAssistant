
var table1, table2, table3;

$(document).ready(function() {
   hashUpdate(window.location.hash);
    table1 = $('.datatable-all').DataTable(setParam("all"));
    table2 = $('.datatable-active').DataTable(setParam("active"));
    table3 = $('.datatable-inactive').DataTable(setParam("inactive"));
});
$(".product_item_area a").on("click", function() {
    $(".product_item_area a input").prop("checked", false);
    $(this).find("input").prop("checked", true);
});
function setParam(status)
{
    let ajax = {
        url:"/admin/purchase/blog",
        type:"get",
        data: {status:status},
    };

    let columns=[
        { data: 'user', name: 'user' },
        { data: 'order', name: 'order' },
        { data: 'itemName', name: 'itemName' },
        { data: 'payment', name: 'payment' },
        { data: 'post_number', name: 'post_number' },
        { data: 'status', name: 'status' },
        { data: 'created_at', name: 'created_at' },
        { data: 'due_date', name: 'due_date' },
        { data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns, 6, false);
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
