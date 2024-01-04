                <!-- Alumni  -->
                <div class="card" id="alumniForm">
                    <div class="card-header">
                        <i class="fa-solid fa-user-graduate"></i> <span class="ms-1 d-sm-inline">Alumni List</span>
                        <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#modalt" type="button"
                        data-bs-whatever="Add">+Add</button>
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
                        <table class="table table-hover">
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
                              <tbody>
                                <?php
                                $result = mysqli_query($conn,'SELECT * FROM `students`');
                                $i = 1;
                                if(mysqli_num_rows($result) > 0){
                                  while($row = mysqli_fetch_assoc($result)):
                                ?>
                                <tr>
                                  <input type="hidden" id="" value="<?= $row['id'] ?>">
                                  <th scope="row"><?= $i++ ?></th>
                                  <th><?= $row['student_number'] ?></th>
                                  <td><?= $row['firstname'] ?></td>
                                  <td><?= $row['middlename'] ?></td>
                                  <td><?= $row['lastname'] ?></td>
                                  <td><?= $row['course'] ?></td>
                                  <td><?= $row['batch'] ?></td>
                                  <td>
                                    <button class="btn btn-primary" role="button" id="">View</button>
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
const exampleModal = document.getElementById('modalt')

exampleModal.addEventListener('show.bs.modal', function (event) {
  // Button that triggered the modal
  var button = event.relatedTarget
  // Extract info from data-bs-* attributes
  var recipient = button.getAttribute('data-bs-whatever')
  var modalTitle = exampleModal.querySelector('.modal-title')
  var btn = exampleModal.querySelector('#fbtn')

  modalTitle.textContent = recipient + ' Event'
  btn.textContent = recipient
  btn.value = recipient
  if(recipient === 'Edit'){
    
  }
})

$(document).ready(function(e){
  $('#modalform').on('submit',function(e){
    e.preventDefault();

    $.ajax({
      type: 'POST',
      url: 'function/action.php?action='+this.btn.value+'Alumni',
      data: new FormData(this),
      datatype: 'json',
      contentType: false,
      cache: false,
      processData: false,
      error: err => {
        console.log(err)
      },
      success: function(data){
        if(data.error){
          console.log(data.error)
        }else{
          location.reload()
        }
      }
    })
  })
})
                </script>