<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection configuration
    include("conn.php");

    // Initialize an array to hold validation errors
    $validationErrors = array();

    // Retrieve form data
    $course_id = $_POST['course_selector'];
    $moduleTitle = isset($_POST["module_title"]) ? htmlspecialchars($_POST["module_title"], ENT_QUOTES, 'UTF-8') : '';
    $moduleOrder = isset($_POST["module_order"]) ? htmlspecialchars($_POST["module_order"], ENT_QUOTES, 'UTF-8') : '';
    $moduleDuration = isset($_POST["module_duration"]) ? htmlspecialchars($_POST["module_duration"], ENT_QUOTES, 'UTF-8') : '';
    $moduleDescription = isset($_POST["module_description"]) ? htmlspecialchars($_POST["module_description"], ENT_QUOTES, 'UTF-8') : '';

    // Handle image file upload
    $uploadDir = "course_uploads/module_thumbnail/"; // Directory where uploaded files will be stored
    $moduleThumbnail = $uploadDir . basename($_FILES["module_thumbnail"]["name"]); // Get the file name

    if (move_uploaded_file($_FILES["module_thumbnail"]["tmp_name"], $moduleThumbnail)) {
        // The file has been successfully uploaded

        // Perform data validation similar to JavaScript validation
        if ($course_id === '') {
            $validationErrors[] = "Course selector must be selected to add a module with.";
        }
        if ($moduleTitle === '' || !preg_match('/^[A-Za-z]/', $moduleTitle)) {
            $validationErrors[] = "Module title is invalid. It must not start with a number or symbol.";
        }
        if ($moduleOrder === '' || !is_numeric($moduleOrder) || $moduleOrder < 0) {
            $validationErrors[] = "Module order must not be empty and should be a non-negative number.";
        }
        if ($moduleDuration === '' || !is_numeric($moduleDuration) || $moduleDuration < 0) {
            $validationErrors[] = "Module hours duration must not be empty and should be a non-negative number.";
        }
        if ($moduleDescription === '') {
            $validationErrors[] = "Module description is required.";
        }

        if (empty($validationErrors)) {
            // Insert the data into the database
            $sql = "INSERT INTO modules (course_id, module_title, module_thumbnail_image, module_order, module_estimated_duration, module_description, module_date_creation) VALUES (?, ?, ?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $course_id, $moduleTitle, $moduleThumbnail, $moduleOrder, $moduleDuration, $moduleDescription);

            if ($stmt->execute()) {
                $response = [
                    'status' => 'success',
                    'message' => 'Module added successfully!'
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
            $response = [
                'status' => 'error',
                'message' => 'Validation errors',
                'errors' => $validationErrors
            ];
            echo json_encode($response);
        }
    } else {
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
