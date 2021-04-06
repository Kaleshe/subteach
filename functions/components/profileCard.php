<?php

function profileCard( $text, $user_id ) {  ?>

  <a class="card p-space text-center flex-center" href="#">
      <img class="user-profile-photo radius-full self-center" src="<?= esc_url( get_avatar($user_id) ? get_avatar_url($user_id, array('size' => 150) ) : 'http://mp.com' ); ?>">
      <p><?= $text; ?></p>
  </a>

<?php }
