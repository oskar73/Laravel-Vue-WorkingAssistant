$(document).ready(function () {
  $('.selectpicker').selectpicker()
  $('#date').datepicker({
    format: 'yyyy-mm-dd',
    startDate: '0d',
    todayHighlight: !0,
    autoclose: !0
  })
  $('.timepicker').timepicker({
    minuteStep: 30,
    showMeridian: !1
  })
})
$('#submit_form').on('submit', function (e) {
  e.preventDefault()
  $('.smtBtn').html("<i class='fa fa-spin fa-spinner'></i>").prop('disabled', true)
  $.ajax({
    url: $(this).attr('action'),
    method: 'POST',
    data: new FormData(this),
    dataType: 'JSON',
    contentType: false,
    cache: false,
    processData: false,
    success: function (result) {
      console.log(result)
      $('.smtBtn').html('Submit').prop('disabled', false)
      if (result.status === 1) {
        itoastr('success', 'Successfully updated!')
      } else {
        dispErrors(result.data)
      }
    }
  })
})
