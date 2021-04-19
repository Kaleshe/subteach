<?php

function profileCard( $text, $user_id, $classes = null) {
    ob_start();
    ?>

  <div class="profile-card card p-space text-center flex-center items-center<?= $classes != null ? ' ' . $classes : ''; ?>">
      <img alt="Profile avatar" class="user-profile-photo radius-full self-center" src="<?= esc_url( get_avatar($user_id) ? get_avatar_url($user_id, array('size' => 150) ) : 'http://mp.com' ); ?>">
      <button class="border-rounded" data-user-id=<?= $user_id; ?>><?= $text; ?></button>
  </div>

<?php
    return ob_get_clean();
}
