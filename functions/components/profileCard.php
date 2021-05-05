<?php

function profileCard( $text, $user_id, $user_type, $classes = null) {
    $isLiked = is_liked($user_id);

    if ( $user_type == 'school' && get_user_meta($user_id, 'profile_image') ) {
        $profileImageID = get_user_meta($user_id)['profile_image'][0];
        $profileImage = wp_get_attachment_image_src( $profileImageID, 'medium' )[0];
    } 

    else {
        $profileImage = get_template_directory_uri() . '/img/default-profile-image.png';
    }
    ob_start();
    ?>

  <div class="profile-card card p-space text-center inline-flex flex-col items-center<?= $classes != null ? ' ' . $classes : ''; ?>" data-user-id=<?= $user_id; ?> data-user-type=<?= $user_type; ?>>
      <img alt="Profile photo" class="user-profile-photo radius-full self-center" src=<?= $profileImage; ?>>
      <span class="like text-underline my-space-half text-sm font-bold" id="like-user-<?= $user_id; ?>"><?php _e( $isLiked ? 'Unlike' : '', 'subteach' ); ?></span>
      <button class="display-profile border-rounded"><?= $text; ?></button>
  </div>

<?php
    return ob_get_clean();
}
