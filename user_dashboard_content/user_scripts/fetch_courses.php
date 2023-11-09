<?php
// Include your existing database connection file (conn.php)
include('conn.php');

// Query to select all courses from the 'courses' table
$sql = "SELECT * FROM courses";
$result = mysqli_query($conn, $sql);
$courses = array();

// Fetch and format course data
while ($row = mysqli_fetch_assoc($result)) {
    $courses[] = array(
        'course_id' => $row['course_id'],
        'course_thumbnail_image' => $row['course_thumbnail_image'],
        'course_name' => $row['course_name'],
        'course_instructor' => $row['course_instructor'],
        'course_difficulty' => $row['course_difficulty'],
        'course_description' => $row['course_description'],
        'course_date_creation' => $row['course_date_creation']
    );
}

// Close the database connection (you may not need to do this again if you're already closing it in conn.php)
mysqli_close($conn);

// Return the courses data as JSON
header('Content-Type: application/json');
echo json_encode($courses);
?>
