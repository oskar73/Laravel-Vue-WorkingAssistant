// var pageUrl = '/package' + '?page=1'

$(document).ready(function () {
//   updateItems()
})

$(document).on('click', '.gotocart', function (e) {
  e.preventDefault()
  window.location.href = '/cart'
})

$(document).on('click', '.add_to_cart', function (e) {
  e.preventDefault()
  var obj = $(this)
  var id = obj.data('id')
  var image = obj.parent().parent().parent().find('.image-container > div').css('background-image')
  image = image ? image.slice(4, -1).replace(/"/g, ""):''
  $.ajax({
    url: `/product/${id}/addtocart`,
    data: {
        quantity: 1,
        price: 0,
        image: image,
    },
    success: function (result) {
      if (result.status === 0) {
        dispErrors(result.data)
      } else {
        iziToast.success({
            title: 'success',
            message: 'Successfully added!',
            position: 'topCenter'
        })

        $('.header_cart_area').html(result.data)
        obj.toggleClass('d-none')
      }
    },
    error: function (e) {
      console.log(e)
    }
  })
})
