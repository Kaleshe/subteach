;(function($){
  $('#subjectsList').on('input',function() {
    var opt = $('option[value="'+$(this).val()+'"]');
    $('input[name=subjectID]').val(opt.data('subject-id'));
  });
})(jQuery);