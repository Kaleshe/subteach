<?php

function profileDataCard( $user_id, $user_type, $classes = null) {
    $profileImage = null;
    if ( $user_type == 'school' && get_user_meta($user_id, 'profile_image') ) {
        $profileImageID = get_user_meta($user_id)['profile_image'][0];
        $profileImage = wp_get_attachment_image_src( $profileImageID, 'medium' )[0];
    } 

    else {
        $profileImage = get_template_directory_uri() . '/img/default-profile-image.png';
    }
    ob_start();
    ?>

  <div class="profile-card card p-space text-center inline-flex flex-col items-center<?= $classes != null ? ' ' . $classes : ''; ?>">
      <img alt="Profile photo" class="user-profile-photo radius-full self-center" src=<?= $profileImage; ?>>
      <p class="text-sm font-bold mt-space"><?= esc_html( 'Cheryl' ); ?></p>
      <p class="text-xs"><?= esc_html( 'London' ); ?></p>
    <p class="text-xs mb"><?= esc_html( '0 Placements' ); ?></p>
      <button class="w-full border-rounded" data-user-type=<?= $user_type; ?> data-user-id=<?= $user_id; ?>><?php _e('View'); ?></button>
      <button class="w-full border-rounded bg-theme" data-user-type=<?= $user_type; ?> data-user-id=<?= $user_id; ?>><?php _e('Show Interest'); ?></button>
  </div>

<?php
    return ob_get_clean();
}
