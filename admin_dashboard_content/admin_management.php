<h1 class="title">Admin Accounts Management</h1>

    <div class="table-management main-content">
        <div class="table-header-row user-management">
            <h5>List of Admins (<span class="user-count">100</span>)</h5>
            <div class="table-header-search">
                <input type="text" class="search-input" placeholder="Search an Admin....">
                <button class="search-button"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            <div class="table-header-buttons">
            </div>
        </div>

        <div class="table-container">
        <table class="admin-data-table">
            <thead>
                <tr>
                    <th>Admin ID</th>
                    <th>Profile Image</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Actions</th>
                </tr>
            </thead>
        <tbody>
        <?php
            // Include your database connection file (conn.php)
            include('./necessities/conn.php');

            // Query to fetch data from the 'users' table
            $query = "SELECT admin_id, admin_profile_image, admin_full_name, admin_username, date_created FROM admins";
            $result = mysqli_query($conn, $query);

            // Check if there are any results
            if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['admin_id'] . '</td>';
                echo '<td><img src="' . $row['admin_profile_image'] . '" alt="Profile Image"></td>';
                echo '<td>' . $row['admin_full_name'] . '</td>';
                echo '<td>' . $row['admin_username'] . '</td>';
                echo '<td>';
                echo '<button class="action-button view-button" data-admin-id="' . $row['admin_id'] . '">View</button>';
                echo '<button class="action-button edit-button" data-admin-id="' . $row['admin_id'] . '">Edit</button>';
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
                    <h5 class="modal-title" id="viewModalLabel">Admin Information</h5>
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
                    <h5 class="modal-title" id="editModalLabel">Edit Admin Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body edit-modal">
                    <div class="alert alert-success" id="successMessage" style="display: none";>
                            Changes saved successfully.
                    </div>
                    <form>
                        <p class="current-user-id">Admin ID: <span id="admin-id"></span></p> 
                    <div class="form-group">
                        <label for="edit-admin-profile-image">Profile Image</label>
                        <div id="image-preview">
                            <img src="" id="current-admin-profile-image" alt="" style="max-height: 150px; margin: 0 auto; display: block;">
                        </div>
                    </div>
                        <div class="form-group">
                            <label for="edit-admin-full-name">Admin Full Name</label>
                            <input type="text" class="form-control" id="edit-admin-full-name">
                        </div>
                        <div class="form-group">
                            <label for="edit-admin-username">Admin Username</label>
                            <input type="text" class="form-control" id="edit-admin-username">
                        </div>
                        <div class="form-group">
                            <label for="edit-admin-email-address">Admin Email Address</label>
                            <input type="email" class="form-control" id="edit-admin-email-address">
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
            var admin_id = $j(this).data("admin-id");

            $j.ajax({
                url: 'admin_dashboard_content/admin_scripts/view-admin-details.php',
                type: 'POST',
                data: { admin_id: admin_id },
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
            var admin_id = $j(this).data("admin-id");

            $j.ajax({
                url: 'admin_dashboard_content/admin_scripts/get-admin-details-values.php',
                type: 'POST',
                data: { admin_id: admin_id },
                success: function (data) {
                    var admin = JSON.parse(data);

                // Populate the edit modal fields
                    $j("#admin-id").text(admin.admin_id);
                    $j("#edit-admin-full-name").val(admin.admin_full_name);
                    $j("#edit-admin-username").val(admin.admin_username);
                    $j("#edit-admin-email-address").val(admin.admin_email);
                // Display the profile image if available
                    if (admin.admin_profile_image) {
                        $j("#current-admin-profile-image").attr("src", admin.admin_profile_image);
                    } else {
                        $j("#current-admin-profile-image").attr("src", ""); // Clear the image
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
            var admin_id = $j("#admin-id").text();
            var admin_full_name = $j("#edit-admin-full-name").val();
            var admin_username = $j("#edit-admin-username").val();
            var admin_email = $j("#edit-admin-email-address").val();

            $j.ajax({
                url: 'admin_dashboard_content/admin_scripts/save-admin-details-changes.php',
                type: 'POST',
                data: {
                    admin_id: admin_id,
                    admin_full_name: admin_full_name,
                    admin_username: admin_username,
                    admin_email: admin_email
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
