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
  <div class="card" style="margin-top: 0.5rem;">
    <div class="card-header">
      <span class="ms-1 d-sm-inline">Restriction & Approval</span>
    </div>
    <div class="card-body">
      <!-- <canvas id="myChart" style="height:3rem; width: auto; max-width: 80rem;"></canvas> -->
      <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
          <button class="nav-link active" id="nav-alumni-res-tab" data-bs-toggle="tab" data-bs-target="#nav-alumni-res" type="button" role="tab" aria-controls="nav-alumni-res" aria-selected="true">Alumni</button>
          <button class="nav-link" id="nav-job-status-tab" data-bs-toggle="tab" data-bs-target="#nav-job-status" type="button" role="tab" aria-controls="nav-job-status" aria-selected="false">Jobs</button>
          <button class="nav-link" id="nav-users-tab" data-bs-toggle="tab" data-bs-target="#nav-users" type="button" role="tab" aria-controls="nav-users" aria-selected="false">Users</button>
          <button class="nav-link" id="nav-forum-tab" data-bs-toggle="tab" data-bs-target="#nav-forum" type="button" role="tab" aria-controls="nav-forum" aria-selected="false">Forums</button>
        </div>
      </nav>
      <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-alumni-res" role="tabpanel" aria-labelledby="nav-alumni-res-tab" style="padding: 1rem 0rem;">
          <table class="table table-hover align-middle" id="alumniTable">
            <thead>
              <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col">Profile Picture</th>
                <th scope="col">Student No.</th>
                <th scope="col">Forum Posting</th>
                <th scope="col">Job Posting</th>
                <th scope="col">Comments</th>
              </tr>
            </thead>
            <tbody class="alumniTbody"></tbody>
          </table>
        </div>
        <div class="tab-pane fade" id="nav-job-status" role="tabpanel" aria-labelledby="nav-job-status-tab" style="padding: 1rem 0rem;">
          <table class="table table-hover align-middle" id="jobTable">
            <thead>
              <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col">Job Position</th>
                <th scope="col">Company</th>
                <th scope="col">Created By</th>
                <th scope="col">Date & Time Created</th>
                <th scope="col" class="col-1 text-center">Status</th>
              </tr>
            </thead>
            <tbody class="jobTbody"></tbody>
          </table>
        </div>
        <div class="tab-pane fade" id="nav-users" role="tabpanel" aria-labelledby="nav-users-tab" style="padding: 1rem 0rem;">
          <table class="table table-hover align-middle" id="usersTable">
            <thead>
              <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col">Display Name</th>
                <th scope="col" class="text-center col-1">Account Status</th>
              </tr>
            </thead>
            <tbody class="userTbody"></tbody>
          </table>
        </div>
        <div class="tab-pane fade" id="nav-forum" role="tabpanel" aria-labelledby="nav-forum-tab" style="padding: 1rem 0rem;">
          <div id="main">
            <table class="table table-hover align-middle" id="forumTable">
              <thead>
                <tr>
                  <th scope="col" class="text-center">Topics</th>
                  <th scope="col" class="text-center col-1">Replies</th>
                </tr>
              </thead>
              <tbody class="forumTbody"></tbody>
            </table>
            <!-- create topic -->
            <div id="createTopic">
          
            </div>
          </div>
          <!-- post view -->
          <div id="post">

          </div>
        </div>
      </div>
    </div>
  </div>
<!-- <script src="../js/jschart.js"></script> -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  
  const userData = [];
  const courseData = [];
  const alumniData = [];
  const jobData = [];
  const commentData = [];
  const forumData = [];
  const adminData = [];
  
  function updateUserData(data) {
      
  userData.length = 0; 

    data.forEach(user => {
      userData.push({
        id: user.id,
        displayName: user.displayName,
        email: user.email,
        users: user.users,
        status: user.status,
        type: user.type
      });
    });
  }

  function updateCourseData(data) {
      
  courseData.length = 0; 

    data.forEach(course => {
      courseData.push({
        id: course.id,
        course: course.course
      });
    });
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
        photo: alumni.photo,
        jobc: alumni.jobC,
        forumc: alumni.forumC,
        commentc: alumni.commentC
      });
    });
  }

  function updateAdminData(data) {
    
    adminData.length = 0; // Clear the existing eventData array
      // Push each fetched event to the alumniData array
    data.forEach(admin => {
      adminData.push({
        id: admin.id,
        firstname: admin.firstname,
        middlename: admin.middlename,
        lastname: admin.lastname,
        gender: admin.gender,
        photo: admin.photo
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
        status: job.status,
        timestamp: job.timestamp
      });
    });
  }
   
  function updateForumData(data) {
      
  forumData.length = 0; 
    
    data.forEach(forum => {
      forumData.push({
        id: forum.id,
        topic: forum.topic,
        img: forum.photo,
        content: forum.content,
        created: forum.created,
        timestamp: forum.timestamp
      });
    });
  }

  function updateCommentData(data) {
      
  commentData.length = 0; 
    
    data.forEach(comment => {
      commentData.push({
        id: comment.id,
        forumId: comment.forumId,
        comments: comment.comments,
        studentId: comment.studentId,
        adminId: comment.adminId,
        timestamp: comment.timestamp
      });
    });
  }
  
  function fetchData() {

    const adminPromise = fetch('../php/admins.php')
    .then(response => response.json()) // Assuming the PHP returns JSON data
    .then(data => {
      updateAdminData(data);
    })
    .catch(error => console.error('Error fetching admin data:', error));
    
    const userPromise = fetch('../php/users.php')
    .then(response => response.json()) // Assuming the PHP returns JSON data
    .then(data => {
      updateUserData(data);
    })
    .catch(error => console.error('Error fetching users data:', error));

    const coursesPromise = fetch('../php/courses.php')
    .then(response => response.json()) // Assuming the PHP returns JSON data
    .then(data => {
      updateCourseData(data);
    })
    .catch(error => console.error('Error fetching courses data:', error));

    const alumniPromise = fetch('../php/alumnis.php')
    .then(response => response.json()) // Assuming the PHP returns JSON data
    .then( data => {
      updateAlumniData(data);
    })
    .catch(error => console.error('Error fetching alumni data:', error));

    const jobsPromise = fetch('../php/jobs.php')
    .then(response => response.json()) // Assuming the PHP returns JSON data
    .then(data => {
      updateJobData(data);
    })
    .catch(error => console.error('Error fetching jobs data:', error));

    const forumPromise = fetch('../php/forums.php')
    .then(response => response.json()) // Assuming the PHP returns JSON data
    .then(data => {

      updateForumData(data);
    })
    .catch(error => console.error('Error fetching forum data:', error));

    const commentPromise = fetch('../php/comment.php')
    .then(response => response.json()) // Assuming the PHP returns JSON data
    .then(data => {
      updateCommentData(data);
    })

    .catch(error => console.error('Error fetching comment data:', error));
    
    Promise.all([userPromise, coursesPromise, alumniPromise, jobsPromise])
      .then(() => updateDatabaseSource());

    Promise.all([coursesPromise, alumniPromise])
      .then(() => alumniRestriction());

    Promise.all([jobsPromise, alumniPromise])
      .then(() => jobApproval());

    Promise.all([forumPromise, commentPromise, alumniPromise, adminPromise])
      .then(() => updateForumSource());
    
    userPromise.then(() => accountRestriction());
    
  }

  function updateDatabaseSource(){

    const usersData = document.querySelector('#userCount');
    const coursesData = document.querySelector('#courseCount');
    const alumnisData = document.querySelector('#alumniCount');
    const jobsData = document.querySelector('#jobCount');

    setInterval(() => {
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
    }, 500);
    
 }

 function alumniRestriction(){
    const tableData = document.querySelector('.alumniTbody');
    
      tableData.innerHTML = '';
      let i = 1;

      alumniData.forEach( data => {
        const alumniCourse = courseData.find(course => course.id === data.course);
        var jobCreateStatus = `<button class="${data.jobc === '0' ? 'disable-btn' : 'active-btn'} jobCreateStatus" data-status="${data.jobc === '0' ? 1 : 0}" data-id="${data.id}">${data.jobc === '0' ? 'Disable' : 'Undisable'}</button>`;
        var forumCreateStatus = `<button class="${data.forumc === '0' ? 'disable-btn' : 'active-btn'} forumCreateStatus" data-status="${data.forumc === '0' ? 1 : 0}" data-id="${data.id}">${data.forumc === '0' ? 'Disable' : 'Undisable'}</button>`;
        var commentCreateStatus = `<button class="${data.commentc === '0' ? 'disable-btn' : 'active-btn'} commentCreateStatus" data-status="${data.commentc === '0' ? 1 : 0}" data-id="${data.id}">${data.commentc === '0' ? 'Disable' : 'Undisable'}</button>`;
        const tableHTMLData = `
        <tr>
          <th scope="col" class="text-center">${i++}</th>
          <td scope="col" class="text-center col-2">
            <figure class="figure" style="margin: 0;">
              <img src="${data.photo || 'https://www.freeiconspng.com/uploads/no-image-icon-6.png'}" class="figure-img img-fluid rounded" style="height: 100px; margin: 0;">
            </figure>
            <p style="display: none">${data.lastname}</p>
            <p style="display: none">${data.middlename}</p>
            <p style="display: none">${data.firstname}</p>
            <p style="display: none">${data.batch}</p>
            <p style="display: none">${alumniCourse ? alumniCourse.course : 'Unknown'}</p>
          </td>
          <td>${data.student_number}</td>
          <td class="text-center">${forumCreateStatus}</td>
          <td class="text-center">${jobCreateStatus}</td>
          <td class="text-center">${commentCreateStatus}</td>
        </tr>
        `;
        tableData.insertAdjacentHTML('beforeend', tableHTMLData);
      });
      $('#alumniTable').DataTable();
      $(document).ready( function() {
        $('.jobCreateStatus').click( function(event) {
          console.log('Job Restriction Button Click. ID:',event.target.getAttribute('data-id'));
          $.ajax({
            type: 'POST',
            url: 'function/action.php?action=alumniJobRestriction',
            data: {
              id: event.target.getAttribute('data-id'),
              status: event.target.getAttribute('data-status')
            },
            error: err => {
                  console.log('Error: ', err);
            },
            success: function(data) {
              console.log('Success data Recieve');
              if(data.error){
                console.log(data.error);
                showMessage('error',data.error);
              }else{
                showMessage('success',data);
                setInterval(() => {
                  location.reload();
                }, 5000);
              }
            }
          })
        })
        $('.forumCreateStatus').click( function(event) {
          console.log('Forum Restriction Button Click. ID:',event.target.getAttribute('data-id'));
          $.ajax({
            type: 'POST',
            url: 'function/action.php?action=alumniForumRestriction',
            data: {
              id: event.target.getAttribute('data-id'),
              status: event.target.getAttribute('data-status')
            },
            error: err => {
                  console.log('Error: ', err);
            },
            success: function(data) {
              console.log('Success data Recieve');
              if(data.error){
                console.log(data.error);
                showMessage('error',data.error);
              }else{
                showMessage('success',data);
                setInterval(() => {
                  location.reload();
                }, 5000);
              }
            }
          })
        })
        $('.commentCreateStatus').click( function(event) {
          console.log('Comment Restriction Button Click. ID:',event.target.getAttribute('data-id'));
          $.ajax({
            type: 'POST',
            url: 'function/action.php?action=alumniCommentRestriction',
            data: {
              id: event.target.getAttribute('data-id'),
              status: event.target.getAttribute('data-status')
            },
            error: err => {
                  console.log('Error: ', err);
            },
            success: function(data) {
              console.log('Success data Recieve');
              if(data.error){
                console.log(data.error);
                showMessage('error',data.error);
              }else{
                showMessage('success',data);
                setInterval(() => {
                  location.reload();
                }, 5000);
              }
            }
          })
        })
      })
    
 }

 function jobApproval(){
    const tableData = document.querySelector('.jobTbody');
    tableData.innerHTML = '';
    let i = 1;

    jobData.forEach( data => {
      const createdBy = alumniData.find(alumni => alumni.id === data.id);
      var jobStatus = `<button class="${data.status === '0' ? 'pending-btn' : 'active-btn'} jobStatus" data-status="${data.status === '0' ? 1 : 0}" data-id="${data.id}">${data.status === '0' ? 'Pending' : 'Approve'}</button>`;
      var created = 'Admin';

      if(createdBy){
        created = createdBy.lastname+', '+createdBy.firstname;
      }

      const tableHTMLData = `
      <tr>
        <th scope="col" class="text-center">${i++}</th>
        <td scope="col">${data.job_title}</td>
        <td scope="col">${data.company}</td>
        <td scope="col">${created}</td>
        <td scope="col">${data.timestamp}</td>
        <td scope="col" class="text-center">${jobStatus}</td>
      </tr>
      `;
      tableData.insertAdjacentHTML('beforeend', tableHTMLData);
    });
    $('#jobTable').DataTable();
    $(document).ready( function() {
      $('.jobStatus').click( function(event) {
        console.log('Job Status Button Click. ID:',event.target.getAttribute('data-id'));
        $.ajax({
          type: 'POST',
          url: 'function/action.php?action=jobApproval',
          data: {
            id: event.target.getAttribute('data-id'),
            status: event.target.getAttribute('data-status')
          },
          error: err => {
                console.log('Error: ', err);
          },
          success: function(data) {
            console.log('Success data Recieve');
            if(data.error){
              console.log(data.error);
              showMessage('error',data.error);
            }else{
              showMessage('success',data);
              setInterval(() => {
                location.reload();
              }, 5000);
            }
          }
        })
      })
    })
 }

 function accountRestriction(){
    const tableData = document.querySelector('.userTbody');
    tableData.innerHTML = '';
    let i = 1;
    let user = JSON.parse(sessionStorage.user || null);

    userData.forEach( data => {
      var accountStatus = `<button class="${data.status === '0' ? 'pending-btn' : 'active-btn'} accountStatus" data-status="${data.status === '0' ? 1 : 0}" data-id="${data.id}">${data.status === '0' ? 'Deactive' : 'Active'}</button>`;
      if(data.displayName !== user.displayName){
        const tableHTMLData = `
          <tr>
            <th scope="col" class="text-center">${i++}</th>
            <td scope="col">${data.displayName}</td>
            <td scope="col" class="text-center">${accountStatus}</td>
          </tr>
          `;
        tableData.insertAdjacentHTML('beforeend', tableHTMLData);
      }
      
    })
    $('#usersTable').DataTable();
    $(document).ready( function() {
      $('.accountStatus').click( function(event) {
        console.log('Account Status Button Click. ID:',event.target.getAttribute('data-id'));
        $.ajax({
          type: 'POST',
          url: 'function/action.php?action=statusCheck',
          data: {
            id: event.target.getAttribute('data-id'),
            status: event.target.getAttribute('data-status')
          },
          error: err => {
                console.log('Error: ', err);
          },
          success: function(data) {
            console.log('Success data Recieve');
            if(data.error){
              console.log(data.error);
              showMessage('error',data.error);
            }else{
              showMessage('success',data);
              setInterval(() => {
                location.reload();
              }, 5000);
            }
          }
        })
      })
    })
    
 }

 function updateForumSource(){
  
      let user = JSON.parse(sessionStorage.user || null);
      const usersData = alumniData.find(alumni => alumni.id === user.id);
      const forumTbody = document.querySelector('.forumTbody');
      forumTbody.innerHTML = '';

      forumData.forEach( data => {
        const commentsForForum = commentData.filter(comment => comment.forumId === data.id);
        const forumHTMLData = `
        <tr>
          <td>
            <p class="ptag">Created by: ${data.created}</p>
            <h3><i class="fa fa-book"></i>${data.topic}</h3>
            <a class="ptag text-muted viewTopic" role="button" data-id="${data.id}"><i class="fa fa-eye"></i>View</a>
            <span class="ptag"> Posted Date: ${data.timestamp}</span> 
          </td>
          <td style="padding: 1.5rem;" class="text-muted text-center"><p>${commentsForForum.length}</p></td>
        </tr>
        `;
        forumTbody.insertAdjacentHTML('beforeend', forumHTMLData);
      });
      $('#forumTable').DataTable();
      document.querySelectorAll('.viewTopic').forEach(element => {
        element.addEventListener('click', function() {
          
          // Access the data attributes
          const topicId = this.getAttribute('data-id');
          $('#main').hide();

          const backHtml =`
          <div class="mb-3">
            <a href="#" class="ptag text-muted" id="backForum"><i class="fa fa-chevron-left"></i> Back</a>
          </div>
          `;
          
          $('#post').append(backHtml);

          const fData = forumData.find(forum => forum.id === topicId);

          if(fData){
            viewForumSource(fData);
          }else{
            console.log(`Error Forum Message: Forum ID no. ${topicId} Data Not Found`);
          }

          viewCommentSource(topicId);

          $('#backForum').click(function(){
            $('#main').show();
            $('#post').html('');
          });

            const commentHtml = `
            <div class="mb-3">
              <form id="createComment" class="row g-2">
                <div class="col-10">
                  <input type="hidden" name="topic" value="${topicId}">
                  <input type="hidden" name="id" value="${user.id}">
                  <textarea class="form-control" name="comment" rows="3"></textarea>
                </div>
                <div class="col-sm">
                  <input type="submit" class="btn btn-primary" value="Submit">
                </div>
              </form>
            </div>
            `;
            $('#post').append(commentHtml);
            $(document).ready(function(e) {
              $('#createComment').on('submit', function(e) {
                e.preventDefault();
                if($('textarea[name="comment"]').val().trim() === ''){
                  alert('Error: Comment cannot be empty.');
                }else{
                  $.ajax({
                    type: 'POST',
                    url: 'function/action.php?action=Comments',
                    data: new FormData(this),
                    datatype: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    error: function(err) {
                      console.log('error: ', err);
                    },
                    success: function(data) {
                      if(data.error){
                        console.log(data.error);
                        showMessage('error',data.error);
                      }else{
                        showMessage('success',data);
                        setInterval(() => {
                          location.reload();
                        }, 5000);
                      }
                    }
                  });
                }
              });
            });
        });
      });
 }

 function viewForumSource(data) {
        
    let image = '';
        if(data.img!==null){
          image = `<img src="${data.img}" class="img-thumbnail rounded mx-auto d-block" style="width: 30rem;">`;
        }

        const viewBodyHTMLData = `
        <div class="mb-3">
          <h2><i class="fa fa-book"></i>${data.topic}</h2>
          <p>By ${data.created} | Posted Date ${data.timestamp}</p>
          <div class="card" style="padding: .5rem;">
            ${image}
            <p>${data.content}</p>
          </div>
        </div>
        <div class="mb-3" id="commentsContent">
          
        </div>
        `;
        $('#post').append(viewBodyHTMLData);
       
 }

 function viewCommentSource(data){
    const comment = commentData.filter(comment => comment.forumId === data);

    comment.forEach(cData => {
      let comments = '';

      if(cData.studentId!==null){
        comments = alumniData.find(alumni => alumni.id === cData.studentId);
      }else{
        comments = adminData.find(admin => admin.id === cData.adminId);
      }

      const viewCommentHTMLData = `
      <div class="row">
        <div class="col-1">
          <figure class="figure">
            <img src="${comments.photo || 'https://www.freeiconspng.com/uploads/--tie-user-users-work-worker-working-icon--icon-search-engine-6.png'}" class="figure-img img-fluid rounded">
            <figcaption class="figure-caption text-center">${comments.firstname || ''}</figcaption>
          </figure>
        </div>
        <div class="col-11">
          <div class="card" style="padding: .5rem;">
            <p>${cData.comments}</p>
          </div>
          <p class="text-end ptag">Posted Date: ${cData.timestamp}</p>
        </div>
      </div>
      `;
      $('#commentsContent').append(viewCommentHTMLData);
    })
 }

 function topicCreateRestriction(){
      let user = JSON.parse(sessionStorage.user || null);
      const createTopic = document.querySelector('#createTopic');
      createTopic.innerHTML = '';
    
          const createTopicHTMLData = `
                <form id="createPost" class="card" enctype="multipart/form-data" style="padding: 1rem; margin: 1rem 0rem;">
                  <input type="hidden" name="created" value="${user.firstname}">
                  <div class="row g-3">
                    <div class="col-8">
                      <div class="mb-3">
                        <input type="text" name="topic" id="topicId" class="form-control" placeholder="Topic Title">
                      </div>
                      <div class="mb-3">
                        <textarea class="form-control" rows="5" name="content" id="contentId" placeholder="Topic Content"></textarea>
                      </div>
                    </div>
                    <div class="col-3">
                      <img src="https://www.freeiconspng.com/uploads/no-image-icon-6.png" class="rounded mx-auto d-block" style="width: 10rem;" id="imageHolder">
                      <input type="file" class="form-control" name="image" accept="image/*" id="imagein">
                    </div>
                    <div class="col-sm">
                      <input type="submit" class="btn btn-primary" value="Create">
                    </div>
                  </div>
                </form>
            `;
        createTopic.insertAdjacentHTML('beforeend', createTopicHTMLData);
        $('#imagein').on('change', function(event) {
          const file = event.target.files[0];
          if (file) {
            $('#imageHolder').attr('src', URL.createObjectURL(file))
          }
        })
        $(document).ready(function(e) {
              $('#createPost').on('submit', function(e) {
                e.preventDefault();
                console.log('ready to create post.');

                const topic = document.getElementById('topicId');
                const content = document.getElementById('contentId');

                  if(!topic.value.length || !content.value.length){
                    console.log('No Details Input');
                  }else{
                    $.ajax({
                      type: 'POST',
                      url: 'function/action.php?action=Forum',
                      data: new FormData(this),
                      datatype: 'json',
                      contentType: false,
                      cache: false,
                      processData: false,
                      error: function(err) {
                        console.log('error: ', err);
                      },
                      success: function(data) {
                        if(data.error){
                          console.log(data.error);
                          showMessage('error',data.error);
                        }else{
                          showMessage('success',data);
                          setInterval(() => {
                            location.reload();
                          }, 5000);
                        }
                      }
                    });
                  }
              })
            })
   }

    fetchData();

    topicCreateRestriction();
})
</script>