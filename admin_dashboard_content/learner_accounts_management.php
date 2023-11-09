<h1 class="title">Learner Accounts Management</h1>

    <div class="table-management main-content">
        <div class="table-header-row user-management">
        <h5>List of Learners (<span class="user-count" id="learner-count">100</span>)</h5>
            <div class="table-header-search">
                <input type="text" class="search-input" placeholder="Search a Learner....">
                <button class="search-button"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            <div class="table-header-buttons">
                <button class="add-user-button"><i class="fa-regular fa-square-plus"></i>Add User</button>
            </div>
        </div>

        <div class="table-container">
        <table class="admin-data-table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Profile Image</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email Address</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>
            </thead>
        <tbody>
            <?php
            // Include your database connection file (conn.php)
            include('./necessities/conn.php');

            // Query to fetch data from the 'users' table
            $query = "SELECT user_id, profile_image, first_name, last_name, email_address, username FROM users";
            $result = mysqli_query($conn, $query);

            // Check if there are any results
            if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['user_id'] . '</td>';
                echo '<td><img src="' . $row['profile_image'] . '" alt="Profile Image"></td>';
                echo '<td>' . $row['first_name'] . '</td>';
                echo '<td>' . $row['last_name'] . '</td>';
                echo '<td>' . $row['email_address'] . '</td>';
                echo '<td>' . $row['username'] . '</td>';
                echo '<td>';
                echo '<button class="action-button view-button" data-user-id="' . $row['user_id'] . '">View</button>';
                echo '<button class="action-button edit-button" data-user-id="' . $row['user_id'] . '">Edit</button>';
                echo '<button class="action-button delete-button">Delete</button>';
                echo '</td>';
                echo '</tr>';
            }
            } else {
            // Handle the case where there are no records in the database
                echo '<tr><td colspan="7">No records found.</td></tr>';
            }

                // Close the database connection
                mysqli_close($conn);
            ?>
        </tbody>
        </table>
        </div>

        <!-- View Modal -->
        <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">User Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body view-modal"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit User Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body edit-modal">
                    <div class="alert alert-success" id="successMessage" style="display: none";>
                            Changes saved successfully.
                    </div>
                    <form>
                        <p class="current-user-id">User ID: <span id="user-id"></span></p> 
                    <div class="form-group">
                        <label for="edit-profile-image">Profile Image</label>
                        <div id="image-preview">
                            <img src="" id="current-profile-image" alt="" style="max-height: 150px; margin: 0 auto; display: block;">
                        </div>
                    </div>
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit-first-name">First Name</label>
                                <input type="text" class="form-control" id="edit-first-name">
                            </div>
                            <div class="form-group">
                                <label for = "edit-middle-initial">Middle Initial</label>
                                <input type="text" class="form-control" id="edit-middle-initial">
                            </div>
                            <div class="form-group">
                                <label for="edit-suffix">Suffix</label>
                                <input type="text" class="form-control" id="edit-suffix">
                            </div>
                            <div class="form-group">
                                <label for="edit-birthday">Birthday</label>
                                <input type="date" class="form-control" id="edit-birthday">
                            </div>
                            <div class="form-group">
                                <label for="edit-email-address">Email Address</label>
                                <input type="email" class="form-control" id="edit-email-address">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit-last-name">Last Name</label>
                                <input type="text" class="form-control" id="edit-last-name">
                            </div>
                            <div class="form-group">
                                <label for="edit-address">Address</label>
                                <textarea class="form-control" id="edit-address" rows="4"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="edit-phone-number">Phone Number</label>
                                <input type="tel" class="form-control" id="edit-phone-number">
                            </div>
                            <div class="form-group">
                                <label for="edit-username">Username</label>
                                <input type="text" class="form-control" id="edit-username">
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveChangesButton">Save Changes</button>
                </div>
            </div>
        </div>
    </div>


<!-- Include Bootstrap and JavaScript at the end of the body for better performance -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    var $j = jQuery.noConflict();

    // Ensure Bootstrap can access jQuery
    window.jQuery = window.$ = $j;

    $j(document).ready(function ($) {
        $j(".view-button").click(function () {
            var user_id = $j(this).data("user-id");

            $j.ajax({
                url: 'admin_dashboard_content/admin_scripts/view-learner-details.php',
                type: 'POST',
                data: { user_id: user_id },
                success: function (response) {
                    $("#viewModal .modal-body").html(response);
                    $("#viewModal").modal("show");
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error: " + error);
                }
            });
        });

        $j(".edit-button").click(function () {
            var user_id = $j(this).data("user-id");

            $j.ajax({
                url: 'admin_dashboard_content/admin_scripts/get-user-details-values.php',
                type: 'POST',
                data: { user_id: user_id },
                success: function (data) {
                    var user = JSON.parse(data);

                // Populate the edit modal fields
                    $j("#user-id").text(user.user_id);
                    $j("#edit-first-name").val(user.first_name);
                    $j("#edit-middle-initial").val(user.middle_initial);
                    $j("#edit-suffix").val(user.suffix);
                    $j("#edit-birthday").val(user.birthday);
                    $j("#edit-email-address").val(user.email_address);
                    $j("#edit-last-name").val(user.last_name);
                    $j("#edit-address").val(user.address);
                    $j("#edit-phone-number").val(user.phone_number);
                    $j("#edit-username").val(user.username);

                // Display the profile image if available
                    if (user.profile_image) {
                        $j("#current-profile-image").attr("src", user.profile_image);
                    } else {
                        $j("#current-profile-image").attr("src", ""); // Clear the image
                    }

                    $j("#editModal").modal("show");
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error: " + error);
                }
            });
        });

        // Save Changes button click handler
        $j("#saveChangesButton").click(function () {
            var user_id = $j("#user-id").text();
            var first_name = $j("#edit-first-name").val();
            var middle_initial = $j("#edit-middle-initial").val();
            var suffix = $j("#edit-suffix").val();
            var birthday = $j("#edit-birthday").val();
            var email_address = $j("#edit-email-address").val();
            var last_name = $j("#edit-last-name").val();
            var address = $j("#edit-address").val();
            var phone_number = $j("#edit-phone-number").val();
            var username = $j("#edit-username").val();

            $j.ajax({
                url: 'admin_dashboard_content/admin_scripts/save-user-details-changes.php', // Create this PHP file to handle the update
                type: 'POST',
                data: {
                    user_id: user_id,
                    first_name: first_name,
                    middle_initial: middle_initial,
                    suffix: suffix,
                    birthday: birthday,
                    email_address: email_address,
                    last_name: last_name,
                    address: address,
                    phone_number: phone_number,
                    username: username
                },
                success: function (response) {
                    if (response === "success") {
                        // Update the success message or perform any other actions
                        $j("#successMessage").show();
                    } else {
                        console.error("Update failed: " + response);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error: " + error);
                }
            });
        });

    
    });


    function updateLabel() {
        const input = document.getElementById('edit-profile-image');
        const label = document.querySelector('.custom-file-label');
        const imagePreview = document.getElementById('current-profile-image');

        if (input.files.length > 0) {
            const file = input.files[0];
            label.textContent = file.name;

            // Display the selected image in the image preview
            const reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            label.textContent = 'Choose file';
            // Clear the image preview when no file is selected
            imagePreview.src = '';
        }
    }

    // Fetch the initial count of learners when the page loads
    var $tableRows = $j(".admin-data-table tbody tr");
        var initialCount = $tableRows.length;

        // Display the initial count
        $j(".user-count").text(initialCount);

        $j(".search-button").click(function() {
            var searchText = $j(".search-input").val().toLowerCase();
            $tableRows.hide();

            var $matchingRows = $tableRows.filter(function() {
                var $row = $j(this);
                var columns = $row.find("td").not(":first-child");
                return columns.text().toLowerCase().indexOf(searchText) > -1;
            });

            // Clear any existing "No matching records found" message
            $j(".admin-data-table tbody tr.no-matching-records").remove();

            if ($matchingRows.length === 0) {
                // Show a message if no results are found
                $j(".admin-data-table tbody").append('<tr class="no-matching-records"><td colspan="7">No matching records found.</td></tr>');
            }

            $matchingRows.show();

            // Display the count of matching rows
            var rowCount = $matchingRows.length;
            $j(".user-count").text(rowCount);
        });
</script>
