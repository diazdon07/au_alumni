                <!-- Forum  -->
                <div class="card" id="forumForm" >
                    <div class="card-header">
                        <i class="fa-solid fa-comments"></i> <span class="ms-1 d-sm-inline">Forum</span>
                        <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#modalt" type="button"
                        data-bs-whatever="Add">+Add</button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="modalt" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Forum</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <form id="modalform" enctype="multipart/form-data">

                          </form>
                        </div>
                      </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-hover align-middle" id="Table">
                            <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Topic</th>
                                  <th scope="col">Created by</th>
                                  <th scope="col">Time Stamp</th>
                                  <th scope="col">Comments</th>
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
const exampleModal = document.getElementById('modalt')

exampleModal.addEventListener('show.bs.modal', function (event) {
  // Button that triggered the modal
  var button = event.relatedTarget
  // Extract info from data-bs-* attributes
  var recipient = button.getAttribute('data-bs-whatever')
  var modalTitle = exampleModal.querySelector('.modal-title')

  modalTitle.textContent = recipient + ' Forum'

  const modalForm = document.querySelector('#modalform');
  modalForm.innerHTML = '';

  if(recipient === 'View'){
    let image = '';

    if(button.getAttribute('data-image')!=='null'){
      image = `<img src="${button.getAttribute('data-image')}" class="img-thumbnail rounded mx-auto d-block" style="width: 30rem;">`;
    }
    
    const bodyHTMLData = `
    <div class="modal-body">
      <div class="mb-3">
        <h2><i class="fa fa-book"></i>${button.getAttribute('data-topic')}</h2>
        <p>By ${button.getAttribute('data-created')} | Posted Date ${button.getAttribute('data-timestamp')}</p>
        <div class="card" style="padding: .5rem;">
          ${image}
          <p>${button.getAttribute('data-content')}</p>
        </div>
      </div>
      <div class="mb-3" id="commentsContent">
      </div>
    </div>
    `;
    modalForm.insertAdjacentHTML('beforeend', bodyHTMLData);
    
  }else{
    const bodyHTMLData = `
    <div class="modal-body">
      <div class="mb-3">
        <input type="hidden" name="id">
        <input type="text" class="form-control" name="topic" placeholder="Topic">
      </div>
      <div class="mb-3 text-center">
        <img src="https://www.freeiconspng.com/uploads/no-image-icon-6.png" alt="image" width="300" class="rounded img-thumbnail" id="images">
      </div>
      <div class="mb-3">
        <input type="file" class="form-control" accept="image/*" id="imagein" name="image">
      </div>
      <div class="mb-3">
        <textarea class="form-control" name="description" placeholder="Description" rows="3"></textarea>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      <input type="submit" class="btn btn-primary" value="${recipient}" name="btn"/>
    </div>
    `;
    modalForm.insertAdjacentHTML('beforeend', bodyHTMLData);
    imageHolder();
  }
})

function imageHolder(){
  $('#imagein').on('change', function(event) {
    const file = event.target.files[0];
    if (file) {
      $('#images').attr('src', URL.createObjectURL(file))
    }
  })
}

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

const forumData = []
const commentData = []

function updateForumData(data){

  forumData.length = 0;

    data.forEach(forum => {
      forumData.push({
        id: forum.id,
        topic: forum.topic,
        img: forum.photo,
        content: forum.content,
        created: forum.created,
        timestamp: forum.timestamp
      });  
    });
}

function updateCommentData(data){

  commentData.length = 0;

    data.forEach(comment => {
      commentData.push({
        id: comment.id,
        forumId: comment.forumId,
        comments: comment.comments,
        studentId: comment.studentId,
        timestamp: comment.timestamp
      });    
    });
}

function fetchData() {
  const forumPromise = fetch('../php/forums.php')
    .then(response => response.json()) // Assuming the PHP returns JSON data
    .then(data => {

    updateForumData(data);
    })
  .catch(error => console.error('Error fetching forum data:', error));

  const commentPromise = fetch('../php/comment.php')
    .then(response => response.json()) // Assuming the PHP returns JSON data
    .then(data => {

    updateCommentData(data);
    })
  .catch(error => console.error('Error fetching comment data:', error));

  Promise.all([forumPromise, commentPromise])
    .then(() => updateSource());
}

function updateSource(){
  const tableData = document.querySelector('.Tbody');
    tableData.innerHTML = '';
    let i = 1;

    forumData.forEach( data => {
      const comment = commentData.filter(comment => comment.forumId === data.id);
      
      const tableHTMLData = `
      <tr>
        <th scope="row" >${i++}</th>
        <td>${data.topic}</td>
        <td>${data.created}</td>
        <td>${data.timestamp}</td>
        <td class="text-center">${comment ? comment.length : 0}</td>
        <td>
          <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modalt" data-bs-whatever="View" data-id="${data.id}"
          data-topic="${data.topic}" data-created="${data.created}" data-timestamp="${data.timestamp}" data-content="${data.content}" data-image="${data.img}">View</button>
          <button class="btn btn-danger delete" data-id="${data.id}" role="button">Delete</button>
        </td>
      </tr>
      `;
      tableData.insertAdjacentHTML('beforeend', tableHTMLData);
    });
    $(document).ready( function() {
      $('#Table').DataTable();
    });
    document.querySelectorAll('.delete').forEach(element => {
      element.addEventListener('click', function () {
        const topicId = this.getAttribute('data-id');

        $.ajax({
        type: 'POST',
        url: 'function/action.php?action=DeleteForum',
        data: {
          id: topicId
        },
        error: function(err) {
          console.log('error: ', err)
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
      
      });
    });
}
  fetchData();

})
                </script>