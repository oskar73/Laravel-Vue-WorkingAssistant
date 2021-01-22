var fbOptions = {
    dataType: 'json',
    formData: formData,
    controlOrder: [
        'header',
        'paragraph',
        'text',
        'textarea',
        'select',
        'number',
        'date',
        'autocomplete',
        'file',
    ],
    disableFields: [
        'button', // buttons are not needed since we are the one handling the submission
    ],  // field types that should not be shown
    disabledAttrs: [
        // 'access',
    ],
    typeUserDisabledAttrs: {
        'file': [
            'multiple',
            'subtype',
        ],
        'checkbox-group': [
            'other',
        ],
    },
    showActionButtons: false, // show the actions buttons at the bottom
    disabledActionButtons: ['data'], // get rid of the 'getData' button
    sortableControls: false, // allow users to re-order the controls to their liking
    editOnAdd: false,
    fieldRemoveWarn: false,
    notify: {
        error: function(message) {
            return swal('Error', message, 'error')
        },
        success: function(message) {
            return swal('Success', message, 'success')
        },
        warning: function(message) {
            return swal('Warning', message, 'warning');
        }
    },
    onSave: function() {
        // var formData = formBuilder.formData
        // console.log(formData)
    },
}
var formBuilder = $("#build-wrap").formBuilder(fbOptions);

$(document).on('click', '.fb-clear-btn', function(e){

    e.preventDefault()

    if (! formBuilder.actions.getData().length) return

    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false,
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            event.preventDefault();
            formBuilder.actions.clearFields()
        } else if (
            // Read more about handling dismissals
            result.dismiss === swal.DismissReason.cancel
        ) {
            swal(
                'Cancelled',
                'Your data is safe :)',
                'error'
            )
        }
    })
});
$(document).on('click', '.fb-save-btn', function(e){
    mApp.blockPage();

    e.preventDefault();
    var form = $('#submit_form');
    var formBuilderJSONData = formBuilder.actions.getData('json');

    var postData = {
        id:id,
        _token:token,
        name: $('#form_name').val(),
        status: $('#status').prop('checked')==true? 1:0,
        form_builder_json: formBuilderJSONData
    };
    $.ajax({
        url:form.attr('action'),
        method:"post",
        data:postData,
        cache:false,
        success:function(result)
        {
            console.log(result)
            mApp.unblockPage();
            if(result.status===0)
            {
                dispErrors(result.data)
            }else {
                itoastr('success', 'Successfully Created!');
                setTimeout(function() {
                    window.location = result.data
                }, 1500);
            }
        },
        error : function(e) {
            console.log(e);
        },
    });

})
