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
                                  <th scope="col">Title</th>
                                  <th scope="col">Schedule</th>
                                  <th scope="col">Commited To Participate</th>
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
  var btn = exampleModal.querySelector('#fbtn')

  modalTitle.textContent = recipient + ' Event'
  btn.textContent = recipient
  btn.value = recipient

  const modalBody = document.querySelector('.modal-body');
  modalBody.innerHTML = '';
  
  if(recipient === 'Edit'){

    const bodyHTMLData = `
    <div class="mb-3">
      <input type="hidden" name="id" value="${button.getAttribute('data-id')}">
      <input type="text" class="form-control" name="title" placeholder="Title" value="${button.getAttribute('data-title')}">
    </div>
    <div class="mb-3 text-center">
      <img src="${button.getAttribute('data-image') !== 'null' ? button.getAttribute('data-image') : '../image/image-placeholder.png'}" alt="image" width="300" class="rounded img-thumbnail" id="images">
    </div>
    <div class="mb-3">
      <input type="file" class="form-control" accept="image/*" id="imagein" name="image">
    </div>
    <div class="mb-3">
      <input type="date" class="form-control" name="schedule" value="${button.getAttribute('data-date')}">
    </div>
    <div class="mb-3 input-group">
      <span class="input-group-text" id="addon-start">Time Start @</span>
      <input type="time" class="form-control" aria-describedby="addon-start" name="timeStart" value="${button.getAttribute('data-timestart')}">
    </div>
    <div class="mb-3 input-group">
      <span class="input-group-text" id="addon-end">Time End @</span>
      <input type="time" class="form-control" aria-describedby="addon-end" name="timeEnd" value="${button.getAttribute('data-timeend')}">
    </div>
    <div class="mb-3">
      <input type="text" class="form-control" name="location" placeholder="Location" value="${button.getAttribute('data-location')}">
    </div>
    <div class="mb-3">
      <textarea class="form-control" name="description" placeholder="Description" rows="3">${button.getAttribute('data-desc')}</textarea>
    </div>
    `;
      modalBody.insertAdjacentHTML('beforeend', bodyHTMLData);
      imageHolder();
  }else{
    const bodyHTMLData = `
    <div class="mb-3">
      <input type="hidden" id="fId">
      <input type="text" class="form-control" name="title" placeholder="Title">
    </div>
    <div class="mb-3 text-center">
      <img src="../image/image-placeholder.png" alt="image" width="300" class="rounded img-thumbnail" id="images">
    </div>
    <div class="mb-3">
      <input type="file" class="form-control" accept="image/*" id="imagein" name="image">
    </div>
    <div class="mb-3">
      <input type="date" class="form-control" name="schedule">
    </div>
    <div class="mb-3 input-group">
      <span class="input-group-text" id="addon-start">Time Start @</span>
      <input type="time" class="form-control" aria-describedby="addon-start" name="timeStart">
    </div>
    <div class="mb-3 input-group">
      <span class="input-group-text" id="addon-end">Time End @</span>
      <input type="time" class="form-control" aria-describedby="addon-end" name="timeEnd">
    </div>
    <div class="mb-3">
      <input type="text" class="form-control" name="location" placeholder="Location">
    </div>
    <div class="mb-3">
      <textarea class="form-control" name="description" placeholder="Description" rows="3"></textarea>
    </div>
    `;
      modalBody.insertAdjacentHTML('beforeend', bodyHTMLData);
      imageHolder();
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

function imageHolder(){
  $('#imagein').on('change', function(event) {
    const file = event.target.files[0];
    if (file) {
      $('#images').attr('src', URL.createObjectURL(file))
    }
  })
}

const eventData = []
const commitedData = []

function updateEventData(data) {
    
  eventData.length = 0;

    data.forEach(event => {
      eventData.push({
        id: event.id,
        date: event.date,
        title: event.title,
        timestart: event.timestart,
        timeend: event.timeend,
        location: event.location,
        description: event.description,
        image: event.image,
        url: event.url
        });    
      });
}

function updateCommitedData(data) {
    
  commitedData.length = 0;
  
    data.forEach(commited => {
      commitedData.push({
        id: commited.id,
        eventId: commited.eventId,
        userId: commited.userId
        });    
      });
}

function fetchData() {
  const eventPromise = fetch('../php/events.php')
    .then(response => response.json()) // Assuming the PHP returns JSON data
    .then(data => {

    updateEventData(data);
    })
  .catch(error => console.error('Error fetching event data:', error));

  const commitedPromise = fetch('../php/commited.php')
    .then(response => response.json()) // Assuming the PHP returns JSON data
    .then(data => {

    updateCommitedData(data);
    })
  .catch(error => console.error('Error fetching commited data:', error));

  Promise.all([eventPromise, commitedPromise])
    .then(() => updateSource());
}

function updateSource(){
  const tableData = document.querySelector('.Tbody');
    tableData.innerHTML = '';
    let i = 1;

    eventData.forEach( data => {
      const commit = commitedData.find(commited => course.eventId === data.id);
      const tableHTMLData = `
      <tr>
        <th scope="row">${i++}</th>
        <td>${data.title}</td>
        <td>${data.date}</td>
        <td class="text-center">${commit ? commit.count : 0}</td>
        <td>
          <button class="btn btn-danger" role="button">Delete</button>
          <button class="btn btn-warning"  data-bs-toggle="modal" data-bs-target="#modalt" data-id="${data.id}" data-title="${data.title}" data-date="${data.date}" data-timestart="${data.timestart}" data-timeend="${data.timeend}"
          data-location="${data.location}" data-desc="${data.description}" data-image="${data.image}" data-url="${data.url}" role="button"  data-bs-whatever="Edit">Edit</button>
        </td>
      </tr>
      `;
      tableData.insertAdjacentHTML('beforeend', tableHTMLData);
    });
    $(document).ready( function() {
      $('#Table').DataTable();
    });
}

fetchData();
})
                </script>