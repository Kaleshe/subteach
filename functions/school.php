<?php
/**
 * Subteach school functions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Subteach
 */

/**
 * Adds school role on init
 */
function update_school_roles() {
    if ( get_option( 'school_roles_version' ) < 1 ) {

        global $wp_roles;
        $capabilities = $wp_roles->get_role('subscriber')->capabilities;
        add_role( 'school', 'School', $capabilities );
        update_option( 'school_roles_version', 1 );
    }
}
add_action( 'init', 'update_school_roles' );

/**
 * Check if the current logged in user is a school
 */
function is_school( $user_id = null ) {
  // TODO, what happens if $user_id === null, but user is not logged in?
  //  Should return immediately on that case, maybe even throw an exception.
    if ( is_user_logged_in() && $user_id == null ) {
        $user_id = get_current_user_id();
    }

    $user_meta = get_userdata($user_id);

    if ( $user_meta ) {
        $user_roles = $user_meta->roles;
    } else {
        return false;
    }

    
    if (in_array( 'school', $user_roles )) {
        return true;
    } else {
        return false;
    }
}

/**
 * Add the is_active user_meta to registered users
 */
add_action( 'user_register', function ( $user_id ) {
    update_user_meta($user_id, 'is_active', 1);
} );

/**
 * Returns school events
 */
function get_school_events($school_id) {
    global $wpdb;

    // TODO: Check the wp_users table 
    $events = $wpdb->get_results( "SELECT * FROM events WHERE schoolID = %d", $user_id );

    return $events;
}