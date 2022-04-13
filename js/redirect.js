$(document).on('click', 'a.nav-link', function (e) {

  e.preventDefault();
  var pageURL = $(this).attr('href');

  history.pushState(null, '', pageURL);


  $.ajax({
    type: "GET",
    url: "page-content.php",
    data: {
      page: pageURL
    },
    dataType: "html",
    success: function (data) {
      $("#load").load(data);
      $('#pageContent').html(data);

    }

  });
});

function getVal() {
  const val = document.querySelector('input').value;
  console.log(val);
}
// function getFormData(form) {
//   var rawJson = form.serializeArray();
//   var model = {};
  
//   $.map(rawJson, function (n, i) {
//       model[n['name']] = n['value'];
//   });
  
//   return model;
//   }
$(document).ready(function () {
// alert("???")
  $('.add-to-cart').click(function (e) {
    e.preventDefault();
    var productCode = $(this).attr('data-id');
    var quantity = $(this).attr('data-quantity');
    $.ajax({
      url: 'actions.php',
      method: 'POST',
      data: {addCart:productCode, quantity:quantity},
      success: function (data) {
        // console.log(data);
        location.reload();
      }
    });
  });

  $('.remove-cart-item').click(function (e) {
    e.preventDefault();
    var productCode = $(this).attr('data-id');
    $.ajax({
      url: 'actions.php',
      method: 'POST',
      data: {
        removeCartItem: productCode
      },
      success: function (data) {
        location.reload();
      }
    });
  });

  // $('#update-cart').click(function (e) {
  //   e.preventDefault();
  //   var productId = $(this).attr('data-id');
  //   var quantity = document.getElementById('update-cart-quan').value;
  //   $.ajax({
  //     url: 'actions.php',
  //     method: 'POST',
  //     data: {
  //       updateCart: productId,
  //       quantity: quantity
  //     },
  //     success: function (data) {
  //       // console.log(data);
  //       location.reload();
  //     }
  //   });
  // });

// });
// $('form.add-to-cart').submit(function (event) {
//   console.log("22333");
  // var data = {
  //   quantity : $('#quatity').value,
  //   productId : $('#productId').value
  // };
  // debugger;
//   event.preventDefault();
  
// alert("aaa");

//   var th = $(this);
//   $.ajax({
//     type: "POST",
//     url: "actions.php",
//     data: {
//       addCart: th.serialize()
//     },
//     success: function (data) {
//       location.reload();
//     }
//   });
// });
// $('form.remove-cart-item').submit(function () {
//   var th = $(this);
//   $.ajax({
//     type: "POST",
//     url: "actions.php",
//     data: {
//       removeCart: th.serializeArray()
//     },
//     success: function (data) {
//       location.reload();
//     }
//   });
// });
// $('form.update-cart').submit(function (event) {
//   event.preventDefault();
  
//   var productCode = $('.productCode').val();
//   var quantity = $('.update-cart-quantity'+productCode).val();
//   alert(productCode);
//   alert(quantity);
//   $.ajax({
//     type: "POST",
//     url: "actions.php",
//     data: {
//       updateCart:productCode,
//       quantity:quantity
//     },
//     success: function (data) {
//       location.reload();
//     }
//   });
// });

$(".cart-qty-single").change(function(){
  let getItemID = $(this).data('item-id');
  let qty = $(this).val();
  $.ajax({
      type:'POST',
      url:'actions.php',
      data: {action:'update-qty', itemID: getItemID, qty: qty},
      success:function(data){
          location.reload();
      }
  });
});

});
