<?php
/**
 * Subteach admin functions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Subteach
 */

 function get_most_recent($user_type){
 }

 function get_total_app_users($user_type) {

    global $wpdb;

    $results = $wpdb->get_results( "SELECT id, type FROM user" );
    $app_users = [];

    if ( $results ) {

        foreach ( $results as $result ) {
            if ( $result->type === $user_type ) {

                // Push each user from the subteach db that matches the $user_type to $app_users
                array_push($app_users, $result->id);
            }
        }
    }

    return count($app_users);

 }

 function get_total_schools() {
     $wp_school_total = count( get_users( array( 'role' => 'school' ) ) );
     $app_school_total = get_total_app_users('school');

     return $app_school_total + $wp_school_total;
 }

 function get_total_teachers() {
     return get_total_app_users('teacher');
 }

 function get_last_booked_profile() {
     
 }

 function get_user_total_placements( ) {

 }

 function get_subjects() {
    global $wpdb;
    
    $results = $wpdb->get_results( "SELECT id, title FROM subjects" );

    return json_decode(json_encode($results), true);
 }

 /**
  * Redirect user to homepage after succesful login
  */
 function wpum_custom_redirect_to_homepage( $url ) {
    return home_url();
}
add_filter( 'wpum_get_login_redirect', 'wpum_custom_redirect_to_homepage' );