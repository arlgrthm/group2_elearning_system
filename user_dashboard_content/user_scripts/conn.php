<?php
// Database credentials
$db_host = 'localhost'; 
$db_user = 'arlprojects'; 
$db_pass = 'arlsimplified'; 
$db_name = 'elearning_system'; 

// Create a database connection 
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>