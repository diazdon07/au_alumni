                <!-- Alumni  -->
                <div class="card" id="alumniForm">
                    <div class="card-header">
                        <i class="fa-solid fa-user-graduate"></i> <span class="ms-1 d-sm-inline">Alumni List</span>
                    </div>
                     <!-- Modal -->
                    <div class="modal fade" id="view" tabindex="-1" aria-hidden="true">
                      <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h6 class="modal-title">Alumni View Details</h6>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-hover" id="Table">
                            <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Student No.</th>
                                  <th scope="col">First Name</th>
                                  <th scope="col">Middle Name</th>
                                  <th scope="col">Last Name</th>
                                  <th scope="col">Program</th>
                                  <th scope="col">Batch</th>
                                  <th scope="col">Activity</th>
                                </tr>
                              </thead>
                              <tbody class="Tbody">
                                
                              </tbody>
                        </table>
                    </div>
                </div>
                <script>
document.addEventListener('DOMContentLoaded', function () {

const alumniData = [];
const courseData = [];

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
        photo: alumni.photo
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

  Promise.all([alumniPromise, coursesPromise])
    .then(() => updateSource());
}

function updateSource(){
  const tableData = document.querySelector('.Tbody');
    tableData.innerHTML = '';
    let i = 1;

    alumniData.forEach( data => {
      const alumniCourse = courseData.find(course => course.id === data.course);
      const tableHTMLData = `
      <tr>
        <th scope="row">${i++}</th>
        <th>${data.student_number}</th>
        <td>${data.firstname}</td>
        <td>${data.middlename}</td>
        <td>${data.lastname}</td>
        <td>${alumniCourse ? alumniCourse.course : 'Unknown'}</td>
        <td>${data.batch}</td>
        <td>
          <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#view" data-id="${data.id}">View</button>
        </td>
      </tr>
      `;
      tableData.insertAdjacentHTML('beforeend', tableHTMLData);
    });
    $(document).ready( function() {
      $('#Table').DataTable();
    });
    $(document).ready( function() {
      $('#view').on('show.bs.modal', function (event) {
          const btnData = event.relatedTarget;
        $.ajax({
          type: 'POST',
          url: 'function/action.php?action=alumniCheck',
          data: {
            id: btnData.getAttribute('data-id')
          },
          error: err => {
            console.log('Error: ', err)
          },
          success: function(data) {
            if(data.error){
              console.log(data.error);
            }else{
              const modalData = document.querySelector('.modal-body');
              modalData.innerHTML = '';

              btnStatus = `<button class="${data.status === 0 ? 'disable-btn' : 'active-btn'}" id="status" 
              data-status="${data.status === 0 ? 1 : 0}" data-id="${data.userId}">${data.status === 0 ? 'Disable' : 'Active'}</button>`;

              const modalHTMLData = `
              <div class="row">
                <div class="col">
                  <img src="${data.photo || 'https://www.freeiconspng.com/uploads/no-image-icon-6.png'}" class="img-thumbnail">
                </div>
                <div class="col">
                  <div class="row g-0">
                    <div class="col-6 col-md-4">Firstname:</div>
                    <div class="col-sm-6 col-md-8"><h4>${data.firstname}</h4></div>
                  </div>
                  <div class="row g-0">
                    <div class="col-6 col-md-4">Middlename:</div>
                    <div class="col-sm-6 col-md-8"><h4>${data.middlename}</h4></div>
                  </div>
                  <div class="row g-0">
                    <div class="col-6 col-md-4">Lastname:</div>
                    <div class="col-sm-6 col-md-8"><h4>${data.lastname}</h4></div>
                  </div>
                  <hr>
                  <div class="row g-0">
                    <div class="col">Program: </div>
                    <div class="col-md-10"><h5><b>${data.course}</b></h5></div>
                  </div>
                  <div class="row g-0">
                    <div class="col">Student No:</div>
                    <div class="col"><b>${data.stdNo}</b></div>
                    <div class="col">Account Status:</div>
                    <div class="col">${btnStatus}</button></div>
                  </div>
                  <div class="row g-0">
                    <div class="col">Email: </div>
                    <div class="col-md-9"><b>${data.email}</b></div>
                  </div>
                  <div class="row g-0">
                    <div class="col">Mobile No.:</div>
                    <div class="col-md-9"><b>${data.contact}</b></div>
                  </div>
                  <div class="row g-0">
                    <div class="col">Gender: </div>
                    <div class="col"><b>${data.gender}</b></div>
                    <div class="col">Year Graduated:</div>
                    <div class="col"><b>${data.batch}</b></div>
                  </div>
                  <div class="row g-0">
                    <div class="col">Address: </div>
                    <div class="col-md-9"><b>${data.address}</b></div>
                  </div>
                  <div class="row g-0">
                    <div class="col">City: </div>
                    <div class="col-md-9"><b>${data.city}</b></div>
                  </div>
                  <hr>
                </div>
              </div>
              `;
              modalData.insertAdjacentHTML('beforeend', modalHTMLData);
              $(document).ready( function() {
                $('#status').click( function(event) {
                  const relatedTarget  = event.target;
                  $.ajax({
                    type: 'POST',
                    url: 'function/action.php?action=statusCheck',
                    data: {
                      id: relatedTarget.getAttribute('data-id'),
                      status: relatedTarget.getAttribute('data-status')
                    },error: err => {
                      console.log('Error: ', err)
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
                  })
                })
              })
            }
          }
        })
      });
    })

}
  fetchAlumniData();

})
                </script>