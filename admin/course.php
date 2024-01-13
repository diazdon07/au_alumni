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
                        <table class="table table-hover">
                            <thead>
                              
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Course</th>
                                  <th scope="col">Activity</th>
                                </tr>
                              
                              </thead>
                              <tbody>
                              <?php
                              $result = mysqli_query($conn,'SELECT * FROM `courses`');
                              $i = 1;
                              if(mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_assoc($result)):
                              ?>
                                <tr>
                                  <input type="hidden" id="Id" value="<?= $row['id']?>">
                                  <input type="hidden" id="Course" value="<?= $row['course']?>">
                                  <th scope="row"><?= $i++ ?></th>
                                  <td><?= $row['course']?></td>
                                  <td>
                                    <button class="btn btn-danger" type="button" id="delete">Delete</button>
                                    <button class="btn btn-warning" data-bs-target="#courseModal" data-bs-toggle="modal" 
                                    data-bs-whatever="Edit" type="button">Edit</button>
                                  </td>
                                </tr>
                              <?php
                                endwhile;
                              }else{
                                echo 'No Data Found.';
                              }
                              ?>
                              </tbody>
                        </table>
                    </div>
                </div>
                <script>
const exampleModal = document.getElementById('courseModal')
const id = document.querySelector('#Id')
const course = document.querySelector('#Course')
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
    coursename.value = course.value
    coursId.value = id.value
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
                </script>