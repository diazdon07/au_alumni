                <!-- Event  -->
                <div class="card" id="eventForm" >
                    <div class="card-header">
                        <i class="fa-solid fa-calendar-days"></i> <span class="ms-1 d-sm-inline">Event List</span>
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
                                  <input type="text" class="form-control" name="title" placeholder="Title">
                                </div>
                                <div class="mb-3 text-center">
                                  <img src="../image/image-placeholder.png" alt="image" width="300" class="rounded img-thumbnail" id="image">
                                </div>
                                <div class="mb-3">
                                  <input type="file" class="form-control" accept="image/*" id="imagein" name="file1" >
                                </div>
                                <div class="mb-3">
                                  <input type="date" class="form-control" name="schedule">
                                </div>
                                <div class="mb-3">
                                  <input type="text" class="form-control" name="location" placeholder="Location">
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
                                  <th scope="col">Title</th>
                                  <th scope="col">Schedule</th>
                                  <th scope="col">Location</th>
                                  <th scope="col">Commited To Participate</th>
                                  <th scope="col">Activity</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $result = mysqli_query($conn,'SELECT * FROM `events`');
                                $i = 1;
                                if(mysqli_num_rows($result) > 0){
                                  while($row = mysqli_fetch_assoc($result)):
                                ?>
                                <tr>
                                  <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                  <th scope="row"><?= $i++ ?></th>
                                  <td><?= $row['title'] ?></td>
                                  <td><?= $row['schedule'] ?></td>
                                  <td><?= $row['location'] ?></td>
                                  <td><?= $row['participants'] ?></td>
                                  <td>
                                    <button class="btn btn-primary" type="button" id="view">View</button>
                                    <button class="btn btn-danger" role="button">Delete</button>
                                    <button class="btn btn-warning" role="button">Disable</button>
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
      url: 'function/action.php?action='+this.btn.value+'Event',
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

$('#imagein').on('change', function(event) {
  const file = event.target.files[0];
  if (file) {
    $('#image').attr('src', URL.createObjectURL(file))
  }
})

                </script>