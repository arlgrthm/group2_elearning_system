<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include your database connection file (conn.php)
    include('conn.php');

    $admin_id = $_POST['admin_id'];
    $admin_full_name = $_POST["admin_full_name"];
    $admin_username = $_POST["admin_username"];
    $admin_email = $_POST["admin_email"];

    // Perform the database update
    $updateQuery = "UPDATE admins SET
        admin_full_name = '$admin_full_name',
        admin_username = '$admin_username',
        admin_email = '$admin_email'
        WHERE admin_id = $admin_id";

    if (mysqli_query($conn, $updateQuery)) {
        echo "success";
    } else {
        echo "Error updating user information: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
