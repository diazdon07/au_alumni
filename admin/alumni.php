                <!-- Alumni  -->
                <div class="card" id="alumniForm">
                    <div class="card-header">
                        <i class="fa-solid fa-user-graduate"></i> <span class="ms-1 d-sm-inline">Alumni List</span>
                    </div>
                     <!-- Modal -->
                    <div class="modal fade" id="modalt" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Alumni</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <form id="modalform" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="mb-3">
                                  <input type="text" class="form-control" name="stdNo" placeholder="Student_number">
                                </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <input type="submit" class="btn btn-primary" id="fbtn" name="btn"/>
                            </div>
                          </form>
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
                                  <th scope="col">Course</th>
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
    updateSource();
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
    updateSource();
}

function fetchAlumniData() {
  fetch('../php/alumnis.php')
    .then(response => response.json()) // Assuming the PHP returns JSON data
    .then(data => {

    updateAlumniData(data);
    })
  .catch(error => console.error('Error fetching alumni data:', error));

  fetch('../php/courses.php')
    .then(response => response.json()) // Assuming the PHP returns JSON data
    .then(data => {

    updateCoursesData(data);
    })
  .catch(error => console.error('Error fetching alumni data:', error));
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
          <button class="btn btn-primary" role="button" id="">View</button>
        </td>
      </tr>
      `;
      tableData.insertAdjacentHTML('beforeend', tableHTMLData);
    });
    $(document).ready( function() {
      $('#Table').DataTable();
    });
}

fetchAlumniData();
})
                </script>