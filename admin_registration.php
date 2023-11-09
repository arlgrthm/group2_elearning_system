<?php
require './necessities/conn.php';

// Initialize variables to hold validation messages
$admin_profile_image_error = '';
$admin_full_name_error = '';
$admin_email_error = '';
$admin_username_error = '';
$admin_password_error = '';
$admin_password_confirm_error = '';
$registration_code_error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_profile_image = $_POST["profile_icon"];
    $admin_full_name = $_POST["admin_full_name"];
    $admin_email = $_POST["admin_email"];
    $admin_username = $_POST["admin_username"];
    $admin_password = $_POST["admin_password"];
    $admin_password_confirm = $_POST["admin_password_confirm"];
    $registration_code = $_POST["registration_code"];

    // Admin Full Name validation
    if (empty($admin_full_name)) {
        $admin_full_name_error = "Full Name is required";
    } elseif (!preg_match('/^[A-Za-z\s]+$/', $admin_full_name)) {
        $admin_full_name_error = "Full Name can only contain letters and spaces";
    } elseif (preg_match('/^\d/', $admin_full_name)) {
        $admin_full_name_error = "Full Name cannot start with a number";
    } elseif (preg_match('/^\W/', $admin_full_name)) {
        $admin_full_name_error = "Full name cannot start with a symbol";
    }

    // Admin Password validation
    if (empty($admin_password)) {
        $admin_password_error = "Password is required";
    } elseif (strlen($admin_password) < 8) {
        $admin_password_error = "Password must be at least 8 characters";
    } elseif (!preg_match('/[A-Z]/', $admin_password)) {
        $admin_password_error = "Password must contain at least one uppercase letter";
    } elseif (!preg_match('/[!@#\$%^&*]/', $admin_password)) {
        $admin_password_error = "Password must contain at least one symbol (e.g., !@#$%^&*)";
    }

    // Admin Username validation
    if (empty($admin_username)) {
        $admin_username_error = "Username is required";
    } elseif (strlen($admin_username) < 8) {
        $admin_username_error = "Username must be at least 8 characters";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $admin_username)) {
        $admin_username_error = "Username can only contain letters, numbers, and underscores";
    }

    // Admin Email validation
    if (empty($admin_email)) {
        $admin_email_error = "Email is required";
    } elseif (!filter_var($admin_email, FILTER_VALIDATE_EMAIL)) {
        $admin_email_error = "Email is not valid";
    }

    // Admin Password Confirmation validation
    if (empty($admin_password_confirm)) {
        $admin_password_confirm_error = "Password Confirmation is required";
    } elseif ($admin_password !== $admin_password_confirm) {
        $admin_password_confirm_error = "Password and Password Confirmation do not match";
    }

    // Check if the registration code is valid
    if ($registration_code !== 'group2k4rd4shi4ns!!') {
        $registration_code_error = "Invalid registration code. Please enter the correct code.";
    }

    // If there are no errors, proceed with registration
    if (empty($admin_profile_image_error) && empty($admin_full_name_error) && empty($admin_email_error) && empty($admin_username_error) &&
        empty($admin_password_error) && empty($admin_password_confirm_error) && empty($registration_code_error)) {
        // Hash the password
        $hashed_password = password_hash($admin_password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO admins (admin_profile_image, admin_full_name, admin_email, admin_username, password_hash, date_created)
            VALUES ('$admin_profile_image', '$admin_full_name', '$admin_email', '$admin_username', '$hashed_password', NOW())";
            
        if (mysqli_query($conn, $sql)) {
            // Registration successful
            $successMessage = 'Registration successful. You can now log in.';
        } else {
            // Registration failed
            echo "Error: " . mysqli_error($conn);
        }
    }
}
// Close the database connection
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
    <style>
        :root {
            --dark-color: black;
            --light-color: white;
            --gray-color: gray;
            /* Custom colors */
            --first-color: #001B48;
            --second-color: #02457A;
            --third-color: #018ABE;
            --fourth-color: #97CADB;
            --fifth-color: #D6E8EE;
            --navbar-active: #444;
            --prof-color: #C0C0C0;
            --border-gray: rgba(169, 169, 169, 0.5);
            --fix-box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }


        body {
            background-color: var(--second-color);
        }

        .admin-form {
            background-color: var(--light-color);
            padding: 20px;
            border-radius: 5px;
            box-shadow: var(--fix-box-shadow);
        }

        .form-header {
            text-align: center;
        }

        .form-control {
            background-color: var(--fifth-color);
            border: 1px solid var(--border-gray);
            color: var(--dark-color);
        }

        .btn-primary {
            background-color: var(--first-color);
            border: none;
        }

        .btn-primary:hover {
            background-color: var(--third-color);
        }

        .btn-secondary {
            background-color: var(--gray-color);
            border: none;
        }

        .btn-secondary:hover {
            background-color: var(--fourth-color);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3 admin-form">
                <div class="text-center">
                    <img src="Images/logo-bg.svg" alt="Your Logo" class="mb-4" style="width: 200px;">  <!-- Replace with your logo -->
                </div>

                <h2 class="form-header mb-5">Admin Registration</h2>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="selected_icon" class="form-label">Selected Profile Icon</label>
                        <div id="selected_icon" class="text-success">No icon selected</div>
                            <img id="preview_icon" src="" alt="Selected Icon" style="max-width: 150px; max-height: 150px; display: none; margin: 0 auto;">
                    </div>

                    <div class="mb-3">
                        <label for="profile_icon" class="form-label">Select Profile Icon</label>
                        <select class="form-select" id="profile_icon" name="profile_icon" onchange="showPreview()">
                            <option value="">Select One</option>
                            <option value="profile-icons/admin-icon-female.svg">Icon 1</option>
                            <option value="profile-icons/admin-icon-male.svg">Icon 2</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Enter Full Name" id="admin_full_name" name="admin_full_name" value="<?php echo isset($_POST['admin_full_name']) ? $_POST['admin_full_name'] : ''; ?>">
                        <span class="text-danger"><?php echo $admin_full_name_error; ?></span>
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" placeholder="Enter Email Address" id="admin_email" name="admin_email" value="<?php echo isset($_POST['admin_email']) ? $_POST['admin_email'] : ''; ?>">
                        <span class="text-danger"><?php echo $admin_email_error; ?></span>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Enter Username" id="admin_username" name="admin_username" value="<?php echo isset($_POST['admin_username']) ? $_POST['admin_username'] : ''; ?>">
                        <span class="text-danger"><?php echo $admin_username_error; ?></span>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" placeholder="Enter Password" id="admin_password" name="admin_password">
                        <span class="text-danger"><?php echo $admin_password_error; ?></span>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" placeholder="Confirm Password" name="admin_password_confirm">
                        <span class="text-danger"><?php echo $admin_password_confirm_error; ?></span>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" placeholder="Enter Registration Code" name="registration_code" value="">
                        <span class="text-danger"><?php echo $registration_code_error; ?></span>
                    </div>
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                        <p class="text-center mt-3">Already have an account? <a href="admin_login.php">login</a>.</p>
                </form>
            </div>
        </div>
    </div>

     <!-- Registration Success Modal -->
     <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Registration Successful</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><?php echo isset($successMessage) ? $successMessage : ''; ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="redirectToLogin()">Continue to Login</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script>
    <script>
        // show the success modal
        function showSuccessModal() {
            $('#successModal').modal('show');
        }

        //  redirect to the login page
        function redirectToLogin() {
            window.location.href = 'admin_login.php';
        }

        // Check if the registration is successful and show the modal
        <?php
        if (isset($successMessage)) {
            echo "showSuccessModal();";
        }
        ?>

        function showPreview() {
            const selectedIcon = document.getElementById('profile_icon').value;
            const previewElement = document.getElementById('preview_icon');
            const selectedIconText = document.getElementById('selected_icon');

        if (selectedIcon) {
            previewElement.src = selectedIcon;
            selectedIconText.textContent = 'Selected Icon: ';
            previewElement.style.display = 'block'; // Show the preview element
        } else {
            previewElement.src = '';
            selectedIconText.textContent = 'No icon selected';
            previewElement.style.display = 'none'; // Hide the preview element
        }
        }
    </script>

</body>
</html>
