var selected = 0;
$(document).ready(function() {
    $(".non_search_select2").select2({
        placeholder:"Choose Page Type",
        width: '100%',
        minimumResultsForSearch: -1
    });
})
$("#page_type").on("change", function() {
    var type = $(this).val();
    $(".page_area").addClass("d-none");
    if(type==='category')
    {
        $(".category_area").removeClass("d-none");
    }else if(type==='tag')
    {
        $(".tag_area").removeClass("d-none");
    }else if(type==='detail')
    {
        $(".detail_area").removeClass("d-none");
    }
    $("#position").val("");
    $("#position_id").val("");
    selected = 0;
})
$("#select_position").on("click", function() {
    var position_type = $("#position_type").val();
    var page_type = $("#page_type").val();
    var page=null;

    if(page_type==='category')
    {
        page = $("#category").val();
    }else if(page_type==='tag')
    {
        page = $("#tag").val();
    }else if(page_type==='detail')
    {
        page = $("#detail").val();
    }
    if(position_type==='fixed') return getPosition(position_type, page_type, page);
    if(page_type==null||page_type==='') return itoastr("info", "Please choose page type.");
    if(page_type!=='home'&&page==null) return itoastr("info", "Please choose page.");
    if(selected===1) return $("#position_modal").modal("toggle");
    else return getPosition(position_type, page_type, page);
})
$(document).on("click", ".position_item.available1", function() {
    $(".position_item").removeClass("active");
    $(this).addClass("active");
    $("#position").val($(this).data("name"));
    $("#position_id").val($(this).data("id"));

    $(".preview_position").html(`<img src="${$(this).data("image")}" class="w-100">`);
    $("#position_modal").modal("toggle");
});
$("#position_type").on("change", function() {
    var type = $(this).val();
    if(type==='fixed')
    {
        $(".d-none-when-fixed").addClass("d-none");
    }else {
        $("#page_type").val("").trigger('change.select2');
        $(".page_type_area").removeClass("d-none");
    }
    $("#position").val("");
    $("#position_id").val("");
    selected = 0;
})
function getPosition(position_type, page_type, page)
{

    $.ajax({
        url:"/admin/directoryAds/spot/getPosition",
        data:{position_type:position_type,type:page_type,page:page},
        success:function(result)
        {
            console.log(result)
            if(result.status===1)
            {
                $(".position_area").html("");

                $.each(result.data, function(index, item) {
                    $(".position_area").append(`<div class="position_item tipso2 available${item.available}" data-tipso-title='Position Image' data-tipso='<img src="${item.image}" style="width:100%;height:auto;">' data-id="${item.id}" data-name="${item.name}" data-image="${item.image}">${item.name}</div>`);
                });


                jQuery(".tipso2").tipso({
                    speed             : 400,
                    background        : '#000',
                    titleBackground   : '#86bc42',
                    color             : '#ffffff',
                    titleColor        : '#ffffff',
                    titleContent      : '',
                    size: 'default',
                    showArrow         : true,
                    position: 'top',
                    width: '300',
                });

                $("#position_modal").modal("toggle");

                selected = 1;
            }else {
                dispErrors(result.data);
                dispValidErrors(result.data);
            }
        },
        error:function(e)
        {
            console.log(e)
        }
    })
}
$("#submit_form").on("submit", function(e) {
    e.preventDefault();
    $(".smtBtn").html("<i class='fa fa-spin fa-spinner fa-2x'></i>").prop("disabled", true);

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
            $(".smtBtn").prop("disabled", false).html("Next");

            if(result.status===0)
            {
                dispErrors(result.data);
                dispValidErrors(result.data);
            }else {
                itoastr('success', 'Successfully Created!');

                setTimeout(function() {
                    window.location.href=result.data;
                }, 1000);

            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });
});
