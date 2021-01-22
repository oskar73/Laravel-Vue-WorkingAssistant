
var switch_action;
var checkbox_count;
var alone=0;
var selected;

$(function () {
    $(".datatable").dataTable(dataTblSet())
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
        case 'active':
            msg = 'Do you want to activate '+item+'?';
            break;
        case 'inactive':
            msg = 'Do you want to make inactivate '+item+'?';
            break;
        case 'visible':
            msg = 'Do you want to set visible sponsored link '+item+'?';
            break;
        case 'invisible':
            msg = 'Do you want to set invisible sponsored link '+item+'?';
            break;
        case 'new':
            msg = 'Do you want to set new '+item+'?';
            break;
        case 'undonew':
            msg = 'Do you want to cancel new '+item+'?';
            break;
        case 'featured':
            msg = 'Do you want to set featured '+item+'?';
            break;
        case 'unfeatured':
            msg = 'Do you want to cancel featured '+item+'?';
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
        url:"/admin/siteAds/spot/switchSpot",
        data:{ids:checkedIds(), action:switch_action},
        method:"get",
        success:function(result) {
            console.log(result)
            if(result.error)
            {
                dispErrors(result.message)
            }else {
                itoastr("success", 'Successfully updated!');
                window.setTimeout(function() {
                    window.location.reload();
                }, 1000)

            }
        },
        error:function(e) {
            console.log(e);
        }
    })
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
