<?php
/**
 * Subteach admin functions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Subteach
 */

 function get_most_recent($user_type){
 }

 function get_total_app_users($user_type) {

    // Connect to subteach db
    $servername = 'localhost';
    $username = 'root';
    $password = 'root';
    $dbname = 'local';

    // Create connection
    $mysqli = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id, type FROM user";
    $result = $mysqli->query($sql);
    $app_users = [];

    if (mysqli_num_rows($result) > 0) {

        // Push each user from the subteach db that matches the $user_type to $app_users
        while($row = mysqli_fetch_assoc($result)) {
            if ( $row["type"] === $user_type ) {
                array_push($app_users, $row["id"]);
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