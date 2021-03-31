;(function($){
  $('#subjectsList').on('input',function() {
    var opt = $('option[value="'+$(this).val()+'"]');
    $('input[name=subjectID]').val(opt.data('subject-id'));
  });
})(jQuery);

/*
  Accordion toggle
*/

const accordionItems = Array.from( document.querySelectorAll('.accordion article.is__closed') );

const openItem = item => { item.classList.remove('is__closed'); item.classList.add('is__open'); };
const closeItem = item => { item.classList.remove('is__open'); item.classList.add('is__closed') };

// Loop through each faq item
accordionItems.forEach( item => 
  item.addEventListener( 'click', () => {

    // Open & close toggle - without using classList.toggle because .is__closed it already defined
    item.classList.contains('is__closed') ? openItem(item) : closeItem(item);
  } ));
