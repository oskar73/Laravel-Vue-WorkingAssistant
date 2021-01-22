$(document).on('click', '.cancelBtn', function () {
  $('#cancel_modal').modal('toggle')
})
$(document).on('click', '.approveBtn', function () {
  $('#approve_modal').modal('toggle')
})
$('#cancel_modal_form').on('submit', function (e) {
  e.preventDefault()
  $('.cancel_smtBtn').html("<i class='fa fa-spin fa-spinner'></i>").prop('disabled', true)
  $.ajax({
    url: '/admin/appointment/listing/switch',
    data: { ids: [id], action: 'cancel', reason: $('#reason').val() },
    method: 'get',
    success: function (result) {
      $('.cancel_smtBtn').html('Submit').prop('disabled', false)
      if (result.status === 1) {
        itoastr('success', 'Successfully canceled.')
        window.setTimeout(function () {
          window.location.reload()
        }, 1000)
      } else {
        dispErrors(result.data)
      }
    }
  })
})
$('#approve_modal_form').on('submit', function (e) {
  e.preventDefault()
  $('.approve_smtBtn').html("<i class='fa fa-spin fa-spinner'></i>").prop('disabled', true)
  $.ajax({
    url: '/admin/appointment/listing/switch',
    data: { ids: [id], action: 'approve', description: $('#description').val() },
    method: 'get',
    success: function (result) {
      $('.approve_smtBtn').html('Submit').prop('disabled', false)
      if (result.status === 1) {
        itoastr('success', 'Successfully canceled.')
        window.setTimeout(function () {
          window.location.reload()
        }, 1000)
      } else {
        dispErrors(result.data)
      }
    }
  })
})
