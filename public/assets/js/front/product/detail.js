var pageUrl = '/review' + '?page=1'
var model_data = { type: type, model_id: model_id }

$(document).ready(function () {
  $('.lightgallery').lightGallery()
  getReviews(pageUrl)

  $('#rating').rateYo({
    rating: 0,
    ratedFill: '#86bc42',
    fullStar: true,
    onChange: function (rating, rateYoInstance) {
      $(this).next().val(rating)
    }
  })
})

$(document).on('click', '.addToCartBtn', function (e) {
  e.preventDefault()
  var price = $('input[type=radio][name=price]:checked').val()
  if (price == null) return itoastr('info', 'Please choose one price plan')
  var quantity = $('#quantity').val()
  $(this).find('span').append('<i class="loading_div fas fa-spinner fa-spin fa-fw"></i>')
  var goto = $(this).data('cart')
  $.ajax({
    url: `/package/${model_id}/addtocart`,
    data: { price: price, quantity: quantity },
    success: function (result) {
      $('.loading_div').remove()
      if (result.status === 0) {
        dispErrors(result.data)
      } else {
        if (goto === 1) {
          window.location.href = '/cart'
        } else {
          itoastr('success', 'Successfully added!')
          $('.header_cart_area').html(result.data)
          $('.toggleBtn').toggleClass('d-none')
        }
      }
    },
    error: function (e) {
      console.log(e)
    }
  })
})
