<link rel="stylesheet" href="../css/reportdesign.css">
<!-- Report  -->
<div class="card">
  <div class="card-header">
    <i class="fa-brands fa-wpforms"></i> <span class="ms-1 d-sm-inline">Report</span>
  </div>
  <div class="row row-cols-1 row-cols-md-4 g-4 cardCount">

  </div>
  <div class="card-body">
  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="alumni-report-tab" data-bs-toggle="tab" data-bs-target="#alumni-report" type="button" role="tab" aria-controls="alumni-report" aria-selected="true">Alumni Reports</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="event-report-tab" data-bs-toggle="tab" data-bs-target="#event-report" type="button" role="tab" aria-controls="event-report" aria-selected="false">Event Reports</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="job-report-tab" data-bs-toggle="tab" data-bs-target="#job-report" type="button" role="tab" aria-controls="job-report" aria-selected="false">Job Reports</button>
    </li>
  </ul>
  <div class="tab-content" id="myTabContent">
    <!-- alumni reports -->
    <div class="tab-pane fade show active" id="alumni-report" role="tabpanel" aria-labelledby="alumni-report-tab">
      <div class="container-fluid print-content" style="margin: 0.2rem 0rem;">
        <form class="row g-1" id="alumniReport">
          <div class="col-11 header-report">
            <h6>Alumni Management System (Alumni Reports)</h6>
          </div>
          <div class="col-1 text-center">
            <a href="#" class="btn btn-primary" name="printAlumni" style="font-size: smaller;"><i class="fa-solid fa-print"></i> Print</a>
          </div>
          <table id="alumniTable">
            <thead>
                <th class="text-center" style="min-width: 1.2rem; max-width: 1.5rem;">No.</th>
                <th scope="col">Fullname</th>
                <th scope="col">Course</th>
                <th scope="col">Student no.</th>
                <th scope="col" class="text-center" style="width: 70px;">Year Graduate</th>
                <th scope="col">Employment Status</th>
                <th scope="col">Current Employed</th>
                <th scope="col">Position</th>
            </thead>
            <tbody class="alumniTbody">

            </tbody>
          </table>
        </form>
      </div>
    </div>
    <!-- event reports -->
    <div class="tab-pane fade" id="event-report" role="tabpanel" aria-labelledby="event-report-tab">
      <div class="container-fluid" style="margin: 0.2rem 0rem;">
        <form class="row g-1" id="alumniReport">
          <div class="col-11 header-report">
            <h6>Alumni Management System (Event Reports)</h6>
          </div>
          <div class="col-1 text-center">
            <a href="#" class="btn btn-primary" name="printEvent" style="font-size: smaller;"><i class="fa-solid fa-print"></i> Print</a>
          </div>
          <table id="eventTable">
            <thead>
                <th class="text-center" style="min-width: 1.2rem; max-width: 1.5rem;">No.</th>
                <th>Event Title</th>
                <th>Schedule Date</th>
                <th>Schedule Time</th>
                <th>Location</th>
                <th class="text-center" style="width: 70px;">Commited</th>
            </thead>
            <tbody class="eventTbody">
                
            </tbody>
          </table>
        </form>
      </div>
    </div>
    <!-- job reports -->
    <div class="tab-pane fade" id="job-report" role="tabpanel" aria-labelledby="job-report-tab">
      <div class="container-fluid" style="margin: 0.2rem 0rem;">
        <form class="row g-1" id="alumniReport">
          <div class="col-11 header-report">
            <h6>Alumni Management System - (Job Reports)</h6>
          </div>
          <div class="col-1 text-center">
            <a href="#" class="btn btn-primary" name="printJob" style="font-size: smaller;"><i class="fa-solid fa-print"></i> Print</a>
          </div>
          <table id="jobTable">
            <thead>
                <th class="text-center" style="min-width: 1.2rem; max-width: 1.5rem;">No.</th>
                <th>Job Hiring</th>
                <th>Company</th>
                <th>Job Type</th>
                <th>Status</th>
                <th class="text-center" style="width: 70px;">Created By</th>
                <th style="width: 80px;">Time Created</th>
            </thead>
            <tbody class="jobTbody">

            </tbody>
          </table>
        </form>
      </div>
    </div>
  </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {

  const alumniData = [];
  const courseData = [];
  const eventsData = [];
  const commitedData = [];
  const jobData = [];

  function updateAlumniData(data) {
      
    alumniData.length = 0; // Clear the existing alumniData array
      // Push each fetched event to the alumniData array
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
          photo: alumni.photo,
          status: alumni.status,
          position: alumni.position,
          company: alumni.company
        });    
      });
  }

  function updateCoursesData(data) {
      
    courseData.length = 0; // Clear the existing courseData array
      // Push each fetched event to the courseData array
      data.forEach(course => {
        courseData.push({
          id: course.id,
          course: course.course
        });
      });
  }

  function updateEventsData(data) {
      
    eventsData.length = 0;

      data.forEach(event => {
        eventsData.push({
          id: event.id,
          title: event.title,
          date: event.date,
          timestart: event.timestart,
          timeend: event.timeend,
          image: event.image,
          location: event.location,
          description: event.description,
          url: event.url
        });
      });
  }

  function updateCommitedData(data) {
      
    commitedData.length = 0;
      
      data.forEach(commit => {
        commitedData.push({
          id: commit.id,
          eventId: commit.eventId,
          userId: commit.userId
        });
      });
  }

  function updateJobData(data) {
      
      jobData.length = 0; 
        
        data.forEach(job => {
          jobData.push({
            id: job.id,
            job_title: job.job_title,
            company: job.company,
            link: job.link,
            shortdesc: job.shortdesc,
            studentId: job.studentId,
            parttime: job.parttime,
            fulltime: job.fulltime,
            contractual: job.contractual,
            status: job.status,
            timestamp: job.timestamp
          });
        });
      }

  function fetchAlumniData() {
    const alumniPromise = fetch('../php/alumnis.php')
      .then(response => response.json())
      .then(data => {

      updateAlumniData(data);
      })
    .catch(error => console.error('Error fetching alumni data:', error));

    const coursesPromise = fetch('../php/courses.php')
      .then(response => response.json())
      .then(data => {

      updateCoursesData(data);
      })
    .catch(error => console.error('Error fetching course data:', error));

    const eventsPromise = fetch('../php/events.php')
      .then(response => response.json())
      .then(data => {

      updateEventsData(data);
      })
    .catch(error => console.error('Error fetching course data:', error));

    const commitsPromise = fetch('../php/commited.php')
      .then(response => response.json())
      .then(data => {

      updateCommitedData(data);
      })
    .catch(error => console.error('Error fetching course data:', error));

    const jobsPromise = fetch('../php/jobs.php')
    .then(response => response.json())
    .then(data => {

      updateJobData(data);
    })

    Promise.all([eventsPromise, commitsPromise])
      .then(() => updateEventSource());

    Promise.all([alumniPromise, coursesPromise])
      .then(() => updateAlumniSource());

    Promise.all([jobsPromise, alumniPromise])
      .then(() => updateJobSource());

    Promise.all([alumniPromise, coursesPromise])
      .then(() => updateDataSource());
  }

  function updateDataSource(){
    const cardCount = document.querySelector('.cardCount');
    cardCount.innerHTML = '';

    courseData.forEach( data => {
      const countData = alumniData.filter(alumni => alumni.course === data.id);
      const cardHTMLData = `
      <div class="card-body">
        <div class="card card-width bg-primary text-bg-dark bg-gradient">
          <div class="card-header text-end">
            <h2>${countData.length}</h2>
          </div>
          <div class="card-body">
            ${data.course} <i class="fa fa-users"></i>
          </div>
        </div>
      </div>
      `;
      cardCount.insertAdjacentHTML('beforeend', cardHTMLData);
    });
  }

  function updateAlumniSource(){
    const tableData = document.querySelector('.alumniTbody');
    tableData.innerHTML = '';
    let i = 1;

    alumniData.forEach( data => {
      const alumniCourse = courseData.find(course => course.id === data.course);

      const tableHTMLData = `
      <tr>
        <th scope="row">${i++}</th>
        <td>${data.lastname}, ${data.firstname} ${data.middlename}</td>
        <td>${alumniCourse ? alumniCourse.course : 'Unknown'}</td>
        <td>${data.student_number}</td>
        <td>${data.batch}</td>
        <td>${data.status === '0' ? 'Unemployed' : 'Employed'}</td>
        <td>${data.position}</td>
        <td>${data.company}</td>
      </tr>
      `;
      tableData.insertAdjacentHTML('beforeend', tableHTMLData);
    });
    $('#alumniTable').DataTable();
  }

  function updateJobSource(){
    const tableData = document.querySelector('.jobTbody');
    tableData.innerHTML = '';
    let i = 1;

    jobData.forEach( data => {
      const createdBy = alumniData.find(alumni => alumni.id === data.id);
      var jobStatus = `<div>${data.status === '0' ? 'Pending' : 'Approve'}</div>`;
      var created = 'Admin';
      var jobType = 'None';

      if(createdBy){
        created = createdBy.lastname+', '+createdBy.firstname;
      }

      if (data.parttime === '1' && data.fulltime === '1' && data.contractual === '1'){
        jobType = 'All';
      }else{
        if (data.parttime === '1') {
          jobType = 'Part Time';
        }
        if (data.fulltime === '1') {
          jobType = 'Full Time';
        }
        if (data.contractual === '1') {
          jobType = 'Contractual';
        }
      }

      const tableHTMLData = `
      <tr>
        <th scope="col" class="text-center">${i++}</th>
        <td scope="col">${data.job_title}</td>
        <td scope="col">${data.company}</td>
        <td scope="col">${jobType}</td>
        <td scope="col" class="text-center">${jobStatus}</td>
        <td scope="col">${created}</td>
        <td scope="col">${data.timestamp}</td>
        
      </tr>
      `;
      tableData.insertAdjacentHTML('beforeend', tableHTMLData);
    });
    $('#jobTable').DataTable();
 }

  function updateEventSource(){
    const tableData = document.querySelector('.eventTbody');
    tableData.innerHTML = '';
    let i = 1;

    eventsData.forEach( data => {
      const commit = commitedData.filter(commited => commited.eventId === data.id);
      const tableHTMLData = `
      <tr>
        <th scope="row">${i++}</th>
        <td>${data.title}</td>
        <td>${data.date}</td>
        <td>${data.timestart}-${data.timeend}</td>
        <td>${data.location}</td>
        <td class="text-center">${commit.length}</td>
        
      </tr>
      `;
      tableData.insertAdjacentHTML('beforeend', tableHTMLData);
    });
    $('#eventTable').DataTable();
  }

  fetchAlumniData();

  $(document).ready(function () {

    // Print function for Alumni tab
    $('a[name="printAlumni"]').click(function () {
      printTab('alumni-report');
    });

    // Print function for Event tab
    $('a[name="printEvent"]').click(function () {
      printTab('event-report');
    });

    // Print function for Job tab
    $('a[name="printJob"]').click(function () {
      printTab('job-report');
    });

    // Function to print the content of a specific tab
    function printTab(tabId) {
      // Disable search before printing
      
      var printContent = $('#' + tabId).clone();

      // Hide unnecessary elements in the print view
      printContent.find('.nav-tabs').remove();
      printContent.find('.tab-content').css('padding-top', '0');

      // Create a new window and print the content
      var printWindow = window.open('', '_blank');
      printWindow.document.write('<html><head><title>Print</title>');
      printWindow.document.write('<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">');
      printWindow.document.write('</head><body>');
      printWindow.document.write(printContent.html());
      printWindow.document.write('</body></html>');
      printWindow.document.close();
      printWindow.print();
    }
  });
});
</script>