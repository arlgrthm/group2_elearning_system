<?php
// Include your database connection file (conn.php)
include('conn.php');

// Get the course ID from the AJAX request
$courseId = $_POST['course_id'];

// Initialize an array to store the data
$response = [];

// Query to fetch course data by ID
$courseQuery = "SELECT * FROM courses WHERE course_id = $courseId";
$courseResult = mysqli_query($conn, $courseQuery);

if ($courseResult) {
    $courseData = mysqli_fetch_assoc($courseResult);

    // Create course data with inline style attributes
    $courseContent = '<div style="background-color: #f5f5f5; padding: 20px; border-radius: 5px;">';

    // Include the course_thumbnail image at the top
    $courseContent .= '<img src="admin_dashboard_content/admin_scripts/' . $courseData['course_thumbnail_image'] . '" alt="Course Thumbnail Image" style="max-width: 100%; height: auto; padding: 10px;">';

    $courseContent .= '<h2 style="font-size: 24px; font-weight: bold;">' . $courseData['course_name'] . '</h2>';
    $courseContent .= '<p style="font-style: italic;">Instructor: ' . $courseData['course_instructor'] . '</p>';
    $courseContent .= '<p style="font-weight: bold;">Difficulty: ' . $courseData['course_difficulty'] . '</p>';
    $courseContent .= '<p>' . $courseData['course_description'] . '</p>';

    // You can add more inline styles as needed
    $courseContent .= '</div>';

    $response['course_content'] = $courseContent;
} else {
    // Handle the case where there was an error fetching the course data
    $response['course_content'] = null;
}
// Query to fetch module data for the course
$modulesQuery = "SELECT * FROM modules WHERE course_id = $courseId"; // Filter modules by course ID
$modulesResult = mysqli_query($conn, $modulesQuery);

if ($modulesResult) {
    $modulesData = [];

    if (mysqli_num_rows($modulesResult) > 0) {
        while ($moduleRow = mysqli_fetch_assoc($modulesResult)) {
            // Fetch lessons_reading for the module
            $lessonsReadingsQuery = "SELECT lesson_reading_title FROM lessons_reading WHERE module_id = " . $moduleRow['module_id'];
            $lessonsReadingsResult = mysqli_query($conn, $lessonsReadingsQuery);

            // Fetch lessons_video for the module
            $lessonsVideoQuery = "SELECT lesson_video_title FROM lessons_video WHERE module_id = " . $moduleRow['module_id'];
            $lessonsVideoResult = mysqli_query($conn, $lessonsVideoQuery);

            // Fetch quizzes for the module
            $quizzesQuery = "SELECT quiz_name FROM quizzes_details WHERE module_id = " . $moduleRow['module_id'];
            $quizzesResult = mysqli_query($conn, $quizzesQuery);

            // Create an HTML structure for the module content
            $moduleContent = '<div style="background-color: #f5f5f5; padding: 20px; border-radius: 5px;">';
            $moduleContent .= '<h2 style="font-size: 24px; font-weight: bold;">Module ' . $moduleRow['module_title'] . '</h2>';
            $moduleContent .= '<p>' . $moduleRow['module_description'] . '</p>';

            // Add lessons_reading to the module content
            $moduleContent .= '<h4 style="font-weight: bold; color: #007BFF; font-size: 14px;">Lesson Readings:</h4>';
            if (mysqli_num_rows($lessonsReadingsResult) > 0) {
                while ($lessonRow = mysqli_fetch_assoc($lessonsReadingsResult)) {
                    $moduleContent .= '<p style="margin-left: 20px; font-size: 12px;">- ' . $lessonRow['lesson_reading_title'] . '</p>';
                }
            } else {
                $moduleContent .= '<p style="font-size: 12px;">No lesson readings available for this module.</p>';
            }

            // Add lessons_video to the module content
            $moduleContent .= '<h4 style="font-weight: bold; color: #007BFF; font-size: 14px;">Lesson Videos:</h4>';
            if (mysqli_num_rows($lessonsVideoResult) > 0) {
                while ($videoRow = mysqli_fetch_assoc($lessonsVideoResult)) {
                    $moduleContent .= '<p style="margin-left: 20px; font-size: 12px;">- ' . $videoRow['lesson_video_title'] . '</p>';
                }
            } else {
                $moduleContent .= '<p style="font-size: 12px;">No lesson videos available for this module.</p>';
            }

            // Add quizzes to the module content
            $moduleContent .= '<h4 style="font-weight: bold; color: #007BFF; font-size: 14px;">Quizzes:</h4>';
            if (mysqli_num_rows($quizzesResult) > 0) {
                while ($quizRow = mysqli_fetch_assoc($quizzesResult)) {
                    $moduleContent .= '<p style="margin-left: 20px; font-size: 12px;">- ' . $quizRow['quiz_name'] . '</p>';
                }
            } else {
                $moduleContent .= '<p style="font-size: 12px;">No quizzes available for this module.</p>';
            }

            $moduleContent .= '</div>';
            $modulesData[] = $moduleContent;
        }
    } else {
        $noModulesMessage = '<div style="text-align: center; background-color: #f5f5f5; padding: 20px; border-radius: 5px;">';
        $noModulesMessage .= '<p style="font-size: 16px; color: #007BFF;">No modules available for this course.</p>';
        $noModulesMessage .= '</div>';
        $modulesData[] = $noModulesMessage;
    }

    $response['module_content'] = $modulesData;
} else {
    // Handle the case where there was an error fetching module data
    $response['module_content'] = null;
}


// Return the course and module data as a JSON response
$response['status'] = 'success';
echo json_encode($response);

// Close the database connection
mysqli_close($conn);
?>
