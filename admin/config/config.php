<?php
    $mysqli = new mysqli("localhost:3307","root","","safia-store");

    // Check connection
    if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}
