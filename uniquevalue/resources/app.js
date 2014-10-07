var uniqueValueDelay = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();


function uniqueValueRefresh($input) {
  var $parent     = $input.parent(),
      $spinner    = $parent.find('.spinner'),
      $error      = $parent.find('.error'),
      $success    = $parent.find('.success'),
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

      $parent.next('.uniquevalue-suggestion').fadeOut(200, function(){
        $(this).remove();
      });
    } else {
      $spinner.addClass('hidden');
      $error.removeClass('hidden');
      $success.addClass('hidden');

      // suggestion
      if ( msg.suggestion ) {
        $parent.next('.uniquevalue-suggestion').remove();
        $suggestion = $('<div class="uniquevalue-suggestion btn small">Try ‘'+msg.suggestion+'’</div>').hide();

        $suggestion
          .insertAfter($parent)
          .fadeIn('200')
          .on('click', function(e){
            e.preventDefault();
            $input.val(msg.suggestion);
            $(this).fadeOut(200, function(){
              $(this).remove();
              $input.trigger('keyup');
            });
          });
      }
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
