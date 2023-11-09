<?php
// fetch_quiz_questions.php

// Include your database connection
require_once 'conn.php';

// Check if the quiz_id is set and it's a valid integer
if (isset($_POST['quiz_id']) && is_numeric($_POST['quiz_id'])) {
    $quizId = $_POST['quiz_id'];

    // Prepare and execute a query to fetch quiz questions based on quiz_id
    $query = "SELECT * FROM quiz_questions WHERE quiz_id = $quizId ORDER BY question_number ASC"; // Order by 'question_number' in ascending order
    $result = mysqli_query($conn, $query);

    if ($result) {
        $quizQuestions = array();

        // Fetch the quiz questions and store them in an array
        while ($row = mysqli_fetch_assoc($result)) {
            $quizQuestions[] = array(
                'quiz_questions_id' => $row['quiz_question_id'],
                'quiz_id' => $row['quiz_id'],
                'question_number' => $row['question_number'],
                'question_text' => $row['question_text'],
                'choice_A' => $row['choice_A'],
                'choice_B' => $row['choice_B'],
                'choice_C' => $row['choice_C'],
                'choice_D' => $row['choice_D'],
                'correct_answer' => $row['correct_answer']
            );
        }

        // Output the quiz questions as JSON
        header('Content-Type: application/json');
        echo json_encode($quizQuestions);
    } else {
        // Handle database query errors
        $error = 'Error fetching quiz questions';
        echo json_encode(array('error' => $error));
    }
} else {
    // Handle invalid quiz_id
    $error = 'Invalid quiz ID';
    echo json_encode(array('error' => $error));
}
?>
