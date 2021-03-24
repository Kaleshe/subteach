<?php

// Connect to subteach db
$servername = 'localhost';
$username = 'root';
$password = 'root';
$dbname = 'local';

// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    exit('Something weird happened');
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli->set_charset("utf8mb4");