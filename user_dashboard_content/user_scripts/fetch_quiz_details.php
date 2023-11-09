<?php
include('conn.php'); // Include your database connection script

// Query to fetch quiz data
$query = "SELECT quiz_id, quiz_name FROM quiz_details";

$result = mysqli_query($conn, $query);

$quizzes = array();

while ($row = mysqli_fetch_assoc($result)) {
    $quizzes[] = $row;
}

// Return the data as JSON
echo json_encode($quizzes);

mysqli_close($conn);
?>
