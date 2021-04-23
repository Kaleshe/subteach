<?php
/**
 * Subteach ajax actions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Subteach
 */

 /**
 * Display a users profile using an ID
 */
add_action( 'wp_ajax_display_user_profile', 'display_user_profile' );
add_action('wp_ajax_nopriv_display_user_profile', 'display_user_profile');

function display_user_profile() {
  $user_id = $_REQUEST['user_id'];
  $user_type = $_REQUEST['user_type'];
  // if ( $user_type != 'school' ) {
  //   $user[] = get_user_meta( $user_id );
  //   $user[] = get_userdata( $user_id );
  // }
  echo json_encode( get_user( $user_id, $user_type ) );
	die();
}

/**
 * Deactivate user
 */
add_action( 'wp_ajax_deactivate_user', 'deactivate_user' );
add_action('wp_ajax_nopriv_deactivate_user', 'deactivate_user');

function deactivate_user() {
  $user_id = $_REQUEST['user_id'];
  update_user_meta($user_id, 'is_active', 0);
  $user[] = get_user_meta( $user_id );
  $user[] = get_userdata( $user_id );
  echo json_encode($user);
	die();
}

/**
 * Like a teacher
 */
add_action( 'wp_ajax_like_teacher', 'like_teacher' );
add_action('wp_ajax_nopriv_like_teacher', 'like_teacher');

function like_teacher() {
  global $wpdb;
  $teacher_id = $_REQUEST['user_id'];
  $current_user_id = get_current_user_id();


  // Check if the current teacher exists in the same row as the current school
  // Insert row to the database and set the like value to true if the row doesn't exist
  // Update like value to false if the row exists and is set to true
  // Update like value to true if the row exists and is set to false
  $wpdb->insert('liked_teachers', array(
    'teacherID' => $teacher_id,
    'schoolID' => $current_user_id,
    'like' => 'true'
  ));
  die();
  
}