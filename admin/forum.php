                <!-- Forum  -->
                <div class="card" id="forumForm" >
                    <div class="card-header">
                        <i class="fa-solid fa-comments"></i> <span class="ms-1 d-sm-inline">Forum</span>
                        <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#modalt" type="button"
                        data-bs-whatever="Add">+Add</button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="modalt" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Forum</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <form id="modalform" enctype="multipart/form-data">
                            <div class="modal-body">
                                <input type="hidden" name="id" id="id" value="">
                                <input type="hidden" name="creator" id="creator" value="">
                                <div class="mb-3">
                                  <input type="hidden" id="fId">
                                  <input type="text" class="form-control" name="topic" placeholder="Topic">
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
                                  <th scope="col">Topic</th>
                                  <th scope="col">Description</th>
                                  <th scope="col">Created by</th>
                                  <th scope="col">Comments</th>
                                  <th scope="col">Activity</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $result = mysqli_query($conn,'SELECT * FROM `forums`');
                                $i = 1;
                                if(mysqli_num_rows($result) > 0){
                                  while($row = mysqli_fetch_assoc($result)):
                                ?>
                                <tr>
                                  <th scope="row"><?= $i++ ?></th>
                                  <td><?= $row['topic'] ?></td>
                                  <td><?= $row['description'] ?></td>
                                  <td><?= $row['created'] ?></td>
                                  <td><?= $row['comment'] ?></td>
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
      url: 'function/action.php?action='+this.btn.value+'Forum',
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