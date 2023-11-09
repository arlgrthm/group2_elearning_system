<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection configuration
    include("conn.php");

    // Initialize an array to hold validation errors
    $validationErrors = array();

    // Retrieve and sanitize form data using htmlspecialchars
    $quiz_id = isset($_POST["quiz_selector"]) ? intval($_POST["quiz_selector"]) : 0;
    $question_number = isset($_POST["questionNumber"]) ? htmlspecialchars($_POST["questionNumber"], ENT_QUOTES, 'UTF-8') : '';
    $question_text = isset($_POST["questionText"]) ? htmlspecialchars($_POST["questionText"], ENT_QUOTES, 'UTF-8') : '';
    $choice_A = isset($_POST["optionA"]) ? htmlspecialchars($_POST["optionA"], ENT_QUOTES, 'UTF-8') : '';
    $choice_B = isset($_POST["optionB"]) ? htmlspecialchars($_POST["optionB"], ENT_QUOTES, 'UTF-8') : '';
    $choice_C = isset($_POST["optionC"]) ? htmlspecialchars($_POST["optionC"], ENT_QUOTES, 'UTF-8') : '';
    $choice_D = isset($_POST["optionD"]) ? htmlspecialchars($_POST["optionD"], ENT_QUOTES, 'UTF-8') : '';
    $correct_answer = isset($_POST["correctAnswer"]) ? htmlspecialchars($_POST["correctAnswer"], ENT_QUOTES, 'UTF-8') : '';

    // Validate input data
    if ($quiz_id <= 0) {
        $validationErrors[] = "Quiz selector is required and must be a valid selection.";
    }

    if (empty($question_number)) {
        $validationErrors[] = "Question number is required.";
    }

    if (empty($question_text)) {
        $validationErrors[] = "Question text is required.";
    }

    if (empty($choice_A)) {
        $validationErrors[] = "Option A is required.";
    }

    if (empty($choice_B)) {
        $validationErrors[] = "Option B is required.";
    }

    if (empty($choice_C)) {
        $validationErrors[] = "Option C is required.";
    }

    if (empty($choice_D)) {
        $validationErrors[] = "Option D is required.";
    }

    if (empty($correct_answer) || !in_array($correct_answer, ['A', 'B', 'C', 'D'])) {
        $validationErrors[] = "Correct answer is required and must be one of the available options (A, B, C, D).";
    }

    if (empty($validationErrors)) {
        // No validation errors, proceed with database insert

        $sql = "INSERT INTO quiz_questions (quiz_id, question_number, question_text, choice_A, choice_B, choice_C, choice_D, correct_answer) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssssss", $quiz_id, $question_number, $question_text, $choice_A, $choice_B, $choice_C, $choice_D, $correct_answer);

        if ($stmt->execute()) {
            $response = [
                'status' => 'success',
                'message' => 'Question added successfully!'
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

    $conn->close();
} else {
    $response = [
        'status' => 'error',
        'message' => 'Invalid request'
    ];
    echo json_encode($response);
}
?>
