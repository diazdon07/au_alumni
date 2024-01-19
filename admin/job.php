                <!-- Job  -->
                <div class="card" id="jobForm" >
                    <div class="card-header">
                        <i class="fa-solid fa-user-tie"></i> <span class="ms-1 d-sm-inline">Jobs List</span>
                        <button class="btn btn-success me-md-2" data-bs-toggle="modal" data-bs-target="#modalt" type="button"
                        data-bs-whatever="Add">+Add</button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="modalt" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-xl">
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
                                  <th scope="col">Job Title</th>
                                  <th scope="col">Company</th>
                                  <th scope="col">Link</th>
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

  modalTitle.textContent = recipient + ' Job'
  btn.textContent = recipient
  btn.value = recipient

  const modalBody = document.querySelector('.modal-body');
  modalBody.innerHTML = '';

  if(recipient === 'Edit'){

    const bodyHTMLData = `
    <div class="mb-3">
      <input type="hidden" name="id" value="${button.getAttribute('data-id')}">
      <input type="text" class="form-control" name="job" placeholder="Job Title" value="${button.getAttribute('data-title')}">
    </div>
    <div class="mb-3">
      <input type="text" class="form-control" name="company" placeholder="Company" value="${button.getAttribute('data-company')}">
    </div>
    <div class="mb-3">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="partT" name="parttime" ${button.getAttribute('data-part') === '1' ? 'checked' : ''}>
        <label class="form-check-label" for="partT">
          Part Time
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="fullT" name="fulltime" ${button.getAttribute('data-full') === '1' ? 'checked' : ''}>
        <label class="form-check-label" for="fullT">
          Full Time
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="conT" name="contractual" ${button.getAttribute('data-cont') === '1' ? 'checked' : ''}>
        <label class="form-check-label" for="conT">
          Contractual
        </label>
      </div>
    </div>
    <div class="mb-3">
      <input type="text" class="form-control" name="shortdesc" placeholder="Short Description" value="${button.getAttribute('data-short')}">
    </div>
    <div class="mb-3">
      <input type="text" class="form-control" name="link" placeholder="Link" value="${button.getAttribute('data-link')}">
    </div>
    <div class="mb-3">
      <textarea class="form-control" name="description" placeholder="Description" rows="3">${button.getAttribute('data-desc')}</textarea>
    </div>
    `;
    modalBody.insertAdjacentHTML('beforeend', bodyHTMLData);
  }else{
    const bodyHTMLData = `
    <div class="mb-3">
      <input type="text" class="form-control" name="job" placeholder="Job Title">
    </div>
    <div class="mb-3">
      <input type="text" class="form-control" name="company" placeholder="Company">
    </div>
    <div class="mb-3">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="partT" name="parttime">
        <label class="form-check-label" for="partT">
          Part Time
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="fullT" name="fulltime">
        <label class="form-check-label" for="fullT">
          Full Time
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="conT" name="contractual">
        <label class="form-check-label" for="conT">
          Contractual
        </label>
      </div>
    </div>
    <div class="mb-3">
      <input type="text" class="form-control" name="shortdesc" placeholder="Short Description">
    </div>
    <div class="mb-3">
      <input type="text" class="form-control" name="link" placeholder="Link">
    </div>
    <div class="mb-3">
      <textarea class="form-control" name="description" placeholder="Full Description" rows="3"></textarea>
    </div>
    `;
    modalBody.insertAdjacentHTML('beforeend', bodyHTMLData);
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
          
        }
      }
    })
  })
})

const jobData = [];

function updateData(data) {
      
  jobData.length = 0;

  data.forEach(job => {
    jobData.push({
      id: job.id,
      job_title: job.job_title,
      company: job.company,
      link: job.link,
      description: job.description,
      shortdesc: job.shortdesc,
      parttime: job.parttime,
      fulltime: job.fulltime,
      contractual: job.contractual
    });    
  });
  updateSource();
}
  
function fetchData() {
  fetch('../php/jobs.php')
  .then(response => response.json()) // Assuming the PHP returns JSON data
  .then(data => {
  
    updateData(data);
  })
  .catch(error => console.error('Error fetching job data:', error));
}

function updateSource(){
  const tableData = document.querySelector('.Tbody');
    tableData.innerHTML = '';
    let i = 1;

    jobData.forEach( data => {
      const tableHTMLData = `
      <tr>
       <th scope="row">${i++}</th>
        <td>${data.job_title}</td>
        <td>${data.company}</td>
        <td>${data.link}</td>
        <td>
          <button class="btn delete btn-danger" data-id="${data.id}" type="button">Delete</button>
          <button class="btn btn-warning" data-bs-target="#modalt" data-bs-toggle="modal" data-id="${data.id}" data-title="${data.job_title}"
          data-company="${data.company}" data-link="${data.link}" data-desc="${data.description}" data-short="${data.shortdesc}" data-part="${data.parttime}" 
          data-full="${data.fulltime}" data-cont="${data.contractual}" data-bs-whatever="Edit" type="button">Edit</button>
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
        url: 'function/action.php?action=DeleteJob',
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
            
          }
        }
        })
      });
    });

}
setInterval(() => {
  fetchData()
}, 500);

})
                </script>