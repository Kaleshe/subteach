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

/**
 * Check if the current logged in user is a school
 */
function is_school() {
    if (  is_user_logged_in() ) {
        $user_id = get_current_user_id();
        $user_meta = get_userdata($user_id);
        $user_roles = $user_meta->roles;
    
        if (in_array( 'school', $user_roles )) {
            return true;
        } else {
            return false;
        }
    }
}

function get_user_type_as_string(){
    if ( is_school() ) {
        return 'school';
    } else {
        return 'admin';
    }
 }

//  add_action( 'user_register', function ( $user_id ) {
//     update_user_meta($user_id, 'is_active',true);
// } );

// print_r(get_user_meta( 21, 'is_active'));