<?php
session_start();

if (isset($_SESSION['user_id'])) {
    $_SESSION = array();
    session_destroy();
}

// Redirect the user to the login page or any other appropriate page
header('Location: index.php');
exit();
?>