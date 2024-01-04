                <!-- Gallery  -->
                <div class="card" id="galleryForm" >
                    <div class="card-header">
                        <i class="fa-solid fa-images"></i><span class="ms-1 d-sm-inline">Gallery List</span>
                        <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#modalt" type="button"
                        data-bs-whatever="Add">+Add</button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="modalt" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Gallery</h5>
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
                                  <th scope="col">Image</th>
                                  <th scope="col">Title</th>
                                  <th scope="col">Activity</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                 $result = mysqli_query($conn,'SELECT * FROM `gallery`');
                                 $i = 1;
                                 if(mysqli_num_rows($result) > 0){
                                   while($row = mysqli_fetch_assoc($result)):
                                ?>
                                <tr>
                                  <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                  <th scope="row"><?= $i++ ?></th>
                                  <td><img src="../upload/<?= $row['image'] ?>" alt="image" width="150" class="rounded img-thumbnail" id="image"></td>
                                  <td><?= $row['description'] ?></td>
                                  <td>
                                    <button class="btn btn-danger" role="button">Delete</button>
                                    <button class="btn btn-warning" role="button">Edit</button>
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
      url: 'function/action.php?action='+this.btn.value+'Gallery',
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