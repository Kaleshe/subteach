<?php
/**
 * Subteach school functions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Subteach
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

function is_school() {
    $user_id = get_current_user_id();
    $user_meta = get_userdata($user_id);
    $user_roles = $user_meta->roles;

    if (in_array( 'school', $user_roles )) {
        return true;
    } else {
        return false;
    }
}

/**
 * Create categories using subjects
 */