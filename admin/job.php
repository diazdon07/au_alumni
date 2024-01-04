                <!-- Job  -->
                <div class="card" id="jobForm" >
                    <div class="card-header">
                        <i class="fa-solid fa-user-tie"></i> <span class="ms-1 d-sm-inline">Jobs List</span>
                        <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#modalt" type="button"
                        data-bs-whatever="Add">+Add</button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="modalt" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Event</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <form id="modalform" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="mb-3">
                                  <input type="hidden" id="fId">
                                  <input type="text" class="form-control" name="job" placeholder="Job Title">
                                </div>
                                <div class="mb-3">
                                  <input type="text" class="form-control" name="company" placeholder="Company">
                                </div>
                                <div class="mb-3">
                                  <input type="text" class="form-control" name="link" placeholder="Link">
                                </div>
                                <div class="mb-3">
                                  <textarea class="form-control" name="description" placeholder="Description" rows="3"></textarea>
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
                                  <th scope="col">Job Title</th>
                                  <th scope="col">Company</th>
                                  <th scope="col">Link</th>
                                  <th scope="col">Description</th>
                                  <th scope="col">Activity</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $result = mysqli_query($conn,'SELECT * FROM `jobs`');
                                $i = 1;
                                if(mysqli_num_rows($result) > 0){
                                  while($row = mysqli_fetch_assoc($result)):
                                ?>
                                <tr>
                                  <th scope="row"><?= $i++ ?></th>
                                  <td><?= $row['job_title'] ?></td>
                                  <td><?= $row['company'] ?></td>
                                  <td><?= $row['link'] ?></td>
                                  <td><?= $row['description'] ?></td>
                                  <td>
                                    <button class="btn btn-primary" type="button" id="view">View</button>
                                    <button class="btn btn-danger" type="button" id="delete">Delete</button>
                                    <button class="btn btn-warning" data-bs-target="#jobeModal" data-bs-toggle="modal" 
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
$(document).ready(function(e) {
  $('#modalform').on('submit',function(e){
    e.preventDefault();

    $.ajax({
      type: 'POST',
      url: 'function/action.php?action='+this.btn.value+'Job',
      data: new FormData(this),
      datatype: 'json',
      contentType: false,
      cache: false,
      processData: false,
      error: function(err) {
        console.log('error: ', err)
      },
      success: function(data) {
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