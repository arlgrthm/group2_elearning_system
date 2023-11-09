<?php
                // Include your database connection file (conn.php)
                include('conn.php');
                
                // Get the user_id from the POST request
                $admin_id = $_POST['admin_id'];

                // Query to fetch user details
                $query = "SELECT admin_id, admin_profile_image, admin_full_name, admin_username, admin_email, date_created FROM admins WHERE admin_id = $admin_id";
                $result = mysqli_query($conn, $query);


                // Check if there are any results
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $created_at = date("F j, Y g:i A", strtotime($row['date_created']));

                    echo '<h5 class="admin_id_clicked">Admin ID: <span id="view-admin-id">' . $row['admin_id'] . '</span></h5>';
                    echo '<img src="' . $row['admin_profile_image'] . '" alt="Profile Image" class="img-fluid mt-3 mb-5" style="max-height: 200px;">';
                    echo '<p>Full Name: <span>' . $row['admin_full_name'] . '</span></p>';
                    echo '<p>Username: <span>' . $row['admin_username'] . '</span></p>';
                    echo '<p>Email: <span>' . $row['admin_email'] . '</span></p>';
                    echo '<p>Date Joined: <span>' . $created_at. '</span></p>';
                } else {
                    echo '<p>Admin details not found.</p>';
                }

                // Close the database connection
                mysqli_close($conn);
?>