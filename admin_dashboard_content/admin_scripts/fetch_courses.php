<?php
// Include your database connection file (conn.php)
include 'conn.php';

// Fetch course data from your 'courses' table
$query = "SELECT * FROM courses";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$courses = array();

while ($row = mysqli_fetch_assoc($result)) {
    $courses[] = $row;
}

// Close the database connection
mysqli_close($conn);

// Return course data as JSON
echo json_encode($courses);
?>
