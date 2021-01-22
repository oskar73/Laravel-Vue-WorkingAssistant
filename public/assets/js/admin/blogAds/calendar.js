$(function () {
    $(".select2").select2();
});
var columns = 4;
var screen_width = $( window ).width();

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
var calendar = $('#calendar').fullCalendar({
    header: {
        left: 'prev,next',
        center: 'title',
        right: 'year,month,basicWeek'
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
    events: '/admin/blogAds/calendar/events',
    eventOverlap: false,
});
