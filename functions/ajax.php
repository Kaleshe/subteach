<?php
/**
 * Subteach ajax actions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Subteach
 */

add_action('wp_ajax_test', 'ajax_test');
add_action('wp_ajax_nopriv_test', 'ajax_test');
function ajax_test()
{
  ?>
    <!DOCTYPE html>
    <html>
    <head><title>!</title></head>
    <body>
    <form action="" method="get">
        <input type="hidden" name="action" value="test">
        <input type="date" name="the_date">
        <input type="submit" value="Submit">
    </form>
    <pre>Date = <?php
      /** @var date $date */
      $date = date('2020-11-02 14:00');
      if (isset($_REQUEST['the_date'])) {
        $date = $_REQUEST['the_date'];
      }
      $date = new DateTime($date);
      $date_str = strval($date);
      echo $date_str ?></pre>
    </body>
    </html>
  <?php
  die();
}

add_action('wp_ajax_test_available_teachers', 'test_available_teachers');
add_action('wp_ajax_nopriv_test_available_teachers', 'test_available_teachers');
function test_available_teachers ()
{
    $event_id = 314;
    $available = join('<br>', get_available_teachers($event_id));
    echo "<h1>Available</h1><pre>$available</pre>";
    die();
}

add_action('wp_ajax_test_last_booked', 'test_last_booked');
add_action('wp_ajax_noprov_test_last_booked', 'test_last_booked');
function test_last_booked()
{
  $id = 38;
  $user_type = 'school';
  $result = get_last_booked_profile($id, $user_type);
  ?>
    <pre>Last booked = <?= print_r($result, true) ?></pre>
  <?php
  die();
}

add_action('wp_ajax_last_search', 'ajax_last_search');
add_action('wp_ajax_noprov_last_search', 'ajax_last_search');
function ajax_last_search()
{
  $id = $_REQUEST['ID'];
  $user_type = $_REQUEST['user_type'];
  $last_search = get_last_search($id, $user_type);
  ?>
    <pre><?= print_r($last_search, true) ?></pre>
  <?php
  die();
}

/**
 * Display a users profile using an ID
 */
add_action('wp_ajax_display_user_profile', 'display_user_profile');
add_action('wp_ajax_nopriv_display_user_profile', 'display_user_profile');

function filter_array($array)
{
  return array_filter($array, function ($value, $key) {
    return !in_array($key, ['comment_shortcuts', 'user_pass']);
  }, ARRAY_FILTER_USE_BOTH);
}

function display_user_profile()
{

  $user_id = $_REQUEST['user_id'];
  $user_type = $_REQUEST['user_type'];

  $user = (array)get_user($user_id, $user_type);
  if ($user_type === 'school') {
    $user = array_merge($user, (array)get_user_meta($user_id));
    $user = array_merge($user, (array)get_userdata($user_id));
    $user['logo'] = wp_get_original_image_url($user['profile_image'][0]) ? wp_get_original_image_url($user['profile_image'][0]) : get_template_directory_uri() . '/img/default-profile-image.png';
    $user['data'] = filter_array((array)$user['data']);
  }
  $user['total_placements'] = get_user_total_placements($user_id, $user_type);

  $user['__params__'] = ['user_id' => $user_id, 'type' => $user_type];
  $user = filter_array($user);
  echo json_encode($user);
  die();
}

/**
 * Deactivate user
 */
add_action('wp_ajax_deactivate_user', 'deactivate_user');
add_action('wp_ajax_nopriv_deactivate_user', 'deactivate_user');
function deactivate_user()
{
  $user_id = $_REQUEST['user_id'];
  update_user_meta($user_id, 'is_active', 0);
  $user[] = get_user_meta($user_id);
  $user[] = get_userdata($user_id);
  echo json_encode($user);
  die();
}

/**
 * Like a teacher
 */
add_action('wp_ajax_like_teacher', 'like_teacher');
add_action('wp_ajax_nopriv_like_teacher', 'like_teacher');
function like_teacher()
{
  global $wpdb;
  $teacher_id = $_REQUEST['user_id'];
  $school_id = get_current_user_id();
  
  if ( null !== $wpdb->get_row($wpdb->prepare("SELECT * FROM liked_teachers WHERE schoolID = %d AND teacherID = %s", array($school_id, $teacher_id))) ) {
    $isLiked = is_liked($teacher_id);
    $wpdb->update('liked_teachers', array(
      'like' => $isLiked ? 'false' : 'true'
    ), array(
      'schoolID' => $school_id,
      'teacherID' => $teacher_id
    ));
    echo('Liked');
  } else {

    // Inserts a new row if a user hasn't been liked before
    $wpdb->insert('liked_teachers', array(
      'teacherID' => $teacher_id,
      'schoolID' => $school_id,
      'like' => 'true'
    ));
    echo('Like row added'); 
  }

  die();

}

/**
 * Show interest
 */
add_action('wp_ajax_show_interest', 'show_interest');
add_action('wp_ajax_nopriv_show_interest', 'show_interest');
function show_interest() {
  $event_id = $_REQUEST['event_id'];
  $teacher_id = $_REQUEST['user_id'];
  $school_id = get_current_user_id();

  if ( !interest_shown($teacher_id) ) {
    global $wpdb;

    $wpdb->insert('matches', array(
      'teacherID' => $teacher_id,
      'schoolID' => $school_id,
      'eventID' => $event_id,
      'schoolInterest' => 'true',
      'modify' => current_time('mysql')
    ));

    echo $teacher_id;
  }
}