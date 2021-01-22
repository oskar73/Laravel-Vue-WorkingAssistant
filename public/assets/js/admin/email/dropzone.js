var uploadedDocumentMap = {};
Dropzone.autoDiscover = false;
var fileNames = {};

var myDropzone = new Dropzone("#mydropzone", {
    url:"/uploadImages/"+edit_id,
    maxFilesize: 2, // MB
    addRemoveLinks: true,
    acceptedFiles: "image/*",
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function (file, response) {
        fileNames[response.original_name] = response.name;
        uploadedDocumentMap[file.name] = response.name;
        $("#fileNames").val(JSON.stringify(fileNames));
    },
    error : function(file, response) {
        itoastr('error', response);
    },
    removedfile: function (file) {
        file.previewElement.remove();
        var name = '';
        if (typeof file.file_name !== 'undefined') {
            name = file.file_name
        } else {
            name = uploadedDocumentMap[file.name]
        }
        delete fileNames[file.name];
        $("#fileNames").val(JSON.stringify(fileNames));
    },
});
