<?php

add_action('admin_post_create_event', 'create_event_response');
add_action('admin_post_nopriv_create_event', 'create_event_response');
function create_event_response()
{
//  $date = $_REQUEST['date'];
//  $time = $_REQUEST['time'];
//  [$hours,$minutes] = preg_split('/:/', $time);
//  echo '<pre>' . $date . ' ... ' . $time . ' ... ' . "Hours = ${hours}, Minutes = ${minutes}" .  '</pre>';
  create_event();
  wp_safe_redirect('/calendar');
  die();
}

/**
 * Updates school profile
 */
add_action('admin_post_school_profile_update', 'school_profile_update');
add_action('admin_post_nopriv_school_profile_update', 'school_profile_update');
function school_profile_update() {
  $user_id = get_current_user_id();
  
  if ( !empty( $_POST['telephone']) )
    update_user_meta( $user_id, 'telephone', esc_attr( $_POST['telephone'] ) );

  if ( !empty( $_POST['email']) )
      wp_update_user( $user_id, 'user_email', esc_attr( $_POST['email'] ) );

  if ( !empty( $_POST['city']) )
      update_user_meta( $user_id, 'city', esc_attr( $_POST['city'] ) );

  if ( !empty( $_POST['postcode']) )
      update_user_meta( $user_id, 'postcode', esc_attr( $_POST['postcode'] ) );

  if ( !empty( $_POST['street_address']) )
      update_user_meta( $user_id, 'street_address', esc_attr( $_POST['street_address'] ) );

  if ( !empty( $_POST['primary_colour']) )
      update_user_meta( $user_id, 'primary_colour', esc_attr( $_POST['primary_colour'] ) );

  if ( !empty( $_POST['secondary_colour']) )
      update_user_meta( $user_id, 'secondary_colour', esc_attr( $_POST['secondary_colour'] ) );

      wp_safe_redirect('/profile');
      die;
}