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
$(document).on('ready', function () {

  $('.add-to-cart').click(function(e){
    e.preventDefault();
    var p_id = $(this).attr('data-id');
    $.ajax({
        url: 'actions.php',
        method: 'POST',
        data: {addCart:p_id},
        success: function(data){
            // console.log(data);
            location.reload();
        }
    });
});

$('.remove-cart-item').click(function(e){
    e.preventDefault();
    var p_id = $(this).attr('data-id');
    $.ajax({
        url: 'actions.php',
        method: 'POST',
        data: {removeCartItem:p_id},
        success: function(data){
            location.reload();
        }
    });
});

});