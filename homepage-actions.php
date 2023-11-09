
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iLearn</title>
    <link rel="stylesheet" href="./necessities/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="./necessities/script.js"></script>
</head>

<body>
    <!--Navigation bar-->
    <header class="navigation-bar-section">
        <section class="nav_bar">
            <div class="nav-logo">
                <img src="Images/logo-bg.svg" alt="Logo">
            </div>
            <div class="e_search">
                <input type="text" placeholder="Search...">
            </div>
            <div class="menu-navbar">
                <ul class="menu-list" id="mobile-menu">
                    <li><a href="./index.php">Home</a></li>
                    <?php
                    // Check if a user is logged in
                    if (isset($_SESSION['user_id'])) {
                        // If logged in, display "Dashboard" link
                        echo '<li><a href="./user_dashboard.php?page=main">Dashboard</a></li>';
                    } else {
                        // If not logged in, display "Sign Up" link
                        echo '<li><a href="./homepage-actions.php?signup">Sign Up</a></li>';
                    }
                    ?>
                
                    <?php
                    // Check if a user is logged in
                    if (isset($_SESSION['user_id'])) {
                        // If logged in, display "Log Out" link
                        echo '<li><a href="./logout.php">Log Out</a></li>';
                    } else {
                        // If not logged in, display "Log In" link
                        echo '<li><a href="./homepage-actions.php?login">Log In</a></li>';
                    }
                    ?>
                    <li><a href="about_us.php">About Us</a></li>
                </ul>
            </div>
            <!-- Mobile menu toggle button (hamburger) -->
            <button class="mobile-menu-toggle">&#9776;</button>
        </section>
    </header>

    <div class="dynamic-contents">
        <?php
            if (isset($_GET['login'])) {
                include('./login.php');
            }
            if (isset($_GET['signup'])) {
                include('./signup.php');
            }
        ?>
    </div>

    <!-- JavaScript for keyboard navigation -->
    <script>
        // Function to handle keyboard navigation
        function handleKeyboardNavigation(event) {
            const buttons = document.querySelectorAll('button, a'); // Select all buttons and links
            const activeElement = document.activeElement;
            const currentIndex = Array.from(buttons).indexOf(activeElement);

            if (event.key === 'ArrowDown' || event.key === 'ArrowRight') {
                // Move focus to the next button
                if (currentIndex < buttons.length - 1) {
                    buttons[currentIndex + 1].focus();
                }
            } else if (event.key === 'ArrowUp' || event.key === 'ArrowLeft') {
                // Move focus to the previous button
                if (currentIndex > 0) {
                    buttons[currentIndex - 1].focus();
                }
            }
        }

        // Add keyboard event listener
        document.addEventListener('keydown', handleKeyboardNavigation);

        // Add a specific event listener for the mobile menu toggle button
        const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
            mobileMenuToggle.addEventListener('click', () => {
            document.getElementById('mobile-menu').classList.toggle('show');
        });

    </script>
</body>
</html>