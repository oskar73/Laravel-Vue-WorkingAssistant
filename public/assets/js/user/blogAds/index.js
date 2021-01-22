
var table1;

$(function () {
    hashUpdate(window.location.hash);
    $(".select_picker").selectpicker();
    table1 = $('.datatable-all').DataTable(setParam());
});
$('.datatable-all').on('draw.dt', function() {
    $(".all_count").html(table1.ajax.json().recordsTotal)
});
function modalClearToggle()
{
    $(".notify_area").hide();
    $("#item_id").val(null);
    $('#item_modal').modal('toggle');
}

function setParam()
{
    let ajax = {
        url:"/account/blogAds",
        type:"get",
    };

    let columns=[
        { data: 'spot', name: 'spot'},
        { data: 'page', name: 'page'},
        { data: 'price', name: 'price' },
        { data: 'status', name: 'status' },
        { data: 'created_at', name: 'created_at' },
        { data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns, 4, false);
}
