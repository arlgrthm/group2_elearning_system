<?php
session_start(); 

require_once('./necessities/conn.php'); 
$errors = array(
    'admin_username' => '',
    'admin_password' => ''
);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_username = htmlspecialchars($_POST['admin_username'], ENT_QUOTES, 'UTF-8');
    $admin_password = htmlspecialchars($_POST['admin_password'], ENT_QUOTES, 'UTF-8');

    if (empty($admin_username) || empty($admin_password)) {
        $errors['admin_username'] = "Both username and password are required.";
    } elseif (strlen($admin_username) < 5 || strlen($admin_username) > 50) {
        $errors['admin_username'] = "Username must be between 5 and 50 characters.";
    } elseif (!preg_match("/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*\W).{8,}$/", $admin_password)) {
        $errors['admin_password'] = "Password must contain at least one uppercase letter, one lowercase letter, one digit, one special character, and be at least 8 characters long.";
    } else {
        $query = "SELECT * FROM admins WHERE admin_username = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 's', $admin_username);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if ($result) {
                if (mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_assoc($result);

                    // Verify the password using password_verify
                    if (password_verify($admin_password, $row['password_hash'])) {
                        // Password is correct, set session variables and redirect to a dashboard or protected page
                        $_SESSION['admin_id'] = $row['admin_id'];
                        $_SESSION['admin_full_name'] = $row['admin_full_name']; // Add this line
                        $_SESSION['admin_username'] = $row['admin_username'];
                        header("Location: admin_dashboard.php?page=main"); // Redirect to the admin dashboard or protected page
                        exit();
                    } else {
                        $errors['admin_password'] = "Invalid password. Please try again.";
                    }
                } else {
                    $errors['admin_username'] = "Invalid username. Please try again.";
                }
            } else {
                $errors['admin_username'] = "Database error. Please try again later.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
    <style>
        :root {
            --dark-color: black;
            --light-color: white;
            --gray-color: gray;
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
                    <img src="Images/logo-bg.svg" alt="Your Logo" class="mb-4" style="width: 200px;">
                </div>
                <h2 class="form-header mb-5">Admin Login</h2>
                <form method="post">
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Admin Username" id="admin_username" name="admin_username">
                        <?php if (!empty($errors['admin_username'])) : ?>
                            <div class="text-danger"><?php echo $errors['admin_username']; ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" placeholder="Admin Password" id="admin_password" name="admin_password">
                        <?php if (!empty($errors['admin_password'])) : ?>
                            <div class="text-danger"><?php echo $errors['admin_password']; ?></div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                    <p class="text-center mt-3">If you don't have an account, <a href="admin_registration.php">register here</a>.</p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
