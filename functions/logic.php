<?php
/**
 * Subteach general admin and get functions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Subteach
 */

/**
 * Returns a user
 */
function get_user($user_id, $user_type)
{
  if ($user_type === 'teacher') {
    global $wpdb;

    return $wpdb->get_row($wpdb->prepare("SELECT * FROM user WHERE userID = %s", $user_id));

  } else {

    return get_user_by('ID', $user_id) ? get_user_by('ID', $user_id) : null;

  }
}

/*
 * Returns most recent user
 */
function get_most_recent_user($user_type)
{
  global $wpdb;

  if ($user_type !== 'school') {
    return $wpdb->get_row($wpdb->prepare("SELECT * FROM user WHERE type = %s ORDER BY ID DESC LIMIT 0,1", $user_type));
  } else {
    $users = get_users(array('role__in' => array('school')));

    $activeUsers = [];
    foreach ($users as $user) {
      is_active_user($user->ID) ? $activeUsers[] = $user : '';
    }

    arsort($activeUsers);

    $key = array_key_first($activeUsers);

    return $activeUsers ? $activeUsers[$key] : null;
  }
}

/**
 * Returns the id of the most recent user
 */
function get_most_recent_user_id($user_type)
{
  if ($user_type !== 'school') {
    return get_most_recent_user($user_type)->userID;
  } else {
    return get_most_recent_user($user_type)->ID;
  }
}

/**
 * Returns the current user type as a string
 */
function get_user_type_as_string($optional_id = null)
{
  $id = $optional_id === null ? get_current_user_id() : $optional_id;
  if (is_school($id)) {
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

function ratio_to_string($left, $right, $simplify_ratio = false)
{
  if ($simplify_ratio) {
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
 * Returns array of each subject and its ID
 */
function get_subjects()
{
  global $wpdb;

  $results = $wpdb->get_results("SELECT * FROM subjects");

  return json_decode(json_encode($results), true);
}

/**
 * Returns subject using its ID
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
 * Returns subject ID using its string
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
function get_last_booked_profile($user_id, $user_type)
{
  global $wpdb;
  if($user_id === null) {
    $user_id = get_current_user_id();
  }

  if(is_school($user_id)) {
    $my_column = 'schoolID';
    $other_column = 'teacherID';
    echo '<h1>Is School!</h1>';
  } else {
    $my_column = 'teacherID';
    $other_column = 'schoolID';
  }

  return $wpdb->get_var($wpdb->prepare("
    SELECT %0s
    FROM events
    WHERE %1s = %s
        AND %3s <> ''
  ", $other_column, $my_column, $user_id, $other_column));
}

/**
 * Returns users placements
 */
function get_user_total_placements($user_id, $user_type)
{
  global $wpdb;
  if ($user_type === 'school') {
    $user_id = strval($user_id);
  }
  $column_for_my_type = ['teacher' => 'teacherID', 'school' => 'schoolID'][$user_type];
  $placements = $wpdb->get_var($wpdb->prepare("
        SELECT COUNT(*)
        FROM matches
        WHERE %0s = %s
            AND schoolInterest = 'true'
            AND teacherInterest = 'true'",
    $column_for_my_type, $user_id));
  return $placements;
}

function get_last_search($user_id, $user_type)
{

  global $wpdb;

  $id_type = ['school' => 'schoolID', 'teacher' => 'teacherID'][$user_type];

  $last_search = $wpdb->get_row($wpdb->prepare("
        SELECT *
        FROM events
        WHERE %0s = %s
        ORDER BY ID DESC LIMIT 0,1
    ", $id_type, $user_id));

  if ($last_search !== null) {
    $dateTime = new DateTime($last_search->timestamp);
    $last_search->date = $dateTime->format('Y-m-d');
    $last_search->hour = $dateTime->format('G');
    $last_search->minute = $dateTime->format('i');
  }

  return $last_search;
}

/**
 * Checks if a school is active
 */
function is_active_user( $school_id = null ) {
    if (  is_user_logged_in() && $school_id == null ) {
        $school_id = get_current_user_id();
    }

    if ( (get_user_meta( $school_id, 'is_active', true)) != 0 || !is_school($school_id) ) {
        return true;
    } else {
        return false;
    }
}

/**
 * Returns a schools liked teachers
 */
function get_liked_teachers( $school_id = null ) 
{

  global $wpdb;

    if ( is_user_logged_in() && $school_id == null ) {
        $school_id = get_current_user_id();
    }

    // Need to sort out why this won't allow the variable to be fed in, but works elsewhere
    $liked_teachers = $wpdb->get_results($wpdb->prepare("SELECT * FROM liked_teachers WHERE schoolID = %d AND `like` = true", $school_id ));

  return json_decode(json_encode($liked_teachers), true);

}

/**
 * Returns total paying teachers
 */
function get_total_paying_teachers()
{
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

  $unique_id = wp_unique_id('postID_');

  if (is_school($user_id)) {
    $school_id = $user_id;
    $teacher_id = '';
  } else {
    $school_id = '';
    $teacher_id = $user_id;
  }

  // TODO: Resolve - should events.matchID be set to postID_ ?
  // Decide on utility of matches table (consult Subteach API to see what must remain).

  $wpdb->insert('events', array(
    'modify' => current_time('mysql'),
    'timestamp' => $_POST['date'] . ' ' . $_POST['time'],
    'note' => $_POST['note'],
    'subjectID' => $_POST['subjectID'],
    'subjectLiteral' => get_subject($_POST['subjectID']),
    'schoolID' => $school_id,
    'teacherID' => $teacher_id
  ));

  $date = $_REQUEST['date'];
  $time = $_REQUEST['time'];
  [$hours, $minutes] = preg_split('/:/', $time);

  // Returns the time as a literal to use to get the available teachers
  switch ($time) {
    case 'if time > 8am && time < 12pm':
      $timeLiteral = 'morning';
      break;
    case 'if time > 12 pm && time < 6pm':
      $timeLiteral = 'afternoon';
      break;
    default:
      $timeLiteral = 'whole day';
  }

  $args = array(
    'post_title' => get_subject($_POST['subjectID']),
    'post_status' => 'publish',
    'post_content' => $_POST['note'],
    'post_type' => 'tribe_events',
    'EventStartDate' => $date,
    'EventEndDate' => $date,
    'EventStartHour' => $hours,
    'EventStartMinute' => $minutes,
    'EventEndHour' => 23,
    'EventEndMinute' => 59,
    'post_author' => $user_id,
    'meta_input' => array('eventID' => $wpdb->insert_id, 'timeLiteral' => $timeLiteral)
  );

  tribe_create_event($args);

}

/**
 * Returns an array storing the ids of liked teachers
 */
function liked_teachers() {
    global $wpdb;
    $school_id = get_current_user_id();
    $teachers = $wpdb->get_results($wpdb->prepare("SELECT `teacherID` FROM `liked_teachers` WHERE `schoolID` = %s AND `like` = 'true'", $school_id));
    return $teachers ? $teachers : false;
}

liked_teachers(); 

/**
 * Returns an array storing the ids of teachers who are available
 */
function get_available_teachers($event_id) {
  assert(is_int($event_id));

  global $wpdb;
  $event = $wpdb->get_row($wpdb->prepare('SELECT * FROM events WHERE ID = %d', $event_id), OBJECT);
  if($event === null) {
    return [];
  }
  $date = (new DateTime($event->timestamp))->format('Y-m-d');
  $availableTeachers = $wpdb->get_col($wpdb->prepare("
    SELECT DISTINCT teacherID
    FROM matches
    WHERE eventID in (
        SELECT ID
        FROM events
        WHERE CONVERT(events.timestamp, DATE) <> %s)
        AND (schoolInterest <> 'true' OR teacherInterest <> 'true');
  ", $date), );
  return $availableTeachers;

//    $availableTeachers = ['05034f57-3184-485e-9c9f-b67f468c396b', '99cc8ce9-46b0-4669-a6cd-d2eb7245d799', '5b5bc55c-1c95-4aff-b6d7-da280bc105c1'];
//    return $availableTeachers ? $availableTeachers : false;
}

/**
 * Check if a teacher is liked by the current school, returns true or false
 */
function is_liked($teacher_id) {
    global $wpdb;
    $school_id = get_current_user_id();
    if ( null !== $wpdb->get_var($wpdb->prepare("SELECT `like` FROM liked_teachers WHERE schoolID = %d AND teacherID = %s AND `like` = 'true'", array($school_id, $teacher_id))) ) {
        return true;
    } else {
        return false;
    }
}


/**
 * Check if interest has been shown by the current school, returns true or false
 */
function interest_shown($teacher_id) {
  global $wpdb;
  $event_id = get_the_ID();
  $school_id = get_current_user_id();
  if ( null !== $wpdb->get_var($wpdb->prepare("SELECT `schoolInterest` FROM matches WHERE schoolID = %d AND teacherID = %s AND eventID = %d AND `schoolInterest` = 'true'", array($school_id, $teacher_id, $event_id))) ) {
      return true;
  } else {
      return false;
  }
}