var uniqueValueDelay = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();


function uniqueValueRefresh($input) {
  var $spinner    = $input.parent().find('.spinner'),
      $error      = $input.parent().find('.error'),
      $success    = $input.parent().find('.success'),
      value       = $input.val(),
      fieldHandle = $input.prev('.uniquevalue-fieldhandle').val(),
      entryId     = $('input[name="entryId"]').val();
  $spinner.removeClass('hidden');
  $error.addClass('hidden');
  $success.addClass('hidden');

  var request = $.ajax({
        url: '/actions/uniqueValue/validate',
        type: 'POST',
        data: {
          value       : value,
          fieldHandle : fieldHandle,
          entryId     : entryId
        },
        dataType: 'json'
      });

  request.done(function(msg) {
    if ( msg.success ) {
      $spinner.addClass('hidden');
      $error.addClass('hidden');
      $success.removeClass('hidden');
    } else {
      console.log(msg.suggestion);
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

  $(document).on('keyup', '.uniquevalue-value', function(e){
    var $t = $(this);
    uniqueValueDelay(function(){
      uniqueValueRefresh($t);
    }, 1000 );
  });

  $(window).on('load', function(){

    $('.uniquevalue-value').each(function(i, elem){
      uniqueValueRefresh($(elem));
    });

  });
});
