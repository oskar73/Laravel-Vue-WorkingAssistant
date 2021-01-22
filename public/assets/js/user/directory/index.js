
var switch_action;
var checkbox_count;
var table1;
var alone=0;
var selected;

$(function () {
    $(".select_picker").selectpicker();
    table1 = $('.datatable-all').DataTable(setParam());
});
$('.datatable-all').on('draw.dt', function() {
    $(".all_count").html(table1.ajax.json().recordsTotal)
});

function setParam()
{
    let ajax = {
        url:"/account/directory",
        type:"get",
    };

    let columns=[
        { data: 'category', name: 'category'},
        { data: 'title', name: 'title'},
        { data: 'purchased', name: 'purchased' },
        { data: 'property', name: 'property' },
        { data: 'view_count', name: 'view_count' },
        { data: 'featured', name: 'featured' },
        { data: 'status', name: 'status' },
        { data: 'expired_at', name: 'expired_at' },
        { data: 'created_at', name: 'created_at' },
        { data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns, 8, false);
}
