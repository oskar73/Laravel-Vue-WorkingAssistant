var is_wrapper = $("#builder");

$(document).ready(function() {
    is_wrapper.contentbox({
        framework: 'bootstrap',
        modulePath: $path+'/assets/vendors/contentbuilder/assets/modules/',
        assetPath: $path+'assets/vendors/contentbuilder/assets/',
        designPath: $path+'assets/vendors/contentbuilder/assets/designs/',
        contentStylePath: $path+'assets/vendors/contentbuilder/assets/styles/',
        snippetData: $path+'assets/vendors/contentbuilder/assets/minimalist-blocks/snippetlist.html',

        fontAssetPath: $path+'assets/vendors/contentbuilder/assets/fonts/',
        pluginPath: $path+'assets/vendors/contentbuilder/contentbuilder/',
        scriptPath: $path+'assets/vendors/contentbuilder/contentbuilder/',

        snippetPathReplace: ['assets/minimalist-blocks/', $path+'assets/vendors/contentbuilder/assets/minimalist-blocks/'],
        snippetOpen: true,
        row: 'row',
        cols: ['col-md-1', 'col-md-2', 'col-md-3', 'col-md-4', 'col-md-5', 'col-md-6', 'col-md-7', 'col-md-8', 'col-md-9', 'col-md-10', 'col-md-11', 'col-md-12'],
        clearPreferences: true,
        coverImageHandler: '/admin/content/page/upload/cover/'+page_id, /* for uploading section background */
        largerImageHandler: '/admin/content/page/upload/largeImage/'+page_id, /* for uploading larger image */
        moduleConfig: [{
            "moduleSaveImageHandler": "/admin/content/page/upload/moduleImage/"+page_id, /* for module purpose image saving (ex. slider) */
            "moduleSaveVideoHandler": "/admin/content/page/upload/moduleVideo/"+page_id, /* for module purpose image saving (ex. slider) */
        }],
        onRender: function () {
            $('a.is-lightbox').simpleLightbox({ closeText: '<i style="font-size:35px" class="icon ion-ios-close-empty"></i>', navText: ['<i class="icon ion-ios-arrow-left"></i>', '<i class="icon ion-ios-arrow-right"></i>'], disableScroll: false });
        },
    });

    $(".control-panel").draggable();

    $('a.is-lightbox').simpleLightbox({ closeText: '<i style="font-size:35px" class="icon ion-ios-close-empty"></i>', navText: ['<i class="icon ion-ios-arrow-left"></i>', '<i class="icon ion-ios-arrow-right"></i>'], disableScroll: false });

});
$("#controlForm").submit(function(event) {
    event.preventDefault();

    $("#btnSave").prop("disabled", true);

    var formData = new FormData(this);

    is_wrapper.data('contentbox').saveImages('/admin/content/page/upload/saveImage/'+page_id, function() {

        formData.append("sHTML", is_wrapper.data('contentbox').html());
        formData.append("sMainCss", is_wrapper.data('contentbox').mainCss());
        formData.append("sSectionCss", is_wrapper.data('contentbox').sectionCss());

        $.ajax({
            url:"/admin/content/page/editContent/"+page_id+"/box",
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
                    dispValidErrors(result.data)
                    dispErrors(result.data)
                }else {
                    itoastr("success", "Successfully Updated!");
                }
            },
            error: function(e)
            {
                console.log(e)
            }
        });
    })
});
