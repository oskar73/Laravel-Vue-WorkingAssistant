
var table1;

$(function () {
    table1 = $('.datatable-all').DataTable(setParam('all'));
});
$('.datatable-all').on('draw.dt', function() {
    $(".all_count").html(table1.ajax.json().recordsTotal)
});
function setParam(status)
{
    let ajax = {
        url:"/admin/blog/author",
        type:"get",
        data:{status:status}
    };

    let columns=[
        { data: 'name', name: 'name'},
        { data: 'posts_count', name: 'posts_count', orderable: false, searchable: false },
        { data: 'claps', name: 'claps', orderable: false, searchable: false },
        { data: 'followers_count', name: 'followers_count', orderable: false, searchable: false },
        { data: 'created_at', name: 'created_at' },
        { data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns, 4, false);
}
