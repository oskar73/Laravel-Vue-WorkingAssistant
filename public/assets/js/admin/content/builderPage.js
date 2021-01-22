
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


$(".control-panel").draggable();

var btnSave = document.querySelector('#btnSave');

$("#controlForm").submit(function(event) {
    event.preventDefault();

    $("#btnSave").prop("disabled", true);

    var formData = new FormData(this);

    builder.saveImages('/admin/content/page/upload/saveImage/'+page_id, function(){
        // setTimeout(function(){
            formData.append('inpHtml', builder.html());
            // document.querySelector('#inpHtml').value = builder.html();

            $.ajax({
                url:"/admin/content/page/editContent/"+page_id+"/builder",
                method: 'POST',
                data: formData,
                dataType:'JSON',
                contentType:false,
                cache:false,
                processData:false,
                success: function(result)
                {
                    $("#btnSave").prop("disabled", false);

                    if(result.status===0)
                    {
                        console.log(result.data);
                    }else {
                        itoastr("success", "Successfully Updated!");
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
