<?php
// Include your database connection file (conn.php)
include('conn.php');

if (isset($_POST['module_id'])) {
    $module_id = $_POST['module_id'];
    
    // Query to fetch lessons_reading data based on the selected module
    $query = "SELECT lesson_reading_id, lesson_reading_title FROM lessons_reading WHERE module_id = $module_id";
    $result = mysqli_query($conn, $query);
    $lessons_reading = array();
    
    while ($row = mysqli_fetch_assoc($result)) {
        $lessons_reading[] = $row;
    }
    
    echo json_encode($lessons_reading);
} else {
    echo json_encode([]);
}

// Close the database connection
mysqli_close($conn);
?>
