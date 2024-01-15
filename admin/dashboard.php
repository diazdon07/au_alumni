                <!-- dashboard  -->
                <div class="card" id="dashboardForm">
                    <div class="card-header">
                        <i class="fa-solid fa-gauge"></i><span class="ms-1 d-sm-inline">Dashboard</span>
                    </div>
                    <div class="row row-cols-1 row-cols-md-4 g-4">
                        <!-- user count -->
                        <div class="card-body">
                        <div class="card card-width bg-primary text-bg-dark bg-gradient">
                            <div class="card-header text-end" id="userCount">
                            </div>
                            <div class="card-body">
                                Users
                            </div>
                        </div>
                        </div>
                        <!-- course count -->
                        <div class="card-body">
                            <div class="card card-width bg-info text-bg-dark bg-gradient">
                            <div class="card-header text-end" id="courseCount">
                                
                            </div>
                            <div class="card-body">
                                Courses
                            </div>
                            </div>
                        </div>
                        <!-- Alumni count -->
                        <div class="card-body">
                            <div class="card card-width bg-warning text-bg-dark bg-gradient">
                            <div class="card-header text-end" id="alumniCount">
                        
                            </div>
                            <div class="card-body">
                                Alumni
                            </div>
                            </div>
                        </div>
                        <!-- Job count -->
                        <div class="card-body">
                            <div class="card card-width bg-danger text-bg-dark bg-gradient">
                            <div class="card-header text-end" id="jobCount">
                                
                            </div>
                            <div class="card-body">
                                Jobs
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
  <div class="row gx-2" style="margin-top: 1rem;">
    <div class="col">
      <div class="card">
        <div class="card-header">
          <span class="ms-1 d-sm-inline">Job Offers</span>
        </div>
        <div class="card-body">
          <table class="table table-hover" id="jobTable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Job Position</th>
                <th scope="col">Company</th>
                <th scope="col">Created By</th>
                <th scope="col">Date & Time Created</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
    <div class="col-4">
      <div class="card">
        <div class="card-header">
          <span class="ms-1 d-sm-inline">Notification</span>
        </div>
        <div class="card-body">
          <table class="table table-hover" id="notifTable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Activity</th>
                <th scope="col">Type</th>
                <th scope="col">Time</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card" style="margin-top: 1rem;">
      <div class="card-header">
        <span class="ms-1 d-sm-inline">Upcoming Events</span>
      </div>
      <div class="card-body">
        <table class="table table-hover" id="eventTable">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Event Title</th>
              <th scope="col">Date</th>
              <th scope="col">Time</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const userData = [];
  const courseData = [];
  const alumniData = [];
  const jobData = [];
  
  function updateUserData(data) {
      
  userData.length = 0; 

    data.forEach(user => {
      userData.push({
        displayName: user.displayName,
        email: user.email,
        contact: user.contact,
        status: user.status
      });
    });
    updateDatabaseSource(); 
  }

  function updateCourseData(data) {
      
  courseData.length = 0; 

    data.forEach(course => {
      courseData.push({
        id: course.id,
        course: course.course
      });
    });
    updateDatabaseSource(); 
  }

  function updateAlumniData(data) {
      
  alumniData.length = 0; 
    
    data.forEach(alumni => {
      alumniData.push({
        id: alumni.id,
        student_number: alumni.student_number,
        firstname: alumni.firstname,
        middlename: alumni.middlename,
        lastname: alumni.lastname,
        gender: alumni.gender,
        address: alumni.address,
        city: alumni.city,
        course: alumni.course,
        batch: alumni.batch,
        photo: alumni.photo
      });
    });
    updateDatabaseSource(); 
  }

  function updateJobData(data) {
      
  jobData.length = 0; 
    
    data.forEach(job => {
      jobData.push({
        id: job.id,
        job_title: job.job_title,
        company: job.company,
        link: job.link,
        desc: job.description
      });
    });
    updateDatabaseSource(); 
  }
    
  
  function fetchData() {
    fetch('../php/users.php')
    .then(response => response.json()) // Assuming the PHP returns JSON data
    .then(data => {
      updateUserData(data);
    })
    .catch(error => console.error('Error fetching users data:', error));

    fetch('../php/courses.php')
    .then(response => response.json()) // Assuming the PHP returns JSON data
    .then(data => {
      updateCourseData(data);
    })
    .catch(error => console.error('Error fetching courses data:', error));

    fetch('../php/alumnis.php')
    .then(response => response.json()) // Assuming the PHP returns JSON data
    .then(data => {
      updateAlumniData(data);
    })
    .catch(error => console.error('Error fetching alumni data:', error));

    fetch('../php/jobs.php')
    .then(response => response.json()) // Assuming the PHP returns JSON data
    .then(data => {
      updateJobData(data);
    })
    .catch(error => console.error('Error fetching jobs data:', error));
  }

  function updateDatabaseSource(){

    const usersData = document.querySelector('#userCount');
    const coursesData = document.querySelector('#courseCount');
    const alumnisData = document.querySelector('#alumniCount');
    const jobsData = document.querySelector('#jobCount');
    usersData.innerHTML = '';
    coursesData.innerHTML = '';
    alumnisData.innerHTML = '';
    jobsData.innerHTML = '';

    const userCountHTMLData = `
    <h2>${userData.length}</h2>
    `;
    const courseCountHTMLData = `
    <h2>${courseData.length}</h2>
    `;
    const alumniCountHTMLData = `
    <h2>${alumniData.length}</h2>
    `;
    const jobCountHTMLData = `
    <h2>${jobData.length}</h2>
    `;

    usersData.insertAdjacentHTML('beforeend', userCountHTMLData);
    coursesData.insertAdjacentHTML('beforeend', courseCountHTMLData);
    alumnisData.insertAdjacentHTML('beforeend', alumniCountHTMLData);
    jobsData.insertAdjacentHTML('beforeend', jobCountHTMLData);

 }

  fetchData();
})
</script>