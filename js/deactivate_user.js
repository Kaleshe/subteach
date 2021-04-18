jQuery(document).ready(function($) {

  jQuery("button.deactivate__user__btn").click(function(){

    $.ajax({
      url: deactivate_user_obj.ajaxurl,
      data: {
        'action': 'deactivate_user',
        'user_id': $(this).data("user-id"),
        'method': 'POST'
      },
      success:function(data) {
        console.log(data);
      },
      error:function(errorThrown) {
        console.log(errorThrown);
      }
    });
  });

});