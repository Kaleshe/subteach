<?php

// Create connection
$mysqli = new mysqli('localhost', 'root', 'root', 'local');

// Check connection
if ($mysqli->connect_error) {
    exit('Something weird happened');
}

$mysqli->set_charset("utf8mb4");