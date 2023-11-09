    <div class="start-course-container">

        <div class="course_name_container">
            <?php
            require_once 'user_scripts/conn.php';
                $courseId = $_GET['course_id'];

                // Query to fetch the course name based on the course ID
                $query = "SELECT course_name FROM courses WHERE course_id = $courseId";
                $result = mysqli_query($conn, $query);

                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    $courseName = $row['course_name'];
                    echo "<p>Course Name: $courseName</p>";
                } else {
                    echo "<p class='course-name'>Course Not Found</p>"; // Provide a default message if the course is not found
                }
            ?>
        </div>
        <div class="form-group start-course-dropdown">
            <label for="tableSelector" class="text-dark">Navigate the Contents Here</label>
                <select class="form-control custom-select" id="tableSelector">
                    <option value="lessonsVideo" selected>Lessons Video</option>
                    <option value="lessonsReading">Lessons Reading</option>
                    <option value="quizzes">Quizzes</option>
                </select>
        </div>

        <!--Lessons Video-->
        <div id="lessonsVideoTable" class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead id="start-course-table-header">
                    <tr>
                        <th>Lesson Video Title</th>
                        <th>Actions</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody><!--Dynamic lesson videos--></tbody>
            </table>
        </div>

        <!--Lessons Reading-->
        <div id="lessonsReadingTable" class="hidden">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead id="start-course-table-header">
                        <tr>
                            <th>Lesson Reading Title</th>
                            <th>Actions</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody><!--Dynamic lesson reading--></tbody>
                </table>
            </div>
        </div>

         <!--Quizzes-->
        <div id="quizzesTable" class="hidden">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead id="start-course-table-header">
                        <tr>
                            <th>Quiz Name</th>
                            <th>Actions</th>
                            <th>Score</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for displaying lesson video content -->
    <div class="modal fade" id="lessonVideoModal" tabindex="-1" role="dialog" aria-labelledby="lessonVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header start-course-modals-header">
                <h5 class="modal-title start-course-modals-title" id="lessonVideoModalLabel">Lesson Video</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <div id="completionMessage" class="alert alert-success mt-2" style="display: none;">
                        Lesson Video Completed Successfully!
                    </div>
                    <label>
                        <input type="checkbox" id="videoCompletionCheckbox">
                        <span id="completionVideoLabel">Mark as completed</span>
                    </label>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div id="lessonVideoContainer" class="mt-2">
                            <!-- Video content will be loaded here -->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- Automated captions div -->
                        <div class="static-transcriptions">
                            <h6>Transcriptions</h6>
                            <div class="transcriptions-content">
                                <!-- Transcriptions content will be displayed here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    <!-- Modal for displaying lesson reading content -->
    <div class="modal fade" id="lessonReadingModal" tabindex="-1" role="dialog" aria-labelledby="lessonReadingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header start-course-modals-header">
            <h5 class="modal-title start-course-modals-title" id="lessonReadingModalLabel">Lesson Reading</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
                <div>
                    <div id="completionReadingMessage" class="alert alert-success mt-2" style="display: none;">
                        Lesson Reading Completed Successfully!
                    </div>
                    <label>
                        <input type="checkbox" id="readingCompletionCheckbox">
                        <span id="completionReadingLabel">Mark as completed</span>
                    </label>
                </div>
            <div id="lessonReadingContainer" class="mt-2">
                <!-- Reading content will be loaded here -->
            </div>
        </div>
    </div>
    </div>
    </div>

    <div class="modal fade" id="quizModal" tabindex="-1" role="dialog" aria-labelledby="quizModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header start-course-modals-header>
                <h5 class="modal-title start-course-modals-title" id="quizModalLabel">Quiz Title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="quizQuestionsContainer">
                    <!-- Quiz questions will be loaded here -->
                </div>
                <div id="quizSubmitButtonContainer">
                    <button class="btn btn-primary" id="quizSubmitButton">Submit Quiz</button>
                </div>
            </div>
        </div>
    </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function () {
    
    // LESSON VIDEOS CODE
    function loadLessonVideos(courseId) {
        console.log("This is for lesson video");
        console.log("USER ID: ", <?php echo $userID; ?>);
        console.log("COURSE ID: ", courseId);
            $.ajax({
                url: 'user_dashboard_content/user_scripts/fetch_lesson_videos.php',
                method: 'POST',
                data: { course_id: courseId, user_id: <?php echo $userID; ?> },
                dataType: 'json',
                success: function (response) {
                if (response.error) {
                    console.log('Error: ' + response.error);
                } else {
                    $('#lessonsVideoTable tbody').empty(); // Clear the table

                    // Modify this part in loadLessonVideos function
                    $.each(response, function (index, video) {
                    var status = video.progress_status == 1 ? 'Completed' : 'Not Completed'; 
                    var row = '<tr>' +
                        '<td>' + video.lesson_video_title + '</td>' +
                        '<td><a href="#" class="btn btn-primary start-course-btn-design start-video-btn" data-video-link="' + video.lesson_video_link + '" data-lesson-video-id="' + video.lesson_video_id + '">View Video</a></td>' +
                        '<td>' + status + '</td>' +
                        '</tr>';

                        $('#lessonsVideoTable tbody').append(row);
                });

                }
            },
            error: function (xhr, status, error) {
                console.log('AJAX Error: ' + error);
            }
        });
    }

    $('#lessonsVideoTable').on('click', '.start-video-btn', function (e) {
        e.preventDefault();

        var videoLink = $(this).data('video-link');
        var videoTitle = $(this).closest('tr').find('td:first').text();
        var lessonVideoId = $(this).data('lesson-video-id');

        console.log('Video Link:', videoLink);
        console.log('Video Title:', videoTitle);
        console.log('Lesson Video ID:', lessonVideoId);

        var videoId = getYouTubeVideoId(videoLink);
        console.log('YouTube Video ID:', videoId);

        // Set the modal title to the video title
        $('#lessonVideoModalLabel').text(videoTitle);

        var videoHTML = '<iframe width="560" height="315" src="https://www.youtube.com/embed/' + videoId + '" frameborder="0" allowfullscreen></iframe>';
        $('#lessonVideoContainer').html(videoHTML);
    

        // Set the lesson video ID as a data attribute in the completion checkbox
        $('#videoCompletionCheckbox').data('lesson-video-id', lessonVideoId);

        // Check the status and update the completion label
        var status = $(this).closest('tr').find('td:last').text();
        var completionLabel = $('#completionVideoLabel');

        if (status === 'Completed') {
            $('#videoCompletionCheckbox').prop('disabled', true);
            completionLabel.text('Lesson Video Completed');
            completionLabel.css('font-weight', 'bold'); // Make the text bold
        } else {
            $('#videoCompletionCheckbox').prop('disabled', false);
            completionLabel.text('Mark as completed');
            completionLabel.css('font-weight', 'normal'); // Reset the font weight to normal
        }

        // Show the modal
        $('#lessonVideoModal').modal('show');
    });

    $('#videoCompletionCheckbox').on('change', function () {
        var lessonVideoId = $(this).data('lesson-video-id');
        var isCompleted = $(this).prop('checked');

        // Use AJAX to update the user's lesson video progress
        $.ajax({
            url: 'user_dashboard_content/user_scripts/update_lesson_video_status.php', // Replace with the URL of your server-side script
            method: 'POST',
            data: {
                user_id: <?php echo $userID; ?>,
                course_id: <?php echo $courseId; ?>,
                lesson_video_id: lessonVideoId,
                progress_status: isCompleted ? 1 : 0, // Use 1 for completed, 0 for not completed
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    if (isCompleted) {
                        $('#completionMessage').show(); // Show a completion message
                    } else {
                        $('#completionMessage').hide(); // Hide the completion message
                    }
                } else {
                    console.log('Progress update failed: ' + response.error);
                }
            },
            error: function (xhr, status, error) {
                console.log('AJAX Error: ' + error);
        }
    });
    });




    // Function to extract the YouTube video ID from a URL
    function getYouTubeVideoId(url) {
        var regExp = /(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?feature=player_embedded&v=))([^?&"'>]+)/;
        var match = url.match(regExp);
        return (match && match[1].length === 11) ? match[1] : null;
    }


    function loadLessonReadings(courseId) {
        console.log("This is for lesson reading");
        console.log("USER ID: ", <?php echo $userID; ?>);
        console.log("COURSE ID: ", courseId);
            $.ajax({
                url: 'user_dashboard_content/user_scripts/fetch_lesson_readings.php',
                method: 'POST',
                data: { course_id: courseId, user_id: <?php echo $userID; ?> },
                dataType: 'json',
                    success: function (response) {
                        if (response.error) {
                            console.log('Error: ' + response.error);
                        } else {
                            $('#lessonsReadingTable tbody').empty(); // Clear the table

                        // Populate the table with the retrieved data
                        $.each(response, function (index, lesson) {
                            var row = '<tr>' +
                                '<td>' + lesson.lesson_reading_title + '</td>' +
                                '<td><a href="#" class="btn btn-primary start-course-btn-design start-reading-btn" data-lesson-id="' + lesson.lesson_reading_id + '">View Reading</a></td>' +
                                '<td>Not Yet</td>' +
                                '</tr>';

                            $('#lessonsReadingTable tbody').append(row);
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.log('AJAX Error: ' + error);
                }
            });
        }

    // Attach an event handler to the 'View Reading' button clicks for the newly loaded content
    $('#lessonsReadingTable').on('click', '.start-reading-btn', function (e) {
    e.preventDefault();

    var lessonId = $(this).data('lesson-id');

    // Fetch the lesson reading content
    $.ajax({
        url: 'user_dashboard_content/user_scripts/fetch_lesson_readings_content.php',
        method: 'POST',
        data: { lesson_id: lessonId },
        dataType: 'json',
        success: function (response) {
            if (response.error) {
                console.log('Error: ' + response.error);
            } else {
                var readingTitle = response.lesson_reading_title;
                var readingContent = response.lesson_content;

                // Populate the modal with the reading content
                $('#lessonReadingModalLabel').text(readingTitle);
                $('#lessonReadingContainer').html(readingContent);

                // Set the lesson reading ID as a data attribute in the completion checkbox
                $('#readingCompletionCheckbox').data('lesson-reading-id', lessonId);

                // Check the status and update the completion label
                var status = $(this).closest('tr').find('td:last').text();
                var completionLabel = $('#completionReadingLabel');

                if (status === 'Completed') {
                    $('#readingCompletionCheckbox').prop('disabled', true);
                    completionLabel.text('Lesson Reading Completed');
                    completionLabel.css('font-weight', 'bold'); // Make the text bold
                } else {
                    $('#readingCompletionCheckbox').prop('disabled', false);
                    completionLabel.text('Mark as completed');
                    completionLabel.css('font-weight', 'normal'); // Reset the font weight to normal
                }

                // Show the modal
                $('#lessonReadingModal').modal('show');
            }
        },
        error: function (xhr, status, error) {
            console.log('AJAX Error: ' + error);
        }
        });
    });

    // Handle the lesson reading completion checkbox change event
    $('#readingCompletionCheckbox').on('change', function () {
    var lessonReadingId = $(this).data('lesson-reading-id');
    var isCompleted = $(this).prop('checked');

    // Use AJAX to update the user's lesson reading progress
    $.ajax({
        url: 'user_dashboard_content/user_scripts/update_lesson_reading_status.php', // Replace with the URL of your server-side script
        method: 'POST',
        data: {
            user_id: <?php echo $userID; ?>,
            course_id: <?php echo $courseId; ?>,
            lesson_reading_id: lessonReadingId,
            progress_status: isCompleted ? 1 : 0, // Use 1 for completed, 0 for not completed
        },
        dataType: 'json',
        success: function (response) {
            if (response.success) {
                if (isCompleted) {
                    $('#completionReadingMessage').show(); // Show a completion message
                } else {
                    $('#completionReadingMessage').hide(); // Hide the completion message
                }
            } else {
                console.log('Progress update failed: ' + response.error);
            }
        },
        error: function (xhr, status, error) {
            console.log('AJAX Error: ' + error);
        }
    });
    });

    function loadQuizzes(courseId) {
        $.ajax({
            url: 'user_dashboard_content/user_scripts/fetch_quiz_details.php', // Update the URL to your server-side script
            method: 'POST',
            data: { course_id: courseId },
            dataType: 'json',
                success: function (response) {
                if (response.error) {
                        console.log('Error: ' + response.error);
                    } else {
                        $('#quizzesTable tbody').empty(); // Clear the table

                        // Populate the table with the retrieved data
                        $.each(response, function (index, quiz) {
                            var row = '<tr>' +
                                '<td>' + quiz.quiz_name + '</td>' +
                                '<td><button class="btn btn-primary start-course-btn-design start-quiz-btn" data-quiz-id="' + quiz.quiz_id + '">Start Quiz</button></td>' +
                                '<td> Null </td>' +
                                '</tr>';

                            $('#quizzesTable tbody').append(row);
                        });
                    }
                },
                error: function (xhr, status, error) {
                console.log('AJAX Error: ' + error);
            }
        });
    }

    function loadQuizQuestions(quizId) {
        $.ajax({
            url: 'user_dashboard_content/user_scripts/fetch_quiz_questions.php', // Replace with the actual URL to your server-side script
            method: 'POST',
            data: { quiz_id: quizId },
            dataType: 'json',
        success: function (response) {
            if (response.error) {
                console.log('Error: ' + response.error);
            } else {
                // Clear the quiz questions container
                $('#quizQuestionsContainer').empty();

                // Populate the modal with the quiz questions
                $('#quizModalLabel').text('Quiz Title');
                
                // Create a container for quiz questions
                var questionsContainer = $('<div>');

                // Iterate through the quiz questions and create HTML elements for each question
                $.each(response, function (index, question) {
                var questionHtml = '<div class="quiz-question">' +
                    '<p class="question-number">Question ' + question.question_number + '</p>' + // Display question number
                    '<p class="question-text">' + question.question_text + '</p>' +
                    '<label><input type="radio" name="quiz_' + question.quiz_questions_id + '" value="A">' + question.choice_A + '</label><br>' +
                    '<label><input type="radio" name="quiz_' + question.quiz_questions_id + '" value="B">' + question.choice_B + '</label><br>' +
                    '<label><input type="radio" name="quiz_' + question.quiz_questions_id + '" value="C">' + question.choice_C + '</label><br>' +
                    '<label><input type="radio" name="quiz_' + question.quiz_questions_id + '" value="D">' + question.choice_D + '</label><br>' +
                    '</div>';

                    questionsContainer.append(questionHtml);
                });


                // Append the questions container to the modal body
                $('#quizQuestionsContainer').append(questionsContainer);

                // Show the modal
                $('#quizModal').modal('show');
            }
        },
        error: function (xhr, status, error) {
            console.log('AJAX Error: ' + error);
        }
    });
    }

    // Attach an event handler to the 'Start Quiz' button clicks for the newly loaded content
    $('#quizzesTable').on('click', '.start-quiz-btn', function (e) {
        e.preventDefault();

        var quizId = $(this).data('quiz-id');

        // Load quiz questions for the selected quiz
        loadQuizQuestions(quizId);
    });


        // Load lesson videos for the selected course on page load
            var courseId = <?php echo $courseId; ?>;
            loadLessonVideos(courseId);
            loadLessonReadings(courseId);
            loadQuizzes(courseId);

        // Attach an event handler to the dropdown
        $('#tableSelector').on('change', function () {
            var selectedValue = $(this).val();

            if (selectedValue === 'lessonsVideo') {
                // Load lesson videos for the selected course
                var courseId = <?php echo $courseId; ?>; 
                loadLessonVideos(courseId);

                // Show the appropriate table
                $('#lessonsVideoTable').removeClass('hidden');
                $('#lessonsReadingTable').addClass('hidden');
                $('#quizzesTable').addClass('hidden');
            } else if (selectedValue === 'lessonsReading') {
                // Load lesson readings for the selected course
                var courseId = <?php echo $courseId; ?>; 
                loadLessonReadings(courseId);

                // Show the appropriate table
                $('#lessonsVideoTable').addClass('hidden');
                $('#lessonsReadingTable').removeClass('hidden');
                $('#quizzesTable').addClass('hidden');
            } else if (selectedValue === 'quizzes') {
                var courseId = <?php echo $courseId; ?>; 
                loadQuizzes(courseId);
                // Show the quizzes table and hide others
                $('#quizzesTable').removeClass('hidden');
                $('#lessonsVideoTable').addClass('hidden');
                $('#lessonsReadingTable').addClass('hidden');
            } else {
                // Hide all tables for other content types
                $('#lessonsVideoTable').addClass('hidden');
                $('#lessonsReadingTable').addClass('hidden');
                $('#quizzesTable').addClass('hidden');
            }
        });
    });

    </script>