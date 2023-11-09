<?php
include('./necessities/conn.php');

// ----------------------------------------------------------------
// Variables
$profile_image = $first_name = $middle_initial = $last_name = $suffix = $birthday = $address = $phone_number = $email_address = $username = $password = $password_confirm = $accept_terms = '';
$profile_image_error = $first_name_error = $middle_initial_error = $last_name_error = $suffix_error = $birthday_error = $address_error = $phone_number_error = $email_address_error = $username_error = $password_error = $password_confirm_error = $accept_terms_error = '';
$has_errors = false;

// Process the form when it's submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $profile_image = trim(htmlspecialchars($_POST['profile_icon']));
    $first_name = trim(htmlspecialchars($_POST['first_name']));
    $middle_initial = trim(htmlspecialchars($_POST['middle_initial']));
    $last_name = trim(htmlspecialchars($_POST['last_name']));
    $suffix = $_POST['suffix'];
    $birthday = $_POST['birthday'];
    $address = trim(htmlspecialchars($_POST['address']));
    $phone_number = trim(htmlspecialchars($_POST['phone_number']));
    $email_address = trim(htmlspecialchars($_POST['email_address']));
    $username = trim(htmlspecialchars($_POST['username']));
    $password = $_POST['password'];
    $password_confirm = $_POST['password-confirm'];
    $accept_terms = isset($_POST['accept_terms']) ? 1 : 0;

    // Server Side Validations
    // Admin Profile Image validation
    if (empty($admin_profile_image)) {
        $admin_profile_image_error = "Profile Image is required";
    }
    
    // Validate First Name if it's empty or contains numbers
    if (empty($first_name)) {
        $first_name_error = 'First name is required.';
    } elseif (!preg_match("/^[a-zA-Z]+$/", $first_name)) {
        $first_name_error = 'First name must not contain numbers.';
    }

    // Validate Middle Initial if it's not a single letter or contains numbers
    if (strlen($middle_initial) !== 0 && strlen($middle_initial) !== 2) {
        $middle_initial_error = 'Middle initial must be a single letter and a period.';
    } else {
        $middle_initial_error = ''; //
    }

    // Validate Last Name if it's empty or contains numbers
    if (empty($last_name)) {
        $last_name_error = 'Last name is required.';
    } elseif (!preg_match("/^[a-zA-Z]+$/", $last_name)) {
        $last_name_error = 'Last name must not contain numbers.';
    }

    // Validate Birthday if it's empty or the user is below 13 years old
    $today = new DateTime();
    $dob = new DateTime($birthday);
    $minAge = 13;
    if (empty($birthday)) {
        $birthday_error = 'Birthday is required.';
    } elseif ($today->diff($dob)->y < $minAge) {
        $birthday_error = 'You must be at least 13 years old to sign up.';
    }

    // Validate Address if it's empty
    if (empty($address)) {
        $address_error = 'Address is required.';
    }

    // Validate Phone Number if it's empty or doesn't follow the format
    if (empty($phone_number)) {
        $phone_number_error = "Phone number is required.";
    } elseif (!preg_match("/^09\d{9}$/", $phone_number)) {
        $phone_number_error = 'Please follow the format (09xxxxxxxxx)';
    }

    // Validate Email Address if it's empty or doesn't follow the format
    if (empty($email_address)) {
        $email_address_error = 'Email address is required.';
    } elseif (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
        $email_address_error = 'Invalid email address format.';
    }

    // Validate Username if it's empty or lower than 6
    if (empty($username)) {
        $username_error = 'Username is required.';
    } elseif (strlen($username) < 6) {
        $username_error = 'Username must have at least 6 characters.';
    }

    // Validate Password does not match with Password Confirm
    if ($password !== $password_confirm) {
        $password_confirm_error = 'Passwords do not match.';
    } else {
        $password_confirm_error = '';
    }

    // Validate Password if it's empty, lower than 8, and does not meet the criteria
    if (empty($password)) {
        $password_error = 'Password is required.';
    } elseif (strlen($password) < 8 || !preg_match("/[0-9]/", $password) || !preg_match("/[A-Z]/", $password) || !preg_match("/[!@#$%^&*]/", $password)) {
        $password_error = 'Password must have at least 8 characters and contain one number, one uppercase letter, and one symbol (!@#$%^&*).';
    }

    // Validate if email address is already taken
    $email_check_query = "SELECT COUNT(*) FROM users WHERE email_address = ?";
    $stmt = $conn->prepare($email_check_query);
    $stmt->bind_param("s", $email_address);
    $stmt->execute();
    $stmt->bind_result($email_count);
    $stmt->fetch();
    $stmt->close();

    // if true, email address is already taken
    if ($email_count > 0) {
        $email_address_error = 'Email address is already taken.';
    }

    // Validate if phone number is already taken
    $phone_check_query = "SELECT COUNT(*) FROM users WHERE phone_number = ?";
    $stmt = $conn->prepare($phone_check_query);
    $stmt->bind_param("s", $phone_number);
    $stmt->execute();
    $stmt->bind_result($phone_count);
    $stmt->fetch();
    $stmt->close();

    // if true, phone number is already taken
    if ($phone_count > 0) {
        $phone_number_error = 'Phone number is already taken.';
    }

    // Validate if username is already taken
    $username_check_query = "SELECT COUNT(*) FROM users WHERE username = ?";
    $stmt = $conn->prepare($username_check_query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($username_count);
    $stmt->fetch();
    $stmt->close();

    // if true, username is already taken
    if ($username_count > 0) {
        $username_error = 'Username is already taken.';
    }

    // Validate Terms and Conditions
    if (!$accept_terms) {
        $accept_terms_error = 'You must accept the terms and conditions to sign up.';
    }

    // Check if there are any errors 
    if (
        !empty($first_name_error) ||
        !empty($middle_initial_error) ||
        !empty($last_name_error) ||
        !empty($suffix_error) ||
        !empty($birthday_error) ||
        !empty($address_error) ||
        !empty($phone_number_error) ||
        !empty($email_address_error) ||
        !empty($username_error) ||
        !empty($password_error) ||
        !empty($password_confirm_error) ||
        !empty($accept_terms_error)
    ) {
        $has_errors = true;
    }

    // If there are no errors, insert the data into the database
    if (!$has_errors) {
        // Hash the password
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        // Insert the data into the database 'users' table
        $stmt = $conn->prepare("INSERT INTO users (profile_image, first_name, middle_initial, last_name, suffix, birthday, address, phone_number, email_address, username, password_hash, terms_accepted, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("sssssssssssi", $profile_image, $first_name, $middle_initial, $last_name, $suffix, $birthday, $address, $phone_number, $email_address, $username, $password_hash, $accept_terms);

        if ($stmt->execute()) {
            // Registration successful
            $successMessage = 'Registration successful. You can now log in.';
        } else {
            // Handle database insertion error
            $errors['db_error'] = 'An error occurred while registering. Please try again later.';
        }
    }
}
?>

<!-- Registration form -->
<div class="signup-container">
    <div class="form-header">
        <h2>Create an Account</h2>
    </div>
    <div class="signup-section">
    <form action="" method="post" id="signup-form" enctype="multipart/form-data">

        <div class="profile-image">
            <label for="profile-icon" class="profile-image-label">Profile Icon:</label>
            <img id="preview-icon-image" src="profile-icons/default-icon.svg" alt="Selected Profile Icon">
            <div class="profile-dropdown">
                <select id="profile-icon" name="profile_icon" onchange="updateProfileImagePreview()">
                    <option value="profile-icons/default-icon.svg">Select a profile icon</option>
                    <option value="profile-icons/boy-icon1.svg">Icon 1</option>
                    <option value="profile-icons/boy-icon2.svg">Icon 2</option>
                    <option value="profile-icons/girl-icon1.svg">Icon 3</option>
                    <option value="profile-icons/girl-icon2.svg">Icon 4</option>
                </select>   
            </div>
        </div>

            <div class="signup-form-row">
                <!-- First Name -->
                <div class="signup-form-group">
                    <label for="first-name">First Name:</label>
                    <input type="text" id="first-name" name="first_name" placeholder="Enter your first name"
                        value="<?php echo htmlspecialchars($first_name); ?>">
                    <span class="error-message">
                        <?php echo $first_name_error; ?>
                    </span>
                </div>

                <!-- Middle Initial -->
                <div class="signup-form-group">
                    <label for="middle-initial">Middle Initial:</label>
                    <input type="text" id="middle-initial" name="middle_initial" placeholder="Enter your middle initial"
                        value="<?php echo htmlspecialchars($middle_initial); ?>">
                    <span class="error-message">
                        <?php echo $middle_initial_error; ?>
                    </span>
                </div>

                <!-- Last Name -->
                <div class="signup-form-group">
                    <label for="last-name">Last Name:</label>
                    <input type="text" id="last-name" name="last_name" placeholder="Enter your last name"
                        value="<?php echo htmlspecialchars($last_name); ?>">
                    <span class="error-message">
                        <?php echo $last_name_error; ?>
                    </span>
                </div>

                <!-- Suffix -->
                <div class="signup-form-group">
                    <label for="suffix">Suffix:</label>
                    <select id="suffix" name="suffix">
                        <option value="">None</option>
                        <option value="Jr.">Jr.</option>
                        <option value="Sr.">Sr.</option>
                        <option value="II">II</option>
                        <option value="III">III</option>
                    </select>
                </div>
            </div>

            <div class="signup-form-row">
                <!-- Birthday -->
                <div class="signup-form-group">
                    <label for="bi
                    rthday">Birthday:</label>
                    <input type="date" id="birthday" placeholder="Enter your birthday" name="birthday"
                        value="<?php echo htmlspecialchars($birthday); ?>">
                    <span class="error-message">
                        <?php echo $birthday_error; ?>
                    </span>
                </div>

                <!-- Address -->
                <div class="signup-form-group">
                    <label for="address">Address:</label>
                    <textarea id="address" placeholder="Enter your address"
                        name="address"><?php echo htmlspecialchars($address); ?></textarea>
                    <span class="error-message">
                        <?php echo $address_error; ?>
                    </span>
                </div>
            </div>
            
            <div class="signup-form-row">
                <!-- Phone Number -->
                <div class="signup-form-group">
                    <label for="phone-number">Phone Number:</label>
                    <div class="phone-input-container">
                        <span class="plus-sign">+63</span>
                        <input type="text" id="phone-number" placeholder="Enter your phone number" name="phone_number"
                            value="<?php echo htmlspecialchars($phone_number); ?>">
                    </div>
                    <span class="error-message">
                        <?php echo $phone_number_error; ?>
                    </span>
                </div>

                <!-- Email Address -->
                <div class="signup-form-group">
                    <label for="email-address">Email Address:</label>
                    <input type="email" id="email-address" placeholder="Enter your email address" name="email_address"
                        value="<?php echo htmlspecialchars($email_address); ?>">
                    <span class="error-message">
                        <?php echo $email_address_error; ?>
                    </span>
                </div>
            </div>

            <div class="signup-form-row">
                <!-- Username -->
                <div class="signup-form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" placeholder="Enter your username" name="username"
                        value="<?php echo htmlspecialchars($username); ?>">
                    <span class="error-message">
                        <?php echo $username_error; ?>
                    </span>
                </div>

                <div class="signup-form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password">
                    <span class="error-message">
                        <?php echo $password_error; ?>
                    </span>
                </div>

                <div class="signup-form-group">
                    <label for="password-confirm">Confirm Password:</label>
                    <input type="password" id="password-confirm" name="password-confirm"
                        placeholder="Confirm your password">
                    <span class="error-message">
                        <?php echo $password_confirm_error; ?>
                    </span>
                </div>
            </div>

            <!-- Terms and Conditions -->
            <div class="terms-and-conditions">
                <p>Please read and accept our terms and conditions before signing up.</p>
                <label for="accept-terms">
                    <input type="checkbox" id="accept-terms" name="accept_terms">
                    I accept the <a href="#">Terms and Conditions</a>
                </label>
                <span class="error-message" id="acceptterms">
                    <?php echo $accept_terms_error; ?>
                </span>
            </div>

            <!-- Sign Up Button -->
            <button class="signup-button" type="submit">Sign up Now!</button>
        </form>

        <div class="form-link">
            <p>If you already have an account, <a href="./homepage-actions.php?login">Log In</a></p>
        </div>

      </div>
    </div>

    <div id="myModal" class="success-signup-modal">
        <div class="success-signup-modal-content">
            <span class="signup-modal-close" onclick="closeModal()">&times;</span>
            <p id="modal-message"></p>
            <button onclick="proceedToLogin()">Proceed to Login</button>
        </div>
    </div>


    <script>
        // JavaScript function to show the modal
        function showModal(message) {
            var modal = document.getElementById("myModal");
            var modalMessage = document.getElementById("modal-message");

            modalMessage.innerHTML = message;
            modal.style.display = "block";
        }

        // JavaScript function to close the modal
        function closeModal() {
            var modal = document.getElementById("myModal");
            modal.style.display = "none";
        }

        // JavaScript function to handle the "Proceed to Login" button click
        function proceedToLogin() {
            // Redirect the user to the login page or perform any other necessary action
            window.location.href = "homepage-actions.php?login";
        }


        function updateProfileImagePreview() {
            var select = document.getElementById("profile-icon");
            var preview = document.getElementById("preview-icon-image");
            var selectedOption = select.options[select.selectedIndex];
            var imageURL = selectedOption.value;

            // Set the source of the preview image
            preview.src = imageURL;
        }

        <?php
        if (isset($successMessage)) {
            // Display the success message in the modal
            echo 'showModal("' . $successMessage . '");';
        }
        ?>
    </script>
