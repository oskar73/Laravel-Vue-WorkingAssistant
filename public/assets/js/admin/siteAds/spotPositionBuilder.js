$(document).ready(function() {
    $(".site_ads_spot_area").draggable({containment: "#wholecontainer"});

    dropInit();

    getSiteAds();

});

function dropInit() {
    $("#wholecontainer div").droppable({
        drop: function(e, ui) {
            ui.draggable.css({
                top: "",
                left: "",
            }).appendTo($(this));
            $(e.target).removeClass("droppable-over");
        },
        over: function(e, ui) {
            $(e.target).addClass("droppable-over");
        },
        out: function(e, ui) {
            $(e.target).removeClass("droppable-over");
        }
    });

    $(".site_ads_spot_area").droppable( {
        disabled: true
    });
    $(".embed-responsive").droppable( {
        disabled: true
    });
    $(".embed-responsive div").droppable( {
        disabled: true
    });
    $(".droppable-disabled").droppable( {
        disabled: true
    })
}

var builder = new ContentBuilder({
    container: '#wholecontainer',
    snippetData: $path+'assets/vendors/contentbuilder/assets/minimalist-blocks/snippetlist.html',
    fontAssetPath: $path+'assets/vendors/contentbuilder/assets/fonts/',
    snippetPath: $path+'assets/vendors/contentbuilder/assets/minimalist-blocks/',
    pluginPath: $path+'assets/vendors/contentbuilder/contentbuilder/',
    assetPath: $path+'assets/vendors/contentbuilder/assets/',
    scriptPath: $path+'assets/vendors/contentbuilder/contentbuilder/',
    snippetPathReplace: ['assets/minimalist-blocks/', $path+'assets/vendors/contentbuilder/assets/minimalist-blocks/'],
    snippetOpen: true,
    row: 'row',
    cols: ['col-md-1', 'col-md-2', 'col-md-3', 'col-md-4', 'col-md-5', 'col-md-6', 'col-md-7', 'col-md-8', 'col-md-9', 'col-md-10', 'col-md-11', 'col-md-12'],
    clearPreferences: true
});


// $(".control-panel").draggable();

var btnSave = document.querySelector('#btnSave');

$("#controlForm").submit(function(event) {
    event.preventDefault();

    var action = $(this).attr("action");

    $("#btnSave").prop("disabled", true);

    var formData = new FormData(this);

    $("div").removeClass("ui-droppable");

    builder.saveImages('/admin/content/page/upload/saveImage/'+page_id, function(){
        // setTimeout(function(){

        $(".site_ads_spot_area").each(function(index, item) {
            $(this).replaceWith(`<div class="site_ads_spot_area" id="`+$(this).attr('id')+`"></div>`);
        });

            formData.append('inpHtml', builder.html());

            $.ajax({
                url:action,
                method: 'POST',
                data: formData,
                dataType:'JSON',
                contentType:false,
                cache:false,
                processData:false,
                success: function(result)
                {
                    $("#btnSave").prop("disabled", false);

                    console.log(result)
                    if(result.status===0)
                    {
                        console.log(result.data);
                    }else {
                        itoastr("success", "Successfully Updated!");
                        window.location.reload();
                    }
                },
                error: function(e)
                {
                    console.log(e)
                }
            });

        // }, 1000);
    });

});

function changeWidth() {
    document.getElementById("wholecontainer").style.maxWidth =  document.getElementById('max-width').value+"px";
}
function switchWidth() {
    var checkbox = document.getElementById("getcheckbox").checked;
    if(checkbox===true)
    {
        document.querySelector('.max-area').style.display = "none";
        document.getElementById("wholecontainer").style.maxWidth="100%";
    }else {
        document.querySelector('.max-area').style.display = "block";
        changeWidth();
    }
}

$("#back_color").colorPicker({
    renderCallback: function($elm, toggled) {
        $(".out_content").css('background-color', "#"+this.color.colors.HEX);
    }
});
function getSiteAds()
{
    $.ajax({
        url:"/admin/siteAds/spot/getAds",
        method: 'get',
        data: {page_id:page_id},
        success: function(result)
        {
            console.log(result);
            if(result.status===1)
            {
                $.each(result.data, function(index, item) {
                    if(item!==null)
                    {
                        $("#site-ads-spot-"+item.position_id).html(item.frame);
                        console.log("#site-ads-spot-"+item.position_id);
                        dropInit();
                    }
                })
            }
        },
        error: function(e)
        {
            console.log(e)
        }
    });
}

$(document).on('click', 'button', function() {
    dropInit()
});
