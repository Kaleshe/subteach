<?php
/**
 * Profile Modal
 *
 * @package Subteach
 */

 // Bio, Street Address, Postcode, City, Telephone, Email, Sign Up Date

$user_id = 20;
$meta = get_user_meta( $user_id );
$data = get_userdata( $user_id )->data;
$school_name = $meta['name'][0];
$email = $data->user_email;    
$telephone = $meta['telephone'][0];
$city = $meta['city'][0];
$postcode = $meta['postcode'][0];
$address = $meta['address'][0];
$description = $meta['description'][0];
$signup_date =$data->user_registered;

$url = get_bloginfo('url');

?>

<div class="modal micromodal-slide" id="profile-modal" aria-hidden="false">
  <div class="modal__overlay" tabindex="-1" data-micromodal-close>
    <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="profile-modal-title">
      <header class="modal__header text-sm text-center">
        <h2 class="modal__title" id="profile-modal-title">
          <?= $school_name; ?>
        </h2>
        <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
      </header>
      <main class="modal__content" id="profile-modal-content">
        <div id="profile-modal-content">
        <div class="user-profile-info">
          <img class="user-profile-photo mb-space" src="<?= esc_url( get_avatar_url($user_id, array('size' => 100) ) ); ?>">
            <div class="text-sm">                            
              <div>
                <p class="description | mb-space"><?= $description ? $description : esc_html('No Description'); ?></p>

                <div class="grid cols-2 gap">
                  <p class="email">Email</p> <p class="font-medium"><?= $email ? $email : esc_html('-'); ?></p>
                  <p class="telephone">Telephone</p> <p class="font-medium"><?= $telephone ? $telephone : esc_html('-'); ?></p>
                  <p class="city">City</p> <p class="font-medium"><?= $city ? $city : esc_html('-'); ?></p>
                  <p class="postcode">Postcode</p> <p class="font-medium"><?= $postcode ? $postcode : esc_html('-'); ?></p>
                  <p class="address">Address</p> <p class="font-medium"><?= $address ? $address : esc_html('-'); ?></p>
                  <p class="signup-date">Sign Up Date</p> <p class="font-medium"><?= $signup_date; ?></p>
                </div>
              </div>
            </div>
        </div>
        </div>
      </main>
      <button class="modal__btn" data-micromodal-close aria-label="Close this dialog window">Deactivate User</button>
    </div>
  </div>
</div>