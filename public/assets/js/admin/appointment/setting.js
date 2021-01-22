$(".timepicker").timepicker({
    minuteStep: 30,
    showMeridian: !1,
});

$(".add_time_btn").click(function(){
    var $weekday = $(this).data("name");
    $("#"+$weekday+"_table").append('<tr id="row_'+$count+'"><td><input class="form-control timepicker start_time_area" name="start_time_'+$weekday+'[]" placeholder="start" readonly type="text" value="7:00"/></td><td><input class="form-control timepicker end_time_area" placeholder="end" name="end_time_'+$weekday+'[]" readonly type="text" value="18:00"/></td><td><a href="javascript:void(0);" data-id="row_'+$count+'" class="btn m-btn--square  btn-danger btn-sm p-1 btn_remove">X</a></td></tr>');
    $count++;
    $(".timepicker").timepicker({
        minuteStep: 30,
        showMeridian: !1,
    });
});

$(document).on('click', '.btn_remove', function(){
    var $row_id = $(this).data("id");
    $('#'+$row_id+'').remove();
});

$(document).on('click', '.checkbox', function(){
    var $weekday = $(this).data("name");
    if($(this).prop("checked")==true)
    {
        $("."+$weekday+"_table_area").css('display', 'table');
    }else {
        $("."+$weekday+"_table_area").css('display', 'none');
    }
});

$("#submit_form").submit(function(event) {
    event.preventDefault();
    $(".smtBtn").prop("disabled", true).html("<i class='fa fa-spinner fa-spin fa-2w'></i>");
    $.ajax({
        url:"/admin/appointment/setting",
        method: 'POST',
        data: new FormData(this),
        dataType:'JSON',
        contentType:false,
        cache:false,
        processData:false,
        success: function(result)
        {
            $(".smtBtn").prop("disabled", false).html("Submit");
            console.log(result)
            if(result.status===0)
            {
                dispErrors(result.data)
            }else {
                itoastr('success', 'Successfully Updated!');
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });
});
