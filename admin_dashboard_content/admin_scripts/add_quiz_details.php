<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection configuration
    include("conn.php");

    // Retrieve form data
    $course_id = $_POST["course_selection_for_quiz"];
    $quizName = $_POST["quizName"];
    $quizInstructions = $_POST["quizInstructions"];
    $passingScore = $_POST["passingScore"];


    // Initialize an array to store error messages
    $validationErrors = array();

    // Course Selector validation
    if (empty($course_id)) {
        $validationErrors[] = "Select a course is required.";
    }

    // Quiz Name validation
    if (empty($quizName)) {
        $validationErrors[] = "Quiz name is required.";
    }

    // Quiz Instructions validation
    if (empty($quizInstructions)) {
        $validationErrors[] = "Quiz instructions are required.";
    }

    // Validate Passing Score
    if (empty($passingScore) || !is_numeric($passingScore)) {
         $validationErrors[] = "Passing score is required and must be a number.";
    }

    // Check if there are any error messages
    if (!empty($validationErrors)) {
        $response = [
            'status' => 'error',
            'messages' => $validationErrors
        ];
    } else {
        // All validations passed, proceed with database insertion
        $quizName = mysqli_real_escape_string($conn, $quizName);
        $quizInstructions = mysqli_real_escape_string($conn, $quizInstructions);
        $passingScore = (int)$passingScore;

            // Insert the quiz details into the database, including Passing Score
            $sql = "INSERT INTO quiz_details (course_id, quiz_name, quiz_instructions, passing_score) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isss", $course_id, $quizName, $quizInstructions, $passingScore);



        if ($stmt->execute()) {
            $response = [
                'status' => 'success',
                'message' => 'Quiz details added successfully!'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Error: ' . $stmt->error
            ];
        }

        $stmt->close();
    }

    echo json_encode($response);
} else {
    $response = [
        'status' => 'error',
        'message' => 'Invalid request'
    ];
    echo json_encode($response);
}
?>
