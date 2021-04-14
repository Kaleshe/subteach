jQuery(document).ready(function($) {

  jQuery(".profile-card button").click(function(){

    $.ajax({
      url: display_user_profile_obj.ajaxurl,
      data: {
        'action': 'display_user_profile',
        'user_id': $(this).data("user-id"),
        'method': 'POST'
      },
      success:function(data) {
        let parsedData = JSON.parse(data);
        $('body').append(modal(parsedData));
        console.log(parsedData);
        MicroModal.show('profile-modal-' + parsedData.ID);
      },
      error:function(errorThrown) {
        console.log(errorThrown);
      }
    });
  });

});

const modal = (parsedData) => {
  let name = parsedData.schoolName ? parsedData.schoolName : parsedData.firstName + ' ' + parsedData.lastName;
return `<div class="modal micromodal-slide" id="profile-modal-${parsedData.ID}" aria-hidden="false">
  <div class="modal__overlay" tabindex="-1" data-micromodal-close>
    <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="profile-modal-title">
      <header class="modal__header">
        <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
      </header>
      <main class="modal__content" id="profile-modal-content">
        <div id="profile-modal-content">
          <div class="user-profile-info">
            <div class="mb-space-2 flex items-center">
              <img class="user-profile-photo" src="http://subteach.local/wp-content/uploads/2021/04/default-profile-image.jpg">
              <div class="ml-space">
                <h3 class="modal__title" id="profile-modal-title">${name}</h3>
                <p class="text-sm">[insert] Placements</p>
                <p class="text-sm">[insert] Documents</p>
              </div>
            </div>
            <div class="meta grid cols-2 gap text-sm">
              <p class="email">Email</p> <p class="font-medium">${parsedData.email}</p>
              <p class="telephone">Telephone</p> <p class="font-medium">${parsedData.telephone}</p>
              <p class="postcode">Postcode</p> <p class="font-medium">${parsedData.postcode}</p>
              <p class="address">Address</p> <p class="font-medium">${parsedData.schoolAddress}</p>
            </div>
          </div>
        </div>
      </main>
      <button class="modal__btn" data-micromodal-close aria-label="Close this dialog window">Deactivate User</button>
    </div>
  </div>
</div>`;
}

