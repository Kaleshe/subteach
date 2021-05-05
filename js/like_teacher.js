jQuery(document).ready(function ($) {
  jQuery("span.like").click(function () {
    const userID = $(this).closest('.profile-card').data("user-id");
    $.ajax({
      url: like_teacher_obj.ajaxurl,
      data: {
        'action': 'like_teacher',
        'user_id': userID,
        'method': 'POST'
      },

      // Alert the like, will be changed later
      success: function (data) {
        if ($('#like-user-' + userID).text() === 'Unlike') {
          $('#like-user-' + userID).text('Like');
          console.log('liked!');
        } else {
          $('#like-user-' + userID).text('Unlike');
        }
        console.log(data);
      },
      error: function (errorThrown) {
        console.log(errorThrown);
      }
    });
  });
});