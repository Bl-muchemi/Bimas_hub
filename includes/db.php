<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "bimas_hub";

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: set charset (VERY IMPORTANT)
$conn->set_charset("utf8");

?>