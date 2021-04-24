<?php

add_action('admin_post_create_event', 'create_event_response');
add_action('admin_post_nopriv_create_event', 'create_event_response');
function create_event_response()
{
//  $date = $_REQUEST['date'];
//  $time = $_REQUEST['time'];
//  [$hours,$minutes] = preg_split('/:/', $time);
//  echo '<pre>' . $date . ' ... ' . $time . ' ... ' . "Hours = ${hours}, Minutes = ${minutes}" .  '</pre>';
  create_event();
  wp_safe_redirect('/calendar');
  die();
}