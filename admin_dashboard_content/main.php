<?php
$adminId = $_SESSION['admin_id'];
$adminFullName = $_SESSION['admin_full_name'];
$adminUsername = $_SESSION['admin_username'];
?>
<h1 class="title">Admin Dashboard</h1>
        <main class="welcome-admindb">
            <div class="admin-header-img">
                <img src="https://cdn-icons-png.flaticon.com/512/1794/1794749.png" alt="header img" width="100">
            </div>
            <div class="header-text">
                <h3>Good Morning,  <?php echo $adminFullName; ?>!</h3>
            </div>
        </main>

        <section class="admin-db-grid">
            <div class="admin-db-items db-item1">
                <div class="db-text-contents">
                    <h4>Total Learners</h4>
                    <p>100</p>
                </div>
                <i class="fa-regular fa-id-card"></i>
            </div>
            <div class="admin-db-items db-item1">
                <div class="db-text-contents">
                    <h4>Total Courses</h4>
                    <p>100</p>
                </div>
                <i class="fa-solid fa-book-open"></i>
            </div>
            <div class="admin-db-items db-item1">
                <div class="db-text-contents">
                    <h4>Total Active Users</h4>
                    <p>100</p>
                </div>
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <div class="admin-db-items db-item1">
                <div class="db-text-contents">
                    <h4>Total Certificates Given</h4>
                    <p>100</p>
                </div>
                <i class="fa-solid fa-trophy"></i>
            </div>

            <div class="admin-db-items db-item2">
                <h4>Total Admins</h4>
                    <ul class="db-item2-list admin-list">
                        <li class="db-item2-div admin">
                            <div class="db-item2-avatar admin-avatar">
                                <img src="https://cdn-icons-png.flaticon.com/512/9619/9619263.png" alt="Admin 1">
                            </div>
                            <div class="db-item2-info admin-details">
                                <h5>Admin One</h5>
                                <p>admin1@example.com</p>
                            </div>
                        </li>
                        <li class="db-item2-div admin">
                            <div class="db-item2-avatar admin-avatar">
                                <img src="https://cdn-icons-png.flaticon.com/512/9619/9619263.png" alt="Admin 2">
                            </div>
                            <div class="db-item2-info admin-details">
                                <h5>Admin Two</h5>
                                <p>admin2@example.com</p>
                            </div>
                        </li>
                        <li class="db-item2-div admin">
                            <div class="db-item2-avatar admin-avatar">
                                <img src="https://cdn-icons-png.flaticon.com/512/9619/9619263.png" alt="Admin 3">
                            </div>
                            <div class="db-item2-info admin-details">
                                <h5>Admin Three</h5>
                                <p>admin3@example.com</p>
                            </div>
                        </li>
                    </ul>
            </div>


            <div class="admin-db-items db-item2">
                <h4>New Learners</h4>
                    <ul class="db-item2-list admin-list">
                        <li class="db-item2-div admin">
                            <div class="db-item2-avatar admin-avatar">
                                <img src="https://cdn-icons-png.flaticon.com/512/9619/9619263.png" alt="Admin 1">
                            </div>
                            <div class="db-item2-info admin-details">
                                <h5>Learner 1</h5>
                                <p>learner1@example.com</p>
                            </div>
                        </li>
                        <li class="db-item2-div admin">
                            <div class="db-item2-avatar admin-avatar">
                                <img src="https://cdn-icons-png.flaticon.com/512/9619/9619263.png" alt="Admin 2">
                            </div>
                            <div class="db-item2-info admin-details">
                                <h5>Learner 2</h5>
                                <p>learner2@example.com</p>
                            </div>
                        </li>
                        <li class="db-item2-div admin">
                            <div class="db-item2-avatar admin-avatar">
                                <img src="https://cdn-icons-png.flaticon.com/512/9619/9619263.png" alt="Admin 3">
                            </div>
                            <div class="db-item2-info admin-details">
                                <h5>Learner 3</h5>
                                <p>learner3@example.com</p>
                            </div>
                        </li>
                    </ul>
            </div>
        </section>
