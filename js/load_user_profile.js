jQuery(document).ready(function($) {

  jQuery(".profile-card button").click(function(){

    $.ajax({
      url: load_user_profile_obj.ajaxurl,
      data: {
        'action': 'load_user_profile',
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
      <header class="modal__header text-sm text-center">
        <h2 class="modal__title" id="profile-modal-title">
        ${name}
        </h2>
        <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
      </header>
      <main class="modal__content" id="profile-modal-content">
        <div id="profile-modal-content">
        <div class="user-profile-info">
          <img class="user-profile-photo mb-space" src="http://subteach.local/wp-content/uploads/2021/04/default-profile-image.jpg">
            <div class="text-sm">                            
              <div>
                <div class="grid cols-2 gap">
                  <p class="email">Email</p> <p class="font-medium">${parsedData.email}</p>
                  <p class="telephone">Telephone</p> <p class="font-medium">${parsedData.telephone}</p>
                  <p class="postcode">Postcode</p> <p class="font-medium">${parsedData.postcode}</p>
                  <p class="address">Address</p> <p class="font-medium">${parsedData.schoolAddress}</p>
                </div>
              </div>
            </div>
        </div>
        </div>
      </main>
      <button class="modal__btn" data-micromodal-close aria-label="Close this dialog window">Deactivate User</button>
    </div>
  </div>
</div>`;
}

