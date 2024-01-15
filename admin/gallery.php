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
                                  <input type="hidden" id="fId" name="id">
                                  <input type="text" class="form-control" name="title" id="ftitle" placeholder="Title">
                                </div>
                                <div class="mb-3 text-center">
                                  <img src="../image/image-placeholder.png" alt="image" width="300" class="rounded img-thumbnail" id="image">
                                </div>
                                <div class="mb-3">
                                  <input type="file" class="form-control" accept="image/*" id="imagein" name="image" >
                                </div>
                                <div class="mb-3">
                                  <textarea class="form-control" name="description" id="fdesc" placeholder="Description" rows="3"></textarea>
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
                        <table class="table table-hover" id="tableGallery">
                            <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Image</th>
                                  <th scope="col">Title</th>
                                  <th scope="col">Activity</th>
                                </tr>
                              </thead>
                              <tbody class="galleryTbody">
                                
                              </tbody>
                        </table>
                    </div>
                </div>
                <script>
document.addEventListener('DOMContentLoaded', function () {
  const exampleModal = document.getElementById('modalt')

  exampleModal.addEventListener('show.bs.modal', function (event) {
    // Button that triggered the modal
    var button = event.relatedTarget
    // Extract info from data-bs-* attributes
    var recipient = button.getAttribute('data-bs-whatever')
    var modalTitle = exampleModal.querySelector('.modal-title')
    var btn = exampleModal.querySelector('#fbtn')
    var fid = exampleModal.querySelector('#fId')
    var ftitle = exampleModal.querySelector('#ftitle')
    var fdesc = exampleModal.querySelector('#fdesc')
    var image = exampleModal.querySelector('#image')

    modalTitle.textContent = recipient + ' Gallery'
    btn.textContent = recipient
    btn.value = recipient
    if(recipient === 'Edit'){
      fid.value = button.getAttribute('data-id');
      ftitle.value = button.getAttribute('data-title');
      fdesc.value = button.getAttribute('data-desc');
      if(button.getAttribute('data-image')!==null){
        image.src = button.getAttribute('data-image');
      }
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

  const galleryData = [];

  function updateGalleryData(data) {
      
    galleryData.length = 0; // Clear the existing galleryData array
      // Push each fetched event to the galleryData array
      data.forEach(gallery => {
        galleryData.push({
          id: gallery.id,
          photo: gallery.photo,
          description: gallery.description,
          title: gallery.title
        });    
      });
      updateSource();
  }

  function fetchGalleryData() {
    fetch('../php/galleries.php')
      .then(response => response.json()) // Assuming the PHP returns JSON data
      .then(data => {

      updateGalleryData(data);
      })
    .catch(error => console.error('Error fetching gallery data:', error));
  }

  function updateSource() {
    const tableData = document.querySelector('.galleryTbody');
    tableData.innerHTML = '';
    let i = 1;

    galleryData.forEach( data => {
      const tableHTMLData = `
      <tr>
        <th scope="row">${i++}</th>
        <td><img src="${data.photo || '../image/image-placeholder.png'}" alt="image" width="150" class="rounded img-thumbnail" id="image"></td>
        <td>${data.title}</td>
        <td>
        <button class="btn btn-danger delete" role="button" data-id="${data.id}">Delete</button>
        <button class="btn btn-warning" data-bs-target="#modalt" data-id="${data.id}" data-title="${data.title}" data-desc="${data.description}" data-bs-toggle="modal" 
          data-image="${data.photo || '../image/image-placeholder.png'}" data-bs-whatever="Edit" type="button">Edit</button>
        </td>
      </tr>
      `;
      tableData.insertAdjacentHTML('beforeend', tableHTMLData);
    });
    $(document).ready( function() {
      $('#tableGallery').DataTable();
    });
    document.querySelectorAll('.delete').forEach(element => {
      element.addEventListener('click', function () {
        const topicId = this.getAttribute('data-id');

        $.ajax({
        type: 'POST',
        url: 'function/action.php?action=DeleteGallery',
        data: {
          id: topicId
        },
        error: function(err) {
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
      
      });
    });
  }

  fetchGalleryData();
})
                </script>