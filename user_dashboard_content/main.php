<!-- DASHBOARD PAGE - MAIN_DASHBOARD.PHP -->
<!-- DASHBOARD FIRST GRID -->
    <div class="dashboard-grid1">
        <!-- Dashboard Header-->
        <div class="dashboard-container item1">
            <div class="header-img">
                <img src="https://pngimg.com/uploads/student/student_PNG9.png" alt="header img">
            </div>
            <div class="header-text">
                <h3>Welcome, <?php echo $userFirstName; ?></h3>
            </div>
        </div>
       <!-- Calendar -->
        <div class="dashboard-container item2">
            <div id="calendar-container">
                <div id="calendar-header">
                    <h2 id="month-year"></h2>
                </div>
                <div id="calendar-body">
                <!-- Dynamic Calendar -->
                </div>
            </div>
        </div>
    </div>

<!-- DASHBOARD SECOND GRID -->
<div class="dashboard-grid2">
  <!-- Recent Progress -->
  <div class="dashboard-container item3" id="task-list-board">
    <h2>Task List Board</h2>
    <div class="task-list" role="list">
      <div class="task" role="listitem">
        <div class="task-info">
          <h3>Assignment 1</h3>
          <p>Course: Math 101</p>
          <p>Deadline: October 15, 2023</p>
        </div>
        <div class="task-status" role="status">Pending</div>
        <a href="#assignment1" class="task-button" role="button">View Task</a>
      </div>
      <div class="task" role="listitem">
        <div class="task-info">
          <h3>Quiz 2</h3>
          <p>Course: History 202</p>
          <p>Deadline: October 20, 2023</p>
        </div>
        <div class="task-status" role="status">Pending</div>
        <a href="#quiz2" class="task-button" role="button">View Task</a>
      </div>
      <div class="task" role="listitem">
        <div class="task-info">
          <h3>Exam 3</h3>
          <p>Course: Science 303</p>
          <p>Deadline: October 25, 2023</p>
        </div>
        <div class="task-status" role="status">Pending</div>
        <a href="#exam3" class="task-button" role="button">View Task</a>
      </div>
    </div>
  </div>

    <div class="dashboard-container item4">
        <div class="user-progress">
            <div class="user-progress-item">
                <i class="far fa-clock"></i>
                <h2>Hours Spent</h2>
                <p>12hr 1min</p>
            </div>
            <div class="user-progress-item">
                <i class="fas fa-book-open"></i>
                <h2>Course In Progress</h2>
                <p>0/3</p>
            </div>
            <div class="user-progress-item">
                <i class="fas fa-award"></i>
                <h2>Course Completed</h2>
                <p>0/3</p>
            </div>
        </div>

        <div class="ongoing-progress">
            <h2>Ongoing Courses</h2>

        <div class="course-progress">
            <h6 class="course-title">Introduction to Cybersecurity</h6>
            <div class="progress">
                <div class="progress-bar" id="course_progress1" role="progressbar"></div>
            </div>
            <p class="progress-text">Progress: 75%</p>
        </div>
         
        <div class="course-progress">
            <h6 class="course-title">Information Security</h6>
            <div class="progress">
                <div class="progress-bar" id="course_progress2" role="progressbar"></div>
            </div>
            <p class="progress-text">Progress: 50%</p>
        </div>
        
        <div class="course-progress">
            <h6 class="course-title">Data Privacy</h6>
            <div class="progress">
                <div class="progress-bar" role="progressbar" id="course_progress3"></div>
            </div>
            <p class="progress-text">Progress: 25%</p>
        </div>

        <div class="course-progress">
            <h6 class="course-title">Ethical Hacking</h6>
            <div class="progress">
                <div class="progress-bar" role="progressbar" id="course_progress4"></div>
            </div>
            <p class="progress-text">Progress: 50%</p>
        </div>
        </div>
    </div>
</div>


    </div>
</div>

<script>
    // Function to populate the calendar with days
    function populateCalendar(year, month) {
        const calendarBody = document.getElementById('calendar-body');
        calendarBody.innerHTML = '';

        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const firstDay = new Date(year, month, 1).getDay();
        const currentDate = new Date();

        // Week names
        const weekNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

        // Add week names to the calendar header
        const calendarHeader = document.getElementById('calendar-header');
        const weekNamesRow = document.createElement('div');
        weekNamesRow.classList.add('week-names-row');

        weekNames.forEach(weekName => {
            const weekNameCell = document.createElement('div');
            weekNameCell.classList.add('week-name-cell');
            weekNameCell.textContent = weekName;
            weekNamesRow.appendChild(weekNameCell);
        });

        calendarHeader.appendChild(weekNamesRow);

        for (let i = 0; i < firstDay; i++) {
            const emptyCell = document.createElement('div');
            calendarBody.appendChild(emptyCell);
        }

        for (let day = 1; day <= daysInMonth; day++) {
            const calendarDay = document.createElement('div');
            calendarDay.classList.add('calendar-day');
            calendarDay.textContent = day;
            calendarBody.appendChild(calendarDay);

            if (
                day === currentDate.getDate() &&
                month === currentDate.getMonth() &&
                year === currentDate.getFullYear()
            ) {
                calendarDay.classList.add('current-date');
            }
        }
    }

    // Function to update the calendar
    function updateCalendar(year, month) {
        populateCalendar(year, month);
        const monthYearElement = document.getElementById('month-year');
        const options = { year: 'numeric', month: 'long' };
        monthYearElement.textContent = new Date(year, month).toLocaleDateString(undefined, options);
    }

    // Initial values for year and month
    let currentYear = new Date().getFullYear();
    let currentMonth = new Date().getMonth();

    // Populate and update the calendar initially
    updateCalendar(currentYear, currentMonth);

    // Add week names to the calendar
    addWeekNames();

    // Update the current date and time every second
    setInterval(() => {
        const currentDate = new Date();
        currentYear = currentDate.getFullYear();
        currentMonth = currentDate.getMonth();
        updateCalendar(currentYear, currentMonth);
    }, 1000);
</script>