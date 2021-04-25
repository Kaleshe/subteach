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
  <html><head><title>!</title></head>
<body>
  <form action="" method="get">
    <input type="hidden" name="action" value="test">
    <input type="date" name="the_date">
    <input type="submit" value="Submit">
  </form>
  <pre>Date = <?php
    /** @var date $date */
    $date = date('2020-11-02 14:00');
    if(isset($_REQUEST['the_date'])) {
      $date = $_REQUEST['the_date'];
    }
    $date = new DateTime($date);
    $date_str = strval($date);
    echo $date_str?></pre>
</body></html>
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
    if($last_search) {
      $dateTime = new DateTime($last_search->timestamp);
      $last_search->date = $dateTime->format('Y-m-d');
      $last_search->hour = $dateTime->format('G');
      $last_search->minute = $dateTime->format('i');
    }
    ?>
        <pre><?=print_r($last_search, true)?></pre>
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
  $current_user_id = get_current_user_id();


  // Check if the current teacher exists in the same row as the current school
  // Insert row to the database and set the like value to true if the row doesn't exist
  // Update like value to false if the row exists and is set to true
  // Update like value to true if the row exists and is set to false
  $wpdb->insert('liked_teachers', array(
    'teacherID' => $teacher_id,
    'schoolID' => $current_user_id,
    'like' => 'true'
  ));
  die();

}