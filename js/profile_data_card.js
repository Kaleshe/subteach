jQuery(document).ready(function ($) {
  jQuery("span.like").click(function () {
    $.ajax({
      url: like_teacher_obj.ajaxurl,
      data: {
        'action': 'like_teacher',
        'user_id': parsedData.ID,
        'method': 'POST'
      },

      // Alert the like, will be changed later
      success: function () {
        alert('Liked!');
      },
      error: function (errorThrown) {
        console.log(errorThrown);
      }
    });
  });
});