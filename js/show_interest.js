jQuery(document).ready(function ($) {
  jQuery("button.show-interest").click(function () {
    const userID = $(this).closest('.profile-card').data("user-id");
    const eventID = $('#available-teachers').data('event-id');
    $.ajax({
      url: show_interest_obj.ajaxurl,
      data: {
        'action': 'show_interest',
        'user_id': userID,
        'event_id': eventID,
        'method': 'POST'
      },

      // Alert the like, will be changed later
      success: function (data) {
        if ($('#interested-user-' + userID).text() === 'Show Interest') {
          $('#interested-user-' + userID).text('Interest Shown');
          console.log('liked!');
        } 
      },
      error: function (errorThrown) {
        console.log(errorThrown);
      }
    });
  });
});