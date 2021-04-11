<?php

function profileCard( $text, $user_id ) {  ?>

  <div class="profile-card card p-space text-center flex-center items-center">
      <img class="user-profile-photo radius-full self-center" src="<?= esc_url( get_avatar($user_id) ? get_avatar_url($user_id, array('size' => 150) ) : 'http://mp.com' ); ?>">
      <button class="border-rounded" data-user-id=<?= $user_id; ?>><?= $text; ?></button>
  </div>

<?php }
