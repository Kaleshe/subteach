<?php
/**
 * Subteach user functions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Subteach
 */

 function get_user_type_as_string(){
    if ( is_school() ) {
        return 'school';
    } else {
        return 'admin';
    }
 }

 /*
 * Create new custom post type post on new user registration
 */
add_action( 'user_register', 'add_user_to_school_cpt', 10, 1 );
function add_user_to_school_cpt( $user_id )
{
    // Get user info
    $user_info = get_userdata( $user_id );

    // Create a new post
    $school_post = array(
        'post_title'   => get_field('name', 'user_' . $user_id), 
        'post_content' => $user_info->description,
        'post_type'    => 'school',
        'post_status'  => 'publish',
        'post_author'  => $user_id,
    );

    // Insert the post into the database
    $school_id = wp_insert_post( $school_post );

    // Add the school ID as a meta data
    add_user_meta( $user_id, 'school_id', [$school_id] );

    // Add school custom fields
    add_post_meta( $school_id, 'email', $user_info->user_email );
    add_post_meta( $school_id, 'school_telephone', get_field('telephone', 'user_' . $user_id) );
    add_post_meta( $school_id, 'school_city', get_field('city', 'user_' . $user_id) );
    add_post_meta( $school_id, 'school_postcode', get_field('postcode', 'user_' . $user_id) );
    add_post_meta( $school_id, 'school_address', get_field('address', 'user_' . $user_id) );
}

 /*
 * Update custom post type when user updates profile with matching ID
 */
add_action( 'profile_update', 'update_school_cpt', 10, 2 );
 
function update_school_cpt( $user_id, $old_user_data ) {

    // Get user info
    $user_info = get_userdata( $user_id );

    // Get corresponding school ID
    $school_id = get_user_meta( $user_id );
    die(print_r($school_id, true));

    $school_post = array(
        'ID'           => $school_id,
        'post_title'   => get_field('name', 'user_' . $user_id), 
        'post_content' => $user_info->description,
    );

    wp_update_post( $school_post, true );

    update_post_meta( $school_id, 'email', $user_info->user_email );
    update_post_meta( $school_id, 'school_telephone', get_field('telephone', 'user_' . $user_id) );
    update_post_meta( $school_id, 'school_city', get_field('city', 'user_' . $user_id) );
    update_post_meta( $school_id, 'school_postcode', get_field('postcode', 'user_' . $user_id) );
    update_post_meta( $school_id, 'school_address', get_field('address', 'user_' . $user_id) );
}