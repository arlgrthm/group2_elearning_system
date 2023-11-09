<?php
                // Include your database connection file (conn.php)
                include('conn.php');
                
                // Get the user_id from the POST request
                $user_id = $_POST['user_id'];

                // Query to fetch user details
                $query = "SELECT user_id, profile_image, first_name, last_name, email_address, username, birthday, address, phone_number, terms_accepted, created_at FROM users WHERE user_id = $user_id";
                $result = mysqli_query($conn, $query);


                // Check if there are any results
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $accepted_terms = ($row['terms_accepted'] == 1) ? "Yes" : "No";
                    $created_at = date("F j, Y g:i A", strtotime($row['created_at']));

                    echo '<h5 class="user_id_clicked">User ID: <span id="view-user-id">' . $row['user_id'] . '</span></h5>';
                    echo '<img src="' . $row['profile_image'] . '" alt="Profile Image" class="img-fluid mt-3 mb-5" style="max-height: 200px;">';
                    echo '<p>Username: <span>' . $row['username'] . '</span></p>';
                    echo '<p>First Name: <span>' . $row['first_name'] . '</span></p>';
                    echo '<p>Last Name: <span>' . $row['last_name'] . '</span></p>';
                    echo '<p>Email Address: <span>' . $row['email_address'] . '</span></p>';
                    echo '<p>Birthday: <span>' . $row['birthday'] . '</span></p>';
                    echo '<p>Address: <span>' . $row['address'] . '</span></p>';
                    echo '<p>Phone Number: <span>' . $row['phone_number'] . '</span></p>';
                    echo '<p>Terms Accepted: <span>' . $accepted_terms . '</span></p>';
                    echo '<p>Created At: <span>' . $created_at. '</span></p>';
                } else {
                    echo '<p>User details not found.</p>';
                }

                // Close the database connection
                mysqli_close($conn);
?>