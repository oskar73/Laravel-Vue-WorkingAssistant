
var switch_action;
var checkbox_count;
var alone=0;
var selected;
var previewCropped = '';
var isInitialized = false;
var cropper = '';
var file = '';

var recommends = {
    1:{"name":"Medium Rectangle", "width": 300, "height": 250, "title_char":0, "text_char":0},
    2:{"name":"Large Rectangle", "width": 336, "height": 280, "title_char":0, "text_char":0},
    3:{"name":"Leaderboard", "width": 728, "height": 90, "title_char":0, "text_char":0},
    4:{"name":"Wide Skyscraper", "width": 160, "height": 600, "title_char":0, "text_char":0},
    5:{"name":"Half Page Ad", "width": 300, "height": 600, "title_char":0, "text_char":0},
    6:{"name":"Full Banner", "width": 468, "height": 60, "title_char":0, "text_char":0},
    7:{"name":"Skyscraper", "width": 120, "height": 600, "title_char":0, "text_char":0},
    8:{"name":"Large Leaderboard", "width": 970, "height": 90, "title_char":0, "text_char":0},
    9:{"name":"Banner", "width": 468, "height": 60, "title_char":0, "text_char":0},
    10:{"name":"Square", "width": 250, "height": 250, "title_char":0, "text_char":0},
    11:{"name":"Small Square", "width": 200, "height": 200, "title_char":0, "text_char":0},
};
$(function () {
    hashUpdate(window.location.hash);
    getDatatableTable();
    $("#recommend").html(recommend());
});
function recommend()
{
    var option = "<option selected disabled hidden>Recommended type</option>";
    $.each(recommends, function(index, item) {
        option += "<option value='"+index+"' data-type='"+JSON.stringify(item)+"'>"+index+". "+item.name+" ("+item.width+"X"+item.height+")</option>";
    });
    return option;
}
function getDatatableTable()
{
    $.ajax({
        url:"/admin/siteAds/type",
        type:"get",
        dataType:'JSON',
        contentType:false,
        cache:false,
        processData:false,
        success:function(result)
        {
            if(result.status===1)
            {
                $(".show_checked").addClass("d-none");

                $("#all_area .m-portlet__body").html(result.all);
                $("#active_area .m-portlet__body").html(result.active);
                $("#inactive_area .m-portlet__body").html(result.inactive);
                $(".all_count").html(result.count.all)
                $(".active_count").html(result.count.active)
                $(".inactive_count").html(result.count.inactive)
                $(".datatable").dataTable(dataTblSet())
                $(".select2").select2({
                    placeholder:'Choose recommended tags',
                    width:'100%'
                });
            }
        },
        error:function(e) {
            console.log(e);
        }
    })
}

$("#recommend").change(function() {
    var type = $(this).find(':selected').data('type');
    $("#name").val(type.name);
    $("#width").val(type.width);
    $("#height").val(type.height);
    $("#title_char").val(type.title_char);
    $("#text_char").val(type.text_char);
    previewUpdate();
});

$(".createBtn").click(function() {
    $("#type_id").val(null);
    $("#create_modal_form").find("input[type=text], textarea").val("");
    $("#create_modal").modal("toggle");
    $(".preview").hide();
});

$(document).on("change", ".change_pam", function() {
    previewUpdate();
});

function previewUpdate(width=null, height=null, title=null, text=null)
{
    $(".preview").show();
    if(width==null)
    {
        width = $("#width").val();
    }
    if(height==null)
    {
        height = $("#height").val();
    }
    if(title==null)
    {
        title = $("#title_char").val();
    }
    if(text==null)
    {
        text = $("#text_char").val();
    }
    var preview_img = $("#preview_img");
    preview_img.css("width", width+"px");
    preview_img.css("height", height+"px");

    $(".width_val").html(width);
    $(".height_val").html(height);

    if(title==0)
    {
        $(".title_pos").hide();
    }else {
        $(".title_pos").show();
    }
    if(text==0)
    {
        $(".text_pos").hide();
    }else {
        $(".text_pos").show();
    }
}

$("#create_modal_form").submit(function(event) {
    event.preventDefault();

    mApp.block("#create_modal .modal-content", {});
    $.ajax({
        url:"/admin/siteAds/type",
        method: 'POST',
        data: new FormData(this),
        dataType:'JSON',
        contentType:false,
        cache:false,
        processData:false,
        success: function(result)
        {
            mApp.unblock("#create_modal .modal-content");
            if(result.status===0)
            {
                dispErrors(result.data)
                dispValidErrors(result.data)
            }else {
                itoastr('success', 'Success!');
                $("#create_modal").modal('toggle');
                getDatatableTable();
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });
});

$(document).on('click', '.edit_btn', function() {
    var type = $(this).data("type");
    console.log(type)
    $("#create_modal").modal("toggle");
    $("#type_id").val(type.id);
    $("#name").val(type.name);
    $("#description").val(type.description);
    $("#width").val(type.width);
    $("#height").val(type.height);
    $("#title_char").val(type.title_char);
    $("#text_char").val(type.text_char);
    if (type.status == 1) {
        $("#status").prop("checked", true);
    } else {
        $("#status").prop("checked", false);
    }
    previewUpdate();
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
        case 'delete':
            msg = 'Do you want to delete '+item+'?';
            break;
    }
    askToast.question('Confirm', msg, 'switchAction');
}
function switchAction()
{
    $.ajax({
        url:"/admin/siteAds/type/switch",
        data:{ids:checkedIds(), action:switch_action},
        method:"get",
        success:function(result) {
            console.log(result)
            if(result.error)
            {
                dispErrors(result.message)
            }else {
                itoastr("success", 'Successfully updated!');
                getDatatableTable()

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
