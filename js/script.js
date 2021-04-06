// Add Subject ID to hidden field
;(function($){
  $('#subjectsList').on('input',function() {
    var opt = $('option[value="'+$(this).val()+'"]');
    $('input[name=subjectID]').val(opt.data('subject-id'));
  });
})(jQuery);


// Accordion
const accordion = Array.from( document.querySelectorAll('.accordion.is-closed') );

const accordionOpen = item => { item.classList.remove('is-closed'); item.classList.add('is-open'); };
const accordionClose = item => { item.classList.remove('is-open'); item.classList.add('is-closed') };

function toggle(item) {
  let button = item.querySelector('button');
  button.addEventListener('click', () => {
    item.classList.contains('is-closed') ? accordionOpen(item) : accordionClose(item);
  });
}

// Loop through each faq item
accordion.forEach( toggle );