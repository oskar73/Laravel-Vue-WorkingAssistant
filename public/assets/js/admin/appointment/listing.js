
var checkbox_count = 0;
var switch_action;
var alone=0;
var selected;
var calendar =$('#calendar');
var appointmentTable;

$(function () {
    hashUpdate(window.location.hash);
    appointmentTable = $('#all_area .datatable-all').DataTable(appointmentSetParam("all"));
});
calendar.fullCalendar({
    header: {
        left: 'prev,next',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
    },
    timezone: 'America/New_York',
    slotLabelFormat:"HH:mm",
    height: "auto",
    defaultView: 'month',
    selectable: false,
    dayNamesShort: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
    durationEditable: false,
    eventDurationEditable: false,
    bootstrap: false,
    events: "/admin/appointment/listing",
    eventRender: function(eventObj, $el) {
        $el.popover({
            title:eventObj.title,
            content: eventObj.status,
            trigger: 'hover',
            placement: 'right',
            container: 'body'
        });
        renderTable(eventObj);
    },
    eventOverlap: false,
    eventClick: function(e) {
        window.location.href=`/admin/appointment/listing/detail/${e.id}`
    },
    viewRender:function()
    {
        resetTableBody();
    }
});

function appointmentSetParam(status)
{
    let ajax = {
        url:"/admin/appointment/listing/getData",
        type:"get",
        data: {status:status, user:"all"},
    };

    let columns=[
        { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
        { data: 'user', name: 'user' },
        { data: 'date', name: 'date' },
        { data: 'time', name: 'time' },
        { data: 'status', name: 'status' },
        { data: 'product', name: 'product' },
        { data: 'action', name: 'action', orderable: false},
    ];

    return setTbl(ajax, columns, 2, false);
}

$('.datatable-all').on('draw.dt', function() {
    $(".all_count").html(appointmentTable.ajax.json().recordsTotal)
});

function renderTable(eventObj)
{
    var color;
    if(eventObj.status==='Approved')
    {
        color = "c-badge-success";
    }else if(eventObj.status==='Pending')
    {
        color = "c-badge-info";
    }else if(eventObj.status==='Canceled')
    {
        color = "c-badge-danger";
    }else {
        color = "c-badge-warning";
    }
    $(".table_body").append(`
        <tr>
            <td><input type="checkbox" class="checkbox" data-id="${eventObj.id}"></td>
            <td>${eventObj.user}</td>
            <td>${eventObj.date}</td>
            <td><span class="c-badge c-badge-warning">${eventObj.start_time} - ${eventObj.end_time}</span></td>
            <td><span class="c-badge ${color}">${eventObj.status}</span></td>
            <td>${eventObj.product}</td>
            <td>
                <a href="/admin/appointment/listing/detail/${eventObj.id}"
                class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill tooltip_3"
                title="Detail">
                   <i class="la la-eye"></i>
                </a>
                <a href="/admin/appointment/listing/edit/${eventObj.id}"
                class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill tooltip_3"
                title="Edit">
                   <i class="la la-edit"></i>
                </a>
                <a href="javascript:void(0);"
                class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill tooltip_3 switchOne"
                data-action="delete"
                title="Delete">
                   <i class="la la-remove"></i>
                </a>
            </td>
        </tr>
    `);
}
function resetTableBody()
{
    $(".table_body").html("");
}
$(document).on("change", "input[type=checkbox]", function() {
    checkbox_count = $(".datatable tbody input[type=checkbox]:checked").length;
    if(checkbox_count>0)
    {
        $(".show_checked").removeClass("d-none");
    }else {
        $(".show_checked").addClass("d-none");
        $(".datatable thead input[type=checkbox]").prop("checked", false);
    }
});

$(document).on("click", '.switchBtn', function() {
    switch_action = $(this).data("action");
    var item = checkbox_count+" items";
    alone = 0;
    switchAlert(item);
});
$(document).on("click", '.switchOne', function() {
    switch_action = $(this).data("action");
    alone = 1;
    selected = $(this).parent().parent().find(".checkbox").data("id");
    switchAlert('this item');
});
function switchAlert(item) {
    var msg;
    switch(switch_action) {
        case 'approve':
            msg = 'Do you want to approve '+item+'?';
            break;
        case 'cancel':
            msg = 'Do you want to cancel '+item+'?';
            break;
        case 'delete':
            msg = 'Do you want to delete '+item+'?';
            break;
    }
    askToast.question('Confirm', msg, 'switchAction');
}

function switchAction()
{
    $.ajax({
        url:"/admin/appointment/listing/switch",
        data:{ids:checkedIds(), action:switch_action},
        method:"get",
        success:function(result) {
            console.log(result)
            if(result.status===0)
            {
                dispErrors(result.data)
            }else {
                itoastr("success", 'Successfully updated');
                resetTableBody();
                $(".show_checked").addClass("d-none");
                calendar.fullCalendar('refetchEvents');
            }
        },
        error:function(e) {
            console.log(e);
        }
    })
}
