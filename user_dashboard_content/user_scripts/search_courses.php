<?php
require_once 'conn.php'; // Include your database connection file

// Check if a search query is provided
if (isset($_GET['query'])) {
    $searchQuery = mysqli_real_escape_string($conn, $_GET['query']);
    
    // Perform a SQL query to search for courses
    $sql = "SELECT * FROM courses WHERE course_name LIKE '%$searchQuery%' OR course_instructor LIKE '%$searchQuery%'";
    
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        $courses = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $courses[] = $row;
        }
        
        // Return the search results as JSON
        header('Content-Type: application/json');
        echo json_encode($courses);
    } else {
        // Handle database query error
        echo json_encode(array('error' => 'Database query error'));
    }
} else {
    // Handle missing search query
    echo json_encode(array('error' => 'Missing search query'));
}

// Close the database connection
mysqli_close($conn);
?>
