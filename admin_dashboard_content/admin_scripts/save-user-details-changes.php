<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include your database connection file (conn.php)
    include('conn.php');

    $user_id = $_POST['user_id'];
    $first_name = $_POST['first_name'];
    $middle_initial = $_POST['middle_initial'];
    $suffix = $_POST['suffix'];
    $birthday = $_POST['birthday'];
    $email_address = $_POST['email_address'];
    $last_name = $_POST['last_name'];
    $address = $_POST['address'];
    $phone_number = $_POST['phone_number'];
    $username = $_POST['username'];

    // Perform the database update
    $updateQuery = "UPDATE users SET
        first_name = '$first_name',
        middle_initial = '$middle_initial',
        suffix = '$suffix',
        birthday = '$birthday',
        email_address = '$email_address',
        last_name = '$last_name',
        address = '$address',
        phone_number = '$phone_number',
        username = '$username'
        WHERE user_id = $user_id";

    if (mysqli_query($conn, $updateQuery)) {
        echo "success";
    } else {
        echo "Error updating user information: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
