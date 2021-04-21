<?php
/**
 * Subteach ajax actions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Subteach
 */

 /**
 * Get user ID to display user profile
 */
add_action( 'wp_ajax_display_user_profile', 'display_user_profile' );
add_action('wp_ajax_nopriv_display_user_profile', 'display_user_profile');

function display_user_profile() {
   // Expected data Bio, Street Address, Postcode, City, Telephone, Email, Sign Up Date
  $user_id = $_REQUEST['user_id'];
  echo json_encode( get_user( $user_id ) );
	die();
}

/**
 * 
 */
add_action( 'wp_ajax_deactivate_user', 'deactivate_user' );
add_action('wp_ajax_nopriv_deactivate_user', 'deactivate_user');

function deactivate_user() {
  $user_id = $_REQUEST['user_id'];
  update_user_meta($user_id, 'is_active', false);
  echo get_user_meta( 22 )['is_active'][0];
	die();
}