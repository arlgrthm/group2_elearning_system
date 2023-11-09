<?php
require 'conn.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if course ID is provided
    if (isset($_POST['course_id'])) {
        // Retrieve form data
        $course_id = $_POST['course_id'];
        $editedCourseName = $_POST['editedCourseName'];
        $editedCourseInstructor = $_POST['editedCourseInstructor'];
        $editedCourseDifficulty = $_POST['editedCourseDifficulty'];
        $editedCourseDescription = $_POST['editedCourseDescription'];
        $editedObjectives = $_POST['editedObjectives'];

        // Check if a course thumbnail is provided
        if (isset($_FILES['editedCourseThumbnail']) && $_FILES['editedCourseThumbnail']['error'] === UPLOAD_ERR_OK) {
            $editedCourseThumbnail = $_FILES['editedCourseThumbnail'];
            $thumbnailFileName = $editedCourseThumbnail['name'];

            // Move the uploaded file to a directory and update the database with the new thumbnail filename
            $uploadDirectory = 'course_uploads/course_thumbnail/"';
            move_uploaded_file($editedCourseThumbnail['tmp_name'], $uploadDirectory . $thumbnailFileName);

            // Update the database with the new course details, including the thumbnail filename
            $sql = "UPDATE courses SET
                    course_name = ?,
                    course_instructor = ?,
                    course_difficulty = ?,
                    course_description = ?,
                    objectives = ?,
                    course_thumbnail_image = ?
                    WHERE course_id = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssi", $editedCourseName, $editedCourseInstructor, $editedCourseDifficulty, $editedCourseDescription, $editedObjectives, $thumbnailFileName, $course_id);
        } else {
            // Update the database with the new course details without changing the thumbnail
            $sql = "UPDATE courses SET
                    course_name = ?,
                    course_instructor = ?,
                    course_difficulty = ?,
                    course_description = ?,
                    objectives = ?
                    WHERE course_id = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssi", $editedCourseName, $editedCourseInstructor, $editedCourseDifficulty, $editedCourseDescription, $editedObjectives, $course_id);
        }

        if ($stmt->execute()) {
            // Successful update
            echo "success";
        } else {
            // Error occurred during the database update
            echo "Database update failed: " . $stmt->error;
        }
    } else {
        // Course ID not provided
        echo "Course ID is missing.";
    }
} else {
    // Invalid request method
    echo "Invalid request method.";
}
?>
