jQuery(document).ready(function ($) {
  jQuery("span.like").click(function () {
    const userID = $(this).data("user-id");
    $.ajax({
      url: like_teacher_obj.ajaxurl,
      data: {
        'action': 'like_teacher',
        'user_id': userID,
        'method': 'POST'
      },

      // Alert the like, will be changed later
      success: function () {
        $('#like-user-' + userID).text('Unlike');
        console.log('liked!');
      },
      error: function (errorThrown) {
        console.log(errorThrown);
      }
    });
  });
});