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
    $user_post = array(
        'post_title'   => get_field('name', 'user_' . $user_id), 
        'post_content' => $user_info->description,
        'post_type'    => 'school',
        'post_status'   => 'publish',
    );

    // Insert the post into the database
    $post_id = wp_insert_post( $user_post );

    // Add school custom fields
    add_post_meta( $post_id, 'post_id', $post_id );
    add_post_meta( $post_id, 'school_id', $user_info->ID );
    add_post_meta( $post_id, 'email', $user_info->user_email );
    add_post_meta( $post_id, 'school_telephone', get_field('telephone', 'user_' . $user_id) );
    add_post_meta( $post_id, 'school_city', get_field('city', 'user_' . $user_id) );
    add_post_meta( $post_id, 'school_postcode', get_field('postcode', 'user_' . $user_id) );
    add_post_meta( $post_id, 'school_address', get_field('address', 'user_' . $user_id) );
}

 /*
 * Update custom post type when user updates profile with matching ID
 */
add_action( 'profile_update', 'update_school_cpt', 10, 2 );
 
function update_school_cpt( $user_id, $old_user_data ) {

    // Get user info
    $user_info = get_userdata( $user_id );
    $meta = get_post_meta( $user_id );
    $post_id = $meta['post_id'][0];

    $user_post = array(
        'ID'           => $post_id,
        'post_title'   => get_field('name', 'user_' . $user_id), 
        'post_content' => $user_info->description,
    );

    wp_update_post( $user_post );

    update_post_meta( $post_id, 'school_id', $user_info->ID );
    update_post_meta( $post_id, 'email', $user_info->user_email );
    update_post_meta( $post_id, 'school_telephone', get_field('telephone', 'user_' . $user_id) );
    update_post_meta( $post_id, 'school_city', get_field('city', 'user_' . $user_id) );
    update_post_meta( $post_id, 'school_postcode', get_field('postcode', 'user_' . $user_id) );
    update_post_meta( $post_id, 'school_address', get_field('address', 'user_' . $user_id) );
}