var uniqueValueDelay = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();


function uniqueValueRefresh($input) {
  var $spinner = $input.parent().find('.spinner'),
      $error   = $input.parent().find('.error'),
      $success = $input.parent().find('.success');
  $spinner.removeClass('hidden');
  $error.addClass('hidden');
  $success.addClass('hidden');

  var value = $input.val(),
      request = $.ajax({
        url: '/actions/uniqueValue/validate',
        type: 'POST',
        data: { value : value },
        dataType: 'json'
      });

  request.done(function(msg) {
    if ( msg.success ) {
      $spinner.addClass('hidden');
      $error.addClass('hidden');
      $success.removeClass('hidden');
    } else {
      $spinner.addClass('hidden');
      $error.removeClass('hidden');
      $success.addClass('hidden');
    }
  });

  request.fail(function(jqXHR, textStatus) {
    $spinner.addClass('hidden');
    $error.removeClass('hidden');
    $success.addClass('hidden');
  });

}


$(function(){

  $(document).on('keyup', '.uniquevalue input', function(e){
    var $t = $(this);
    uniqueValueDelay(function(){
      uniqueValueRefresh($t);
    }, 1000 );
  });

  $(window).on('load', function(){

    $('.uniquevalue input').each(function(i, elem){
      uniqueValueRefresh($(elem));
    });

  });
});
