<?php
/**
 * Subteach admin functions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Subteach
 */

function get_most_recent($user_type){
    global $wpdb;

    $user_id = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM user WHERE type = %s ORDER BY ID DESC LIMIT 0,1", $user_type ) );
    
    return $user_id;
}

/**
 * Return total value of app and wp users
 */
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

/**
 * Return subject level title using the level ID
 */
function get_subject_level_title($subject_level) {
    global $wpdb;

    $subject_title = $wpdb->get_var( $wpdb->prepare( "SELECT title FROM subject_levels WHERE ID = %d", $subject_level ) );
    
    return $subject_title;
}

/**
 * Return array of each subject and its ID
 */
function get_subjects() {
    global $wpdb;

    $results = $wpdb->get_results( "SELECT id, title, levelID FROM subjects" );

    return json_decode(json_encode($results), true);
}

/**
 * Return subject using its ID
*/
function get_subject( $subject_id ) {
    $subjects = get_subjects();

    foreach ( $subjects as $subject ) {
        if ( $subject['id'] == $subject_id ) {
            return $subject['title'];
        }
    }
}

/**
 * Return subject ID using its string
 */
function get_subject_id( $subject_title, $subject_level ) {
    $subjects = get_subjects();

    foreach ( $subjects as $subject ) {
        if ( mb_strtolower( $subject['title'] ) == mb_strtolower( $subject_title ) ) {
            if ( $subject_level == $subject['levelID'] ) {
                return $subject['id'];
            }
        }
    }
}

/**
 * Create an event
*/
function create_event() {
    global $wpdb;

    $user_id = get_current_user_id();
    $school_id = maybe_unserialize( get_user_meta( $user_id, 'school_id', true )[0] );

    $wpdb->insert('events', array(
    'subject_id'      => $_POST['subject_id'],
    'subjectLiteral' => get_subject( $_POST['subject_id'] ),
    'schoolID'       => $school_id,
    'note'           => $_POST['note'],
    'timestamp'      => $_POST['date'] . ' ' . $_POST['time']
    ));
}
