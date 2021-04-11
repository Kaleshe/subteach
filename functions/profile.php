<?php
/**
 * Subteach profile functions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Subteach
 */

 /**
 * Handle AJAX request
 */
add_action( 'wp_ajax_load_user_profile', 'load_user_profile' );
add_action('wp_ajax_nopriv_load_user_profile', 'load_user_profile');

function load_user_profile() {
   // Bio, Street Address, Postcode, City, Telephone, Email, Sign Up Date
  $user_id = $_REQUEST['user_id'];
  echo json_encode( get_user( $user_id ) );
	die();
}

// // For wp_users
// // $meta = get_user_meta( $user_id );
// // $data = get_userdata( $user_id )->data;
// // $school_name = $meta['name'][0];
// // $email = $data->user_email;    
// // $telephone = $meta['telephone'][0];
// // $city = $meta['city'][0];
// // $postcode = $meta['postcode'][0];
// // $address = $meta['address'][0];
// // $description = $meta['description'][0];
// // $signup_date =$data->user_registered;

// $profileImage = get_avatar_url($user_id, array('size' => 100) ) ? get_avatar_url($user_id, array('size' => 100) ) : get_template_directory_uri() . '/img/default-profile-image.png';

