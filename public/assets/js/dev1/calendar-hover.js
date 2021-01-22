$(document).ready(function() {
    $( document ).on( "mouseover", "td.fc-day-top", function() {
        OperateClasses($(this), "add");  // jQuery 1.7+
    });
    $( document ).on( "mouseleave", "td.fc-day-top", function() {
        OperateClasses($(this), "remove");  // jQuery 1.7+
    });
    $( document ).on( "mouseover", "td.fc-day", function() {
        OperateClasses($(this), "add");  // jQuery 1.7+
    });
    $( document ).on( "mouseleave", "td.fc-day", function() {
        OperateClasses($(this), "remove");  // jQuery 1.7+
    });
    function OperateClasses(obj, opr)
    {
        var neObj;
        var objDate;
        var todaydate = new Date();

        if (obj.data('date') != undefined)
            objDate = getDate(obj);
        else
            objDate = undefined;

        if (price_obj.period == 1)//1 day
        {
            if (objDate > todaydate)
                operateClassFuction(obj, opr);
        }
        else if (price_obj.period == 7)//1 weeks
        {
            var weekObj = obj.closest("tr").find(".fc-sun");
            var MonthObj = obj.closest(".fc-month-view");

            var neWeekobj;
            var neObj;
            neWeekobj = MonthObj.find(".fc-row");
            neObj= neWeekobj.find(".fc-day").first();

            var firstDate, CurrentDate;
            var offset_day;
            if (neObj.data('date') == undefined)
            {
                var oft_day = obj.closest(".fc-year-view").find(".fc-month-view").find(".fc-disabled-day").length;

                if (obj.data('date') != undefined)
                {
                    CurrentDate = getDate(obj);
                    firstDate = new Date(CurrentDate.getFullYear(), 0, 1);
                    var temp = (CurrentDate - firstDate) / 60 / 60 / 24 / 1000;
                    temp += oft_day;
                    temp -= temp % 7;
                    offset_day =  temp / 7;
                }
                else
                {
                    // console.log("undefined date - Obj");
                    offset_day = 0;
                }
            }
            else
            {
                firstDate = getDate(neObj);
                CurrentDate = getDate(obj);
                var temp = (CurrentDate - firstDate) / 60 / 60 / 24 / 1000;
                temp -= temp % 7;
                offset_day =  temp / 7;
            }

            // compare limit with today
            var start_ = CurrentDate;
            var end_ = CurrentDate;
            start_.setDate(start_.getDate() - (CurrentDate - firstDate) / 60 / 60 / 24 / 1000 % 7);
            end_ = start_;
            end_.setDate(end_.getDate() + 6);

            if (start_ <= todaydate)
            {
                return;
            }
            if (end_ <= todaydate)
            {
                return;
            }

            // end compare

            for (var i=0 ; i<offset_day ; i++)
            {
                neWeekobj = neWeekobj.next(".fc-row");
            }

            neObj= neWeekobj.find(".fc-day").first();

            for (var i=0 ; i<8 ; i++)
            {
                operateClassFuction(neObj, opr);

                if (i % 7 == 0 && i > 0)
                {
                    neObj = neWeekobj.next(".fc-row").find(".fc-day").first();
                }
                else
                {
                    neObj = neObj.next(".fc-day");
                }
            }
        }
        else if (price_obj.period == 14)//2 weeks
        {
            var weekObj = obj.closest("tr").find(".fc-sun");
            var MonthObj = obj.closest(".fc-month-view");
            //MonthObj = MonthObj.next(".fc-month-view");
            var neWeekobj;
            var neObj;
            neWeekobj = MonthObj.find(".fc-row");
            neObj= neWeekobj.find(".fc-day").first();

            var oft_day = obj.closest(".fc-year-view").find(".fc-month-view").find(".fc-disabled-day").length;

            var firstDate, CurrentDate;
            var offset_day;
            if (neObj.data('date') == undefined)
            {
                if (obj.data('date') != undefined)
                {
                    CurrentDate = getDate(obj);
                    firstDate = new Date(CurrentDate.getFullYear(), 0, 1);
                    var temp = (CurrentDate - firstDate) / 60 / 60 / 24 / 1000;
                    temp += oft_day;
                    temp -= temp % 7;
                    offset_day =  temp / 7;
                }
                else
                {
                    //console.log("undefined date - Obj");
                    offset_day = 0;
                }
            }
            else
            {
                firstDate = getDate(neObj);
                CurrentDate = getDate(obj);
                var temp = (CurrentDate - firstDate) / 60 / 60 / 24 / 1000;
                temp -= temp % 7;
                offset_day =  temp / 7;
            }
            // week pairing
            var new_year_day = new Date(CurrentDate.getFullYear(), 0, 1);
            var day = CurrentDate - new_year_day;
            day = day / 60 / 60 / 24 / 1000 ;
            day += oft_day;
            day -= day % 7;
            day /= 7;

            // compare limit with today
            var start_ = CurrentDate;
            start_.setDate(start_.getDate() - (CurrentDate - firstDate) / 60 / 60 / 24 / 1000 % 7);
            if (day % 2 == 1)
            {
                if (start_.getDate() > 7)
                    start_.setDate(start_.getDate() - 7);
            }

            if (start_ <= todaydate)
            {
                return;
            }
            start_.setDate(start_.getDate() + 13);

            if (start_ <= todaydate)
            {
                return;
            }

            // console.log("week offset is ... " + offset_day);
            for (var i=0 ; i<offset_day ; i++)
            {
                neWeekobj = neWeekobj.next(".fc-row");
            }

            var limit = 15;
            if (day % 2 == 1)
            {
                if (offset_day == 0)
                    limit = 8;

                neWeekobj = neWeekobj.prev(".fc-row");
                // console.log("to previous..." + neWeekobj.length);
                if (neWeekobj.length <= 0)
                {
                    // console.log("previous none...");
                    MonthObj = MonthObj.prev().prev(".fc-month-view");
                    neWeekobj = MonthObj.find(".fc-row").last();
                }
            }
            //console.log("Before week count - " + day/7);
            // end pairing

            neObj= neWeekobj.find(".fc-day").first();

            for (var i=0 ; i<limit ; i++)
            {
                operateClassFuction(neObj, opr);

                if (i % 7 == 0 && i > 0)
                {
                    neWeekobj = neWeekobj.next(".fc-row");
                    if (neWeekobj.length <= 0)
                    {
                        MonthObj = MonthObj.next().next(".fc-month-view");
                        if (MonthObj.length <= 0)
                        {
                            //console.log("another line...");
                            //MonthObj = MonthObj.parent().next().find(".fc-month-view").first();
                        }
                        neWeekobj = MonthObj.find(".fc-row");
                    }
                    neObj = neWeekobj.find(".fc-day").first();
                }
                else
                {
                    neObj = neObj.next(".fc-day");
                }
            }
        }
        else if (price_obj.period == 30)//month
        {
            var MonthObj = obj.closest(".fc-month-view");
            if (objDate.getFullYear() < todaydate.getFullYear())
                return;
            if (objDate.getFullYear() == todaydate.getFullYear() && objDate.getMonth() <= todaydate.getMonth())
                return;
            for (var i=1 ; i < 32 ; i++)
            {//MonthObj.find
                neObj = $('td[data-date=' + getDateString(objDate.getFullYear(), objDate.getMonth(), i) + ']');
                operateClassFuction(neObj, opr);
            }
        }
        else if (price_obj.period == 90)//month
        {
            var MonthObj = obj.closest(".fc-month-view");
            if (objDate.getFullYear() < todaydate.getFullYear())
                return;
            var jgj_mon = objDate.getMonth();
            var jgj_start;
            var jgj_end;

            if(jgj_mon<3)
            {
                jgj_start = 0;
                jgj_end = 3;
            }else if(jgj_mon<6)
            {
                jgj_start = 3;
                jgj_end = 6;
            }else if(jgj_mon<9)
            {
                jgj_start = 6;
                jgj_end = 9;
            }else{
                jgj_start = 9;
                jgj_end = 12;
            }
            for(var k=jgj_start; k<jgj_end; k++)
            {
                for (var i=1 ; i < 32 ; i++)
                {//MonthObj.find
                    neObj = $('td[data-date=' + getDateString(objDate.getFullYear(), k, i) + ']');
                    operateClassFuction(neObj, opr);
                }
            }
        }
        else if (price_obj.period == 180)//month
        {
            var MonthObj = obj.closest(".fc-month-view");
            if (objDate.getFullYear() < todaydate.getFullYear())
                return;
            var jgj_mon = objDate.getMonth();
            var jgj_start;
            var jgj_end;


            if(jgj_mon<6)
            {
                jgj_start = 0;
                jgj_end = 6;
            }else {
                jgj_start = 6;
                jgj_end = 12;
            }

            for(var k=jgj_start; k<jgj_end; k++)
            {
                for (var i=1 ; i < 32 ; i++)
                {//MonthObj.find
                    neObj = $('td[data-date=' + getDateString(objDate.getFullYear(), k, i) + ']');
                    operateClassFuction(neObj, opr);
                }
            }
        }
        else if (price_obj.period == 365)//month
        {
            var MonthObj = obj.closest(".fc-month-view");
            if (objDate.getFullYear() <= todaydate.getFullYear())
                return;
            for(var k=0; k<13; k++)
            {
                for (var i=1 ; i < 32 ; i++)
                {//MonthObj.find
                    neObj = $('td[data-date=' + getDateString(objDate.getFullYear(), k, i) + ']');
                    operateClassFuction(neObj, opr);
                }
            }
        }
    }
    function operateClassFuction(neObj, opr)
    {
        if (neObj)
        {
            if (opr == "add")
                neObj.addClass('fc-highlight');
            else
                neObj.removeClass('fc-highlight');
        }
    }
    function removeClassFuction(neObj)
    {
        if (neObj)
        {
            var strDate;
            strDate = neObj.data('date');
            // console.log(strDate);
            neObj.addClass('fc-highlight');
        }
    }
    function getDate(obj)
    {
        var strDate = obj.data('date');
        return new Date(strDate.substring(0, 4),   strDate.substr(5, 2) - 1, strDate.substr(8,2));
    }

    function getFormattedDate(date) {
        let year = date.getFullYear();
        let month = (1 + date.getMonth()).toString().padStart(2, '0');
        let day = date.getDate().toString().padStart(2, '0');

        return year + "-" + month + '-' + day;
    }
    function getDateString(_year, _month, _day)
    {
        let year = _year;
        let month = (1 + _month).toString().padStart(2, '0');
        let day = _day.toString().padStart(2, '0');

        return year + "-" + month + '-' + day;
    }
});
