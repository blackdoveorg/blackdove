<?php
$servername = "localhost";
$username = "mdciubal_civics";
$password = "looserser1";
$database = "mdciubal_civics";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>