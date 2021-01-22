var $from_date = $("#from_date");
var $to_date = $("#to_date");
var $count = 0;
var edit_id;
var calendar =$('#calendar');

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
    selectable: true,
    dayNamesShort: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
    durationEditable: false,
    eventDurationEditable: false,
    bootstrap: false,
    events: `/admin/appointment/unavailable-dates/${type}/${id}`,
    eventRender: function(eventObj, $el) {
        $el.popover({
            title:eventObj.title,
            content: eventObj.reason?? 'No reason',
            trigger: 'hover',
            placement: 'right',
            container: 'body'
        });
        renderTable(eventObj);

    },
    eventOverlap: false,
    select:function(start, end) {
        var startDate = start.format("YYYY-MM-DD");
        var today = moment().format("YYYY-MM-DD");
        var endDate = moment(end).add(-1, 'days').format("YYYY-MM-DD");
        if(startDate >= today)
        {
            modalClearToggle(startDate, endDate);

        }else {
            itoastr('error', 'Please select future dates.');
        }
    },
    eventClick: function(e) {
        editEvent(e.date);
    },
    viewRender:function(view,element)
    {
        resetTableBody();
    }
});
$('#create_modal_btn').click(function() {
    modalClearToggle();
});
function resetTableBody()
{
    $(".table_body").html("");
}

function renderTable(eventObj)
{
    $(".table_body").append(`
        <tr>
            <td>${eventObj.date}</td>
            <td><span class="badge badge-warning">${eventObj.start_time} - ${eventObj.end_time}</span></td>
            <td>${eventObj.reason?? 'No reason'}</td>
            <td>
                <a href="javascript:void(0)" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill tooltip_3 edit_btn" title="Edit" data-date="${eventObj.date}">
                   <i class="la la-edit"></i>
                </a>
                <a href="javascript:void(0)" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill tooltip_3 switchOne del_btn" title="Delete" data-id="${eventObj.id}">
                    <i class="la la-remove"></i>
                </a>
            </td>
        </tr>
    `);
}
$(document).on("click", ".edit_btn", function() {
    editEvent($(this).data("date"));
})
$(document).on("click", ".tab-link", function() {
    calendar.fullCalendar('render');
})
$(document).on("click", ".del_btn", function() {
    edit_id = $(this).data("id");
    askToast.question('Confirm', "Are you sure?", 'deleteAction');
})
function editEvent(date)
{
    $.ajax({
        url:`/admin/appointment/unavailable-dates/edit/${type}/${id}`,
        data:{date:date},
        success:function(result)
        {
            console.log(result)
            if(result.status===1)
            {
                edit_id = result.data.id;
                modalClearToggle(result.data.date, result.data.date, result.data.whole_date, result.data.start, result.data.end, result.data.reason);
                $from_date.datepicker('destroy').prop('readonly',true);
                $to_date.datepicker('destroy').prop('readonly',true);
                $(".deleteBtn").css('display', 'block');
            }
        },
        error:function(e)
        {
            console.log(e);
        }
    })
}
$(document).on("click", ".deleteBtn", function() {
    askToast.question('Confirm', "Are you sure?", 'deleteAction');
})
function deleteAction()
{
    $.ajax({
        url:`/admin/appointment/unavailable-dates/delete/${type}/${id}`,
        method: 'POST',
        data:{_token:token, id:edit_id},
        success: function(result)
        {
            $(".smtBtn").prop("disabled", false).html("Submit");

            if(result.status===0)
            {
                dispErrors(result.data);
                dispValidErrors(result.data);
            }else {
                itoastr('success', 'Successfully deleted!');

                $('#blockDate_modal').modal('hide');
                resetTableBody();
                calendar.fullCalendar('refetchEvents');
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });
}
$(".add_time_btn").click(function(){
    $("#block_table").append('<tr id="row_'+$count+'"><td><input class="form-control timepicker start_time_area" name="start_time[]" placeholder="start" readonly type="text" value="7:00"/></td><td><input class="form-control timepicker end_time_area" placeholder="end" name="end_time[]" readonly type="text" value="18:00"/></td><td><a href="javascript:void(0);" data-id="row_'+$count+'" class="btn m-btn--square  btn-danger btn-sm p-1 btn_remove">X</a></td></tr>');
    $count++;
    $(".timepicker").timepicker({
        minuteStep: 30,
        showMeridian: !1,
    });
});
function modalClearToggle(from_date=null, to_date=null, whole_date=1, start_time=[], end_time=[], reason=null)
{
    $("#block_table").html("");
    if(whole_date===1)
    {
        $("#specific_time").prop('checked', false);
        $(".block_time").css('display', 'none');
    }else {
        $("#specific_time").prop('checked', true);
        $(".block_time").css('display', 'block');
        $.each(JSON.parse(start_time), function(index, value) {
            $("#block_table").append('<tr id="rowe_'+index+'"><td><input class="form-control timepicker start_time_area" name="start_time[]" placeholder="start" readonly type="text" value="'+value+'"/></td><td><input class="form-control timepicker end_time_area" placeholder="end" name="end_time[]" readonly type="text" value="'+JSON.parse(end_time)[index]+'"/></td><td><a href="javascript:void(0);" data-id="rowe_'+index+'" class="btn m-btn--square  btn-danger btn-sm p-1 btn_remove">X</a></td></tr>');
        });
    }
    $(".deleteBtn").css('display', 'none');
    $from_date.val(from_date);
    $to_date.val(to_date);
    $("#reason").val(reason);
    $from_date.datepicker({
        format: 'yyyy-mm-dd',
        startDate: '0d',
        todayHighlight: !0,
        defaultDate:from_date,
        autoclose: !0,
    });
    $to_date.datepicker({
        format: 'yyyy-mm-dd',
        startDate: '0d',
        todayHighlight: !0,
        defaultDate:to_date,
        autoclose: !0,
    });
    $('#blockDate_modal').modal('toggle');
}
$(document).on('click', '.btn_remove', function(){
    var button_id = $(this).data("id");
    $('#'+button_id+'').remove();
});
$(document).on('change', '#specific_time', function() {
    if($("#specific_time").prop('checked')===true)
    {
        $(".block_time").css('display', 'block');

    }else {
        $(".block_time").css('display', 'none');
    }
});
$("#blockDateForm").on("submit", function(e) {
    e.preventDefault();
    $(".smtBtn").html("<i class='fa fa-spin fa-spinner fa-2x'></i>").prop("disabled", true);

    $.ajax({
        url:`/admin/appointment/unavailable-dates/${type}/${id}`,
        method: 'POST',
        data: new FormData(this),
        dataType:'JSON',
        contentType:false,
        cache:false,
        processData:false,
        success: function(result)
        {
            $(".smtBtn").prop("disabled", false).html("Submit");

            if(result.status===0)
            {
                dispErrors(result.data);
                dispValidErrors(result.data);
            }else {
                itoastr('success', 'Success!');

                $('#blockDate_modal').modal('hide');
                resetTableBody();
                calendar.fullCalendar('refetchEvents');
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });
});
