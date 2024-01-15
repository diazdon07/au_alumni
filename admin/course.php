                <!-- Course  -->
                <div class="card" id="courseForm">
                    <div class="card-header">
                        <i class="fa-solid fa-graduation-cap"></i> <span class="ms-1 d-sm-inline">Course List</span>
                        <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#courseModal" type="button"
                        data-bs-whatever="Add">+Add</button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="courseModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Course</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <form>
                            <div class="modal-body">
                                <div class="col-12">
                                  <input type="hidden" id="courseId">
                                  <input type="text" class="form-control" id="courseName" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="button" class="btn btn-primary" id="btn-course"></button>
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
                                  <th scope="col">Course</th>
                                  <th scope="col">Activity</th>
                                </tr>
                              
                              </thead>
                              <tbody class="Tbody">
                              
                              </tbody>
                        </table>
                    </div>
                </div>
                <script>
document.addEventListener('DOMContentLoaded', function() {

const exampleModal = document.getElementById('courseModal')
const coursename = document.querySelector('#courseName')
const coursId = document.querySelector('#courseId')
exampleModal.addEventListener('show.bs.modal', function (event) {
  // Button that triggered the modal
  var button = event.relatedTarget
  // Extract info from data-bs-* attributes
  var recipient = button.getAttribute('data-bs-whatever')
  var modalTitle = exampleModal.querySelector('.modal-title')
  var btn = exampleModal.querySelector('#btn-course')

  modalTitle.textContent = recipient + ' Course'
  btn.textContent = recipient
  btn.value = recipient
  if(recipient === 'Edit'){
    coursename.value = button.getAttribute('data-title');
    coursId.value = button.getAttribute('data-id');
  }
})
$('#btn-course').click(function(){
  if(!coursename.value.length){
    console.log('No input data.')
  }else{
    console.log(this.value+" button click.")
      console.log('Add Method Ready.')
      $.ajax({
        type: 'POST',
            url: 'function/action.php?action='+this.value+'Course',
            data: {
              course: coursename.value,
              id: coursId.value
            },
            error: err => {
              console.log('Error: ', err)
            },
            success: function(data) {
              console.log(data.error)
              location.reload()
            }
      })
  }
})
$('#delete').click(function(){
  console.log('Delete button click')
})

const courseData = [];

function updateCoursesData(data){
  
  courseData.length = 0;

    data.forEach(course => {
      courseData.push({
        id: course.id,
        course: course.course
      });
    });
    updateSource();
}

function fetchData(){
  fetch('../php/courses.php')
    .then(response => response.json())
    .then(data => {
      updateCoursesData(data);
    })
    .catch(error => console.error('Error fetching course data:', error));
}

function updateSource(){
  const tableData = document.querySelector('.Tbody');
  tableData.innerHTML = '';
  let i = 1;

  courseData.forEach( data => {
    const tableHTMLData = `
    <tr>
      <th scope="row">${i++}</th>
      <td>${data.course}</td>
      <td>
        <button class="btn btn-danger delete" type="button" data-id="${data.id}">Delete</button>
        <button class="btn btn-warning" data-bs-target="#courseModal" data-id="${data.id}" data-title="${data.course}" data-bs-toggle="modal" 
        data-bs-whatever="Edit" type="button">Edit</button>
      </td>
    </tr>
    `;
    tableData.insertAdjacentHTML('beforeend', tableHTMLData);
  })
  $(document).ready( function() {
    $('#Table').DataTable();
  })
  document.querySelectorAll('.delete').forEach(element => {
    element.addEventListener('click', function() {
      const dataId = this.getAttribute('data-id');

      $.ajax({
        type: 'POST',
        url: 'function/action.php?action=DeleteCourse',
        data: {
          id: dataId
        },
        error: function(err){
          console.log('error: ', err)
        },
        success: function(data) {
          if(data.error){
            console.log(data.error);
          }else{
            console.log(data);
            location.reload();
          }
        }
      })
    })
  })
}

fetchData();
});
                </script>