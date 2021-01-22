
var table1;

$(function () {
    hashUpdate(window.location.hash);
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
        url:"/account/blog",
        type:"get",
    };

    let columns=[
        { data: 'title', name: 'title'},
        { data: 'view_count', name: 'view_count'},
        { data: 'favoriters', name: 'favoriters'},
        { data: 'comments', name: 'comments'},
        { data: 'subscribers', name: 'subscribers'},
        { data: 'is_free', name: 'is_free' },
        { data: 'is_published', name: 'is_published' },
        { data: 'status', name: 'status' },
        { data: 'visible_date', name: 'visible_date' },
        { data: 'created_at', name: 'created_at' },
        { data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns, 9, false);
}
