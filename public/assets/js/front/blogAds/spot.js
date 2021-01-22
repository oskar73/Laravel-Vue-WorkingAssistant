
var price_obj = JSON.parse(g_price);
var total_price = 0;
var i=1;
var screen_width = $( window ).width();
var columns = 4;

if(screen_width > 1200)
{
    columns = 4;
}else if(screen_width > 768){
    columns = 3;
}else if(screen_width > 465) {
    columns = 2;
}else {
    columns = 1;
}

$(document).ready(function() {
    $('.lightgallery').lightGallery();
    updatePrice();
});


$("input[type=radio][name=price]").change(function() {
    price_obj = $("input[type=radio][name=price]:checked").data('price');
    updatePrice();
});
var calendar = $('#calendar').fullCalendar({
    header: {
        left: 'prev,next',
        center: 'title',
        right: 'year,month,agendaWeek'
    },
    timezone: 'America/New_York',
    height: "auto",
    selectable: false,
    defaultView: 'year',
    dayNamesShort: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
    yearColumns: columns,
    durationEditable: false,
    eventDurationEditable: false,
    bootstrap: false,
    events: blogads_spot,
    eventOverlap: false,
    dayClick: function(start) {
        var result = pickDate(start, price_obj.period);

        if(isInValidEvent(result[0],result[1])){
            itoastr('info', 'That period is already chosen. Please choose other period');
        }else {
            var today = moment().format('YYYY-MM-DD');
            if(result[0] >= today)
            {
                var event = {
                    id:i,
                    start: result[0] + " 00:00:00",
                    end: result[1] + " 24:00:00",
                    color:'#b3ffb3',
                    rendering: 'background',
                    allDay: true
                };

                calendar.fullCalendar('renderEvent', event, true);

                $("#dynamic_date_field").append('' +
                    '<tr id="row'+i+'" class="picked_row">' +
                    '<td><input type="text" class="jgjformshow text-right" name="start[]" id="start'+i+'" value="'+result[0]+'" readonly/></td>' +
                    '<td><input type="text" class="jgjformshow text-right" name="end[]" id="end'+i+'" value="'+result[1]+'" readonly/></td>' +
                    '<td><input type="text" class="jgjformshow text-right" name="priceval" id="price'+i+'" value="$'+parseFloat(price_obj.price).toFixed(2)+'" readonly/></td>' +
                    '<td><button type="button" data-id="'+i+'" data-price="'+price_obj.price+'" class="btn-danger btn btn-sm border-radius-none btn_remove">X</button></td>' +
                    '</tr>');

                addTotal();
                i++;
            }
            else {
                itoastr('info', 'Event start date should be after today.');
            }
        }
    },
});

function updatePrice()
{
    var type = price_obj.type;
    if(type==='period')
    {
        $(".calendar_area").removeClass("d-none");

        $(".btn_remove").each(function() {
            removeRow($(this));
        })

    }else {
        $(".calendar_area").addClass("d-none");
    }
}
function addTotal() {
    total_price = parseFloat(total_price) + parseFloat(price_obj.price);
    updateTotal();
}
function subTotal(price) {
    total_price = parseFloat(total_price) - parseFloat(price);
    updateTotal();
}
function updateTotal()
{
    $(".total_price").html(parseFloat(total_price).toFixed(2));
}
$(document).on('click', '.btn_remove', function(){

    removeRow($(this))
});
function removeRow(obj)
{
    var id = obj.data("id");
    var price = obj.data("price");
    $('#row'+id).remove();
    $("#calendar").fullCalendar('removeEvents', id);
    subTotal(price)
}
var isInValidEvent = function(start,end){

    var result = false;
    $("#calendar").fullCalendar('clientEvents', function (event) {
        var eventEnd = event.end.format('YYYY-MM-DD');
        var realEnd = moment(eventEnd).subtract(1, 'days').format('YYYY-MM-DD');
        if(event.rendering === "background" && start <= realEnd && end >= event.start.format('YYYY-MM-DD'))
        {
            result = true;
        }
    });
    return result;
};

$("#submitForm").on("submit", function(e) {
    e.preventDefault();
    var obj = $(".smtBtn");
    obj.html("<i class='fa fa-spin fa-spinner fa-2x'></i>").prop("disabled", true);

    $.ajax({
        url:$(this).attr("action"),
        method: 'POST',
        data: new FormData(this),
        dataType:'JSON',
        contentType:false,
        cache:false,
        processData:false,
        success: function(result)
        {
            obj.prop("disabled", false).html("Add to cart");

            if(result.status===0)
            {
                dispErrors(result.data);
                dispValidErrors(result.data);
            }else {
                itoastr('success', 'Successfully Added!');
                $("#header_area").html(result.data);
                obj.toggleClass("d-none");
                obj.next().toggleClass("d-none");
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });
});
