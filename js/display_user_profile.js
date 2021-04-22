jQuery(document).ready(function($) {

  // Gets the current user type
  const currentUserType = $(document.body).data("current-user-type");

  jQuery(".profile-card button").click(function(){

    const userID = $(this).data("user-id");

    $.ajax({
      url: display_user_profile_obj.ajaxurl,
      data: {
        'action': 'display_user_profile',
        'user_id': userID,
        'method': 'POST'
      },

      // Populate modal with user data
      success:function(data) {
        let parsedData = JSON.parse(data);
        $('body').append(modal(parsedData));
        MicroModal.show('profile-modal-' + userID);

        // Onloy load for school users
        if( currentUserType == 'school' ) {
          // Like user
          jQuery("span.like").click(function(){
            $.ajax({
              url: like_teacher_obj.ajaxurl,
              data: {
                'action': 'like_teacher',
                'user_id': userID,
                'method': 'POST'
              },

              // Alert the deactivated user 
              success:function() {
                alert('Liked!');
                },
              error:function(errorThrown) {
                console.log(errorThrown);
              }
            });
          });
        }

        // Only load for admin users
        if( currentUserType != 'school' ) {
          jQuery("button.deactivate__user__btn").click(function(){
            $.ajax({
              url: deactivate_user_obj.ajaxurl,
              data: {
                'action': 'deactivate_user',
                'user_id': userID,
                'method': 'POST'
              },
  
              // Alert the deactivated user 
              success:function() {
                alert(parsedData.schoolName + ' has been deactivated.');
                },
              error:function(errorThrown) {
                console.log(errorThrown);
              }
            });
          });
        }
      },
      error:function(errorThrown) {
        console.log(errorThrown);
      }
    });
  });

});

const modal = (parsedData, currentUserType) => {
  let name = parsedData.schoolName ? parsedData.schoolName : parsedData.firstName + ' ' + parsedData.lastName;

  // Returns a like button if the current user is a school
  let likeButton = ( currentUserType == 'school' ) ? '<button class="like inline-flex items-center">Like </button>' : '';

  // Returns the deactivate button if the current user is an admin
  let deactivateButton = ( currentUserType != 'school' ) ? '<button data-user-id="${parsedData.ID}" class="deactivate__user__btn modal__btn" aria-label="Deactivate user">Deactivate User</button>' : '';

  if (parsedData.type == 'teacher') {
    return `<div class="modal micromodal-slide" id="profile-modal-${parsedData.ID}" aria-hidden="false">
            <div class="modal__overlay" tabindex="-1" data-micromodal-close>
              <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="profile-modal-title">
                <header class="modal__header">
                  <h3 class="modal__title" id="profile-modal-title">${name}</h3>
                  <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                </header>
                <main class="modal__content" id="profile-modal-content">
                  <div id="profile-modal-content">
                    <div class="user-profile-info">
                      <div class="mb-space-2 flex items-center">
                        <img class="user-profile-photo" src="http://subteach.local/wp-content/uploads/2021/04/default-profile-image.jpg">
                        <div class="ml-space">
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
                ${likeButton}
                </span>
              </div>
            </div>
          </div>`;
  } else {
    return `<div class="modal micromodal-slide" id="profile-modal-${parsedData.ID}" aria-hidden="false">
            <div class="modal__overlay" tabindex="-1" data-micromodal-close>
              <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="profile-modal-title">
                <header class="modal__header">
                  <h3 class="modal__title" id="profile-modal-title">${name}</h3>
                  <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                </header>
                <main class="modal__content" id="profile-modal-content">
                  <div id="profile-modal-content">
                    <div class="user-profile-info">
                      <div class="mb-space-2 flex items-center">
                        <img class="user-profile-photo" src="http://subteach.local/wp-content/uploads/2021/04/default-profile-image.jpg">
                        <div class="ml-space">
                          <p class="text-sm">[insert] Placements</p>
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
                ${deactivateButton}
              </div>
            </div>
          </div>`;
  }


}

