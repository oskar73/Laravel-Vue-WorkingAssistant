
var table1;

$(document).ready(function() {
    hashUpdate(window.location.hash);
    table1 = $('.datatable-all').DataTable(setParam("all"));
});
$(".product_item_area a").on("click", function() {
    $(".product_item_area a input").prop("checked", false);
    $(this).find("input").prop("checked", true);
});
function setParam(status)
{
    let ajax = {
        url:"/account/ecommerce",
        type:"get",
        data: {status:status},
    };

    let columns=[
        { data: 'order', name: 'order' },
        { data: 'itemName', name: 'itemName' },
        { data: 'quantity', name: 'quantity' },
        { data: 'payment', name: 'payment' },
        { data: 'status', name: 'status' },
        { data: 'created_at', name: 'created_at' },
        { data: 'due_date', name: 'due_date' },
        { data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns, 5, false);
}

$('.datatable-all').on('draw.dt', function() {
    $(".all_count").html(table1.ajax.json().recordsTotal)
});
