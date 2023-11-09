<?php
// Include your database connection file (conn.php)
include('conn.php');

if (isset($_POST['admin_id'])) {
    $admin_id = $_POST['admin_id'];

    // Query to fetch user details based on user ID
    $query = "SELECT * FROM admins WHERE admin_id = $admin_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);

        // Convert the user details to JSON format
        echo json_encode($admin);
    } else {
        echo "User not found";
    }
} else {
    echo "Invalid request";
}

// Close the database connection
mysqli_close($conn);
?>
