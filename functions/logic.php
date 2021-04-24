<?php
/**
 * Subteach general admin and get functions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Subteach
 */

 /**
  * Returns a user using the user_id
  */
function get_user($user_id, $user_type)
{
    if ( $user_type != 'school') {
        global $wpdb;

        return $wpdb->get_row($wpdb->prepare("SELECT * FROM user WHERE userID = %d", $user_id));
    
    } else {
        return get_user_by( 'ID', $user_id );
    }
}

/**
 * Returns most reent user based on $user_type
 */
function get_most_recent_user($user_type)
{
    global $wpdb;

    if( $user_type != 'school' ) {
       return $wpdb->get_row($wpdb->prepare("SELECT * FROM user WHERE type = %s ORDER BY ID DESC LIMIT 0,1", $user_type));
    } else {
        $users = get_users( array( 'role__in' => array( 'school') ) );
        $activeUsers = [];
        foreach ( $users as $user ) {
            is_active_user( $user->ID ) ? $activeUsers[] = $user : '';
        }

        arsort($activeUsers);

        return empty($activeUsers) ? null :  $activeUsers[0];
    }

}

/**
 * Returns the current user type as a string
 */
function get_user_type_as_string()
{
    if (is_school()) {
        return 'school';
    } else {
        return 'admin';
    }
}

/**
 * Returns total value of app and wp users
 */
function get_total_app_users($user_type)
{
    global $wpdb;
    return $wpdb->get_var($wpdb->prepare('SELECT COUNT(*) FROM user WHERE type=%s', $user_type));
}

function ratio_to_string($left, $right, $simplify_ratio=false)
{
    if($simplify_ratio) {
        $min_value = max(min($left, $right), 0.001);
        $left = round($left / $min_value);
        $right = round($right / $min_value);
    }
    return sprintf("%d:%d", $left, $right);
}

function get_school_teacher_ratio($adjust_output = false)
{
    return ratio_to_string(get_total_schools(), get_total_teachers(), $adjust_output);
}

/**
 * Returns total schools
 */
function get_total_schools()
{
    $wp_school_total = count(get_users(array('role' => 'school')));
    $app_school_total = get_total_app_users('school');

    return $app_school_total + $wp_school_total;
}

/**
 * Returns total teachers
 */
function get_total_teachers()
{
    return get_total_app_users('teacher');
}

/**
 * Returns subject level title using the level ID
 */
function get_subject_level_title($subject_level)
{
    global $wpdb;

    $subject_title = $wpdb->get_var($wpdb->prepare("SELECT title FROM subject_levels WHERE ID = %d", $subject_level));

    return $subject_title;
}

/**
 * Return array of each subject and its ID
 */
function get_subjects()
{
    global $wpdb;

    $results = $wpdb->get_results("SELECT * FROM subjects");

    return json_decode(json_encode($results), true);
}

/**
 * Return subject using its ID
 */
function get_subject($subject_id)
{
    $subjects = get_subjects();

    foreach ($subjects as $subject) {
        if ($subject['ID'] == $subject_id) {
            return $subject['title'];
        }
    }

    // Could throw an exception instead
    return null;
}

/**
 * Return subject ID using its string
 */
function get_subject_id($subject_title, $subject_level)
{
    $subjects = get_subjects();

    foreach ($subjects as $subject) {
        if (mb_strtolower($subject['title']) == mb_strtolower($subject_title)) {
            if ($subject_level == $subject['levelID']) {
                return $subject['id'];
            }
        }
    }

    // Could throw exception instead.
    return null;
}

/**
 * Returns last booked profile by current user
 */
function get_last_booked_profile()
{
    global $wpdb;

    $user_id = get_current_user_id();
    
    return $wpdb->get_var($wpdb->prepare('SELECT teacherID FROM events WHERE schoolID = %d,'));
    return $wpdb->get_row($wpdb->prepare("SELECT * FROM user WHERE type = %s ORDER BY ID DESC LIMIT 0,1", $user_type));
}

function get_user_total_placements()
{
    return '0';
}

/**
 * Checks if a user is active
 */
function is_active_user( $user_id = null ) {
    if (  is_user_logged_in() && $user_id == null ) {
        $user_id = get_current_user_id();
    }

    if ( (get_user_meta( $user_id, 'is_active', true)) != 0 || !is_school($user_id)) {
        return true;
    } else {
        return false;
    }
}

/**
 * Returns a schools liked teachers
 */
function get_liked_teachers( $user_id = null ) 
{

    global $wpdb;

    if ( is_user_logged_in() && $user_id == null ) {
        $user_id = get_current_user_id();
    }
    
    // Need to sort out why this won't allow the variable to be fed in, but works elsewhere
    $liked_teachers = $wpdb->get_results( "SELECT * FROM liked_teachers WHERE schoolID = %d", $user_id );

    return json_decode(json_encode($liked_teachers), true);

}

/**
 * Returns total paying members
 */
function get_total_paying_teachers() {
    global $wpdb;
    return $wpdb->get_var('SELECT COUNT(*) FROM user WHERE priceID >= 1');
}

/**
 * Adds a new event to the database and create a tribe events post simutaneously
 */
function create_event()
{
    global $wpdb;

    $user_id = get_current_user_id();

    $wpdb->insert('events', array(
        'subjectID' => $_POST['subjectID'],
        'subjectLiteral' => get_subject($_POST['subjectID']),
        'schoolID' => $user_id,
        'note' => $_POST['note'],
        'timestamp' => $_POST['date'] . ' ' . $_POST['time']
    ));

    $args = array(
        'post_title' => get_subject($_POST['subjectID']),
        'post_status' => 'publish',
        'post_content' => $_POST['note'],
        'post_type' => 'tribe_events',
        'EventStartDate' => date( $_POST['date'] ),
        'EventEndDate' => $_POST['date'],
        'post_author'  => $user_id
    );

    tribe_create_event($args);

}

/**
 * 
 */

function liked_profiles() {
    $profiles = [27, 32];
    return $profiles ? $profiles : false;
}