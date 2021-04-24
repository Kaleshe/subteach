jQuery(document).ready(function ($) {

  // Gets the current user type of the logged in user
  const loggedInUserType = $(document.body).data("current-user-type");

  jQuery(".profile-card button").click(function () {

    const userID = $(this).data("user-id");
    const userType = $(this).data("user-type");

    $.ajax({
      url: display_user_profile_obj.ajaxurl,
      data: {
        'action': 'display_user_profile',
        'user_id': userID,
        'user_type': userType,
        'method': 'POST'
      },

      // Populate modal with user data
      success: function (data) {
        let parsedData = JSON.parse(data);
        $('body').append(createModal(parsedData));
        MicroModal.show('profile-modal-' + parsedData.ID);

        // Only load for school users
        if (loggedInUserType === 'school') {
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
        }

        // Only load for admin users
        if (loggedInUserType !== 'school') {
          jQuery("button.deactivate__user__btn").click(function () {
            $.ajax({
              url: deactivate_user_obj.ajaxurl,
              data: {
                'action': 'deactivate_user',
                'user_id': parsedData.ID,
                'method': 'POST'
              },

              // Alert which user was deactivated, will change later
              success: function () {
                alert(parsedData.name + ' has been deactivated.');
                MicroModal.close('profile-modal-' + parsedData.ID);
              },
              error: function (errorThrown) {
                console.log(errorThrown);
              }
            });
          });
        }
      },
      error: function (errorThrown) {
        console.log(errorThrown);
      }
    });
  });

});

function renderTextSection(props) {
  return ``;
}

function renderGridSection(props) {
  return ``;
}

function modalFromTemplate(props) {
  return `<div class="profile-modal modal micromodal-slide" id="profile-modal-${props.id}" aria-hidden="false">
            <div class="modal__overlay" tabindex="-1" data-micromodal-close>
              <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="profile-modal-title">
                <header class="modal__header">
                  <h3 class="modal__title text-lg" id="profile-modal-title">${props.name}</h3>
                  <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                </header>
                <main class="modal__content" id="profile-modal-content">
                  <div id="profile-modal-content">
                    <div class="user-profile-info">
                      <div class="mb-space-2 flex items-center">
                        <img alt="User photo" class="user-profile-photo" height="110" src="${props.image}">
                        <div class="ml-space">
                          ${renderTextSection(props)}
                        </div>
                      </div>
                      <div class="meta grid cols-2 gap text-sm">
                        ${renderGridSection(props)}
                      </div>
                    </div>
                  </div>
                </main>
                ${props.button}
                </span>
              </div>
            </div>
          </div>`;
}

function createTeacherModal(parsedData, teacherName, likeButton) {
  return `<div class="profile-modal modal micromodal-slide" id="profile-modal-${parsedData.userID}" aria-hidden="false">
            <div class="modal__overlay" tabindex="-1" data-micromodal-close>
              <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="profile-modal-title">
                <header class="modal__header">
                  <h3 class="modal__title text-lg" id="profile-modal-title">${teacherName}</h3>
                  <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                </header>
                <main class="modal__content" id="profile-modal-content">
                  <div id="profile-modal-content">
                    <div class="user-profile-info">
                      <div class="mb-space-2 flex items-center">
                        <img class="user-profile-photo" height="110" src="/wp-content/uploads/2021/04/default-profile-image.jpg">
                        <div class="ml-space">
                          <p class="font-bold cardText">${parsedData.total_placements} Placements</p>
                          <p class="font-bold cardText mt">0 Documents</p>
                        </div>
                      </div>
                      <div class="meta grid cols-2 gap text-sm">
                        <p class="email">Email</p> <p class="font-medium">${parsedData.email}</p>
                        <p class="city">City</p> <p class="font-medium">${parsedData.city}</p>
                        <p class="telephone">Telephone</p> <p class="font-medium">${parsedData.telephone}</p>
                        <p class="postcode">Postcode</p> <p class="font-medium">${parsedData.postcode}</p>
                      </div>
                    </div>
                  </div>
                </main>
                ${likeButton}
                </span>
              </div>
            </div>
          </div>`;
}

function createSchoolModal(parsedData, schoolName, priceLevel, deactivateButton) {
  return `<div class="profile-modal modal micromodal-slide" id="profile-modal-${parsedData.ID}" aria-hidden="false">
            <div class="modal__overlay" tabindex="-1" data-micromodal-close>
              <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="profile-modal-title">
                <header class="modal__header">
                  <h3 class="modal__title text-lg" id="profile-modal-title">${schoolName}</h3>
                  <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
                </header>
                <main class="modal__content" id="profile-modal-content">
                  <div id="profile-modal-content">
                    <div class="user-profile-info">
                      <div class="mb-space-2 flex items-center">
                        <img class="user-profile-photo" height="110" src="${parsedData.logo}">
                        <div class="ml-space">
                          <p style="background-color:${parsedData.primary_colour}" class="cardText text-base font-bold">${parsedData.total_placements} Placements</p>
                        </div>
                      </div>
                      <div class="meta grid cols-2 gap text-sm">
                        <p class="email">Email</p> <p class="font-medium">${parsedData.data.user_email}</p>
                        <p class="">School Name</p> <p>${schoolName}</p>
                        <p>Street Address</p><p>${parsedData.street_address}</p>
                        <p>City</p><p>${parsedData.city}</p>
                        <p class="telephone">Telephone</p> <p class="font-medium">${parsedData.telephone}</p>
                        <p class="postcode">Postcode</p> <p class="font-medium">${parsedData.postcode}</p>
                        ${priceLevel}
                        <p>Sign up date</p><p>${new Date(parsedData.data.user_registered).toDateString()}</p>
                      </div>
                    </div>
                  </div>
                </main>
                ${deactivateButton}
              </div>
            </div>
          </div>`;
}

const createModal = (parsedData, loggedInUserType) => {

  const isTeacher = parsedData.type === 'teacher';

  const id = isTeacher ? parsedData.userID : parsedData.ID;
  const name = isTeacher ? `${parsedData.firstName} ${parsedData.lastName}` : parsedData.name;
  const image = isTeacher ? "/wp-content/uploads/2021/04/default-profile-image.jpg" : parsedData.logo;
  const button = isTeacher ?
    '<button class="like inline-flex items-center">Like</button>'
    : `<button data-user-id="${parsedData.ID}" class="deactivate__user__btn modal__btn" aria-label="Deactivate user">Deactivate User</button>`;

  return modalFromTemplate({
    id: id,
    name: name,
    image: image,
    button: button
  });

  // // Returns a like button if the current user is a school
  // let likeButton = (loggedInUserType === 'school') ? '<button class="like inline-flex items-center">Like </button>' : '';
  //
  // let priceLevel = (loggedInUserType == 'admin') ? '<p class="price-level">Price Level</p> <p class="font-medium">ab 50 Lehrpersonen</p>' : '';
  //
  // // Returns the deactivate button if the current user is an admin
  // let deactivateButton = (loggedInUserType !== 'school') ? `<button data-user-id="${parsedData.ID}" class="deactivate__user__btn modal__btn" aria-label="Deactivate user">Deactivate User</button>` : '';
  //
  // if (parsedData.type === 'teacher') {
  //   let teacherName = parsedData.firstName + ' ' + parsedData.lastName;
  //   return createTeacherModal(parsedData, teacherName, likeButton);
  // } else {
  //   let schoolName = parsedData.name;
  //   return createSchoolModal(parsedData, schoolName, priceLevel, deactivateButton);
  // }
}

