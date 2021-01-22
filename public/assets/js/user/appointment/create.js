$(document).ready(function() {
    $("#choose_date").datepicker({
        format: 'yyyy-mm-dd',
        startDate: '0d',
        todayHighlight: !0,
        autoclose: !0,
    });
})
var meeting_id=0;
var category_id=0;
var date=0;
var start=0;
var end=0;

$(document).on("click", ".product_item.available:not(.active)", function() {
    $(".product_item").removeClass("active");
    $(".period_area").html("");
    $(".choose_date_area").html("");
    $("#choose_date").val("");

    $(this).addClass("active");
    $(".category_item").removeClass("active");
    category_id=0;

    meeting_id = $(this).data("id");
    itoastr("success", "Great, please choose category!");

   $.ajax({
       url:"/account/appointment/selectProduct",
       data:{id:meeting_id},
       success:function(result)
       {
           $(".category_item").removeClass("alive");

           if(result.status===1)
           {
                $.each(result.data, function(index, item) {
                   $(".category_item[data-id="+item+"]").addClass("alive");
                });
           }else {
               dispErrors(result.data);
           }
       },
       error:function(e)
       {
           console.log(e);
       }
   })
});

$(document).on("click", ".time_item:not(.active)", function() {
    $(".time_item").removeClass("active");
    $(this).addClass("active");
    date = $(this).data("date");
    start = $(this).data("start");
    end = $(this).data("end");
    itoastr("success", "Great, you can submit now!");
});
$(document).on("click", ".category_item.alive:not(.active)", function() {
    $(".category_item").removeClass("active");
    $(this).addClass("active");
    category_id = $(this).data("id");

    getDate();
    $(".choose_date_area").html("");
    $("#choose_date").val("");
});
$(document).on("change", "#choose_date", function() {
    getDate($(this).val())
});
$(document).on("click", "#smtBtn", function() {
    if(meeting_id===0) return itoastr("error", "Please choose product");
    if(category_id===0) return itoastr("error", "Please choose category");
    if(date===0) return itoastr("error", "Please choose date");
    if(start===0) return itoastr("error", "Please choose date");
    if(end===0) return itoastr("error", "Please choose date");

    $(this).html("<i class='fa fa-spin fa-spinner'></i>").prop("disabled", true);

    $.ajax({
        url:"/account/appointment/store",
        data:{category_id:category_id, meeting_id:meeting_id, date:date, start:start, end:end, _token:token},
        method:"POST",
        success:function(result)
        {
            $("#smtBtn").html("Submit").prop("disabled", false);
            if(result.status===1)
            {
                itoastr("success", "Success!");
                window.setTimeout(function() {

                    window.location.href="/account/appointment";
                }, 1000)
            }
        },
        error:function(e)
        {
            console.log(e)
        }
    })
});
function getDate(selected_date=0)
{
    if(meeting_id!==0&&category_id!==0)
    {
        itoastr("success", "Great, please choose date!");
        $.ajax({
            url:"/account/appointment/selectCategory",
            data:{category_id:category_id, meeting_id:meeting_id, date:selected_date},
            success:function(result)
            {
                if(result.status===1)
                {
                    if(selected_date===0)
                    {
                        $(".period_area").html("");
                        $.each(result.data, function(index, item) {
                            $(".period_area").append(`<div class="pb-3 item-${index}"><div><b>-${index}</b></div></div>`);
                            console.log(item)
                            if(item.length===0)
                            {
                                $(`.item-${index}`).append("No available time period.");
                            }else {
                                $.each(item, function(ind, ite) {
                                    $(`.item-${index}`).append(`<span class="btn m-btn--square btn-sm  btn-outline-success m-btn m-btn--custom m-1 time_item" data-date="${index}" data-start="${ite.start}" data-end="${ite.end}">${ite.start} ~ ${ite.end}</span>`);
                                });
                            }
                        })
                    }else {
                        $(".choose_date_area").html("");
                        $.each(result.data, function(index, item) {
                            if(item.length===0)
                            {
                                $(`.choose_date_area`).append("No available time period.");
                            }else {
                                $.each(item, function(ind, ite) {
                                    $(`.choose_date_area`).append(`<span class="btn m-btn--square  btn-sm btn-outline-success m-btn m-btn--custom m-1 time_item" data-date="${index}" data-start="${ite.start}" data-end="${ite.end}">${ite.start} ~ ${ite.end}</span>`);
                                });
                            }
                        })
                    }
                }else {
                    $(".period_area").html("");
                    $(".choose_date_area").html("");
                }
            },
            error:function(e)
            {
                console.log(e);
            }
        })
    }
}
