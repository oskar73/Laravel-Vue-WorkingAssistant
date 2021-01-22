
var table1;

$(function () {
    hashUpdate(window.location.hash);
    table1 = $('.datatable-all').DataTable(setParam());
});

function setParam()
{
    let ajax = {
        url:"/account/purchase/form",
        type:"get",
    };

    let columns=[
        { data: 'model_type', name: 'model_type', orderable: false, searchable: false},
        { data: 'model_name', name: 'model_name', orderable: false, searchable: false},
        { data: 'title', name: 'title' },
        { data: 'description', name: 'description' },
        { data: 'status', name: 'status' },
        { data: 'created_at', name: 'created_at' },
        { data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns, 5, false);
}

$('.datatable-all').on('draw.dt', function() {
    $(".all_count").html(table1.ajax.json().recordsTotal)
});
