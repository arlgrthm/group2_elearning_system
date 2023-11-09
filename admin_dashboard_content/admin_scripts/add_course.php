<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection configuration
    include("conn.php");

    // Initialize an array to hold validation errors
    $validationErrors = array();

    // Retrieve and sanitize form data using htmlspecialchars
    $courseName = isset($_POST["course_name"]) ? htmlspecialchars($_POST["course_name"], ENT_QUOTES, 'UTF-8') : '';
    $courseInstructor = isset($_POST["course_instructor"]) ? htmlspecialchars($_POST["course_instructor"], ENT_QUOTES, 'UTF-8') : '';
    $courseDifficulty = isset($_POST["course_difficulty"]) ? htmlspecialchars($_POST["course_difficulty"], ENT_QUOTES, 'UTF-8') : '';
    $courseDescription = isset($_POST["course_description"]) ? htmlspecialchars($_POST["course_description"], ENT_QUOTES, 'UTF-8') : '';
    $objectives = isset($_POST["objectives"]) ? htmlspecialchars($_POST["objectives"], ENT_QUOTES, 'UTF-8') : '';

    // Handle image file upload
    $uploadDir = "course_uploads/course_thumbnail/";
    $courseThumbnail = $uploadDir . basename($_FILES["course_thumbnail"]["name"]);

    if (move_uploaded_file($_FILES["course_thumbnail"]["tmp_name"], $courseThumbnail)) {
        // The file has been successfully uploaded

        // Validate input data
        if (empty($courseName)) {
            $validationErrors[] = "Course name is required.";
        } elseif (!preg_match("/^[A-Za-z]/", $courseName)) {
            $validationErrors[] = "Course name is invalid. It must not start with a number or symbol.";
        }

        if (empty($courseInstructor)) {
            $validationErrors[] = "Course instructor is required.";
        } elseif (!preg_match("/^[A-Za-z]/", $courseInstructor)) {
            $validationErrors[] = "Course instructor is invalid. It must not start with a number or symbol.";
        }

        if (empty($courseDifficulty)) {
            $validationErrors[] = "Course difficulty is required.";
        }

        if (empty($courseDescription)) {
            $validationErrors[] = "Course description is required.";
        }

        if (empty($validationErrors)) {
            // No validation errors, proceed with database insert

            // Insert the data into the database
            $sql = "INSERT INTO courses (course_thumbnail_image, course_name, course_instructor, course_difficulty, course_description, objectives, course_date_creation) VALUES (?, ?, ?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $courseThumbnail, $courseName, $courseInstructor, $courseDifficulty, $courseDescription, $objectives);

            if ($stmt->execute()) {
                $response = [
                    'status' => 'success',
                    'message' => 'Course added successfully!'
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Error: ' . $stmt->error
                ];
            }
            echo json_encode($response);
            $stmt->close();
        } else {
            // Validation errors occurred
            $response = [
                'status' => 'error',
                'message' => 'Validation errors',
                'errors' => $validationErrors
            ];
            echo json_encode($response);
        }
    } else {
        // Error uploading the file
        $response = [
            'status' => 'error',
            'message' => 'Error uploading the file.'
        ];
        echo json_encode($response);
    }

    $conn->close();
} else {
    $response = [
        'status' => 'error',
        'message' => 'Invalid request'
    ];
    echo json_encode($response);
}
?>
