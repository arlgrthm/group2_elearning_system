<?php
session_start(); 

require_once('./necessities/conn.php'); 
$errors = array(
    'username' => '', 
    'password' => ''
);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');

    if (empty($username) || empty($password)) {
        $errors['username'] = "Both username and password are required.";
    } elseif (strlen($username) < 5 || strlen($username) > 50) {
        $errors['username'] = "Username must be between 5 and 50 characters.";
    } else {
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 's', $username);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if ($result) {
                if (mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_assoc($result);

                    // Verify the password using password_verify
                    if (password_verify($password, $row['password_hash'])) {
                        $_SESSION['user_id'] = $row['user_id'];
                        $_SESSION['first_name'] = $row['first_name'];
                        $_SESSION['last_name'] = $row['last_name'];
                        $_SESSION['username'] = $row['username'];
                        header("Location: user_dashboard.php?page=main");
                        exit();
                    } else {
                        $errors['password'] = "Invalid password. Please try again.";
                    }
                } else {
                    $errors['username'] = "Invalid username. Please try again.";
                }
            } else {
                $errors['username'] = "Database error. Please try again later.";
            }
        }
    }
}
?>


<!-- User Login Form -->
<div class="login-container">
    <div class="login-section">
        <div class="form-header">
            <h2>Start Your Journey!</h2>
        </div>
        <div class="login-form">
            <form action="" method="post">
                <div class="form-group login-form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="login-form-control" id="username" name="username"
                        placeholder="Enter your username">
                    <div class="error-message" id="username-error">
                        <?php echo $errors['username']; ?>
                    </div>
                </div>
                <div class="form-group login-form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="login-form-control" id="password" name="password"
                        placeholder="Enter your password">
                    <div class="error-message" id="password-error">
                        <?php echo $errors['password']; ?>
                    </div>
                </div>
                <button class="login-button" type="submit">Log In</button>
                <div class="form-link">
                    Don't have an account? <a href="./homepage-actions.php?signup">Sign Up</a>
                </div>
            </form>
        </div>
    </div>
</div>




