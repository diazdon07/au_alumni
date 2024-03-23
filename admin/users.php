                <!-- Miantenance -->
                <!-- Users  -->
                <div class="card" id="userForm">
                    <div class="card-header">
                        <i class="fa-solid fa-user-gear"></i> <span class="ms-1 d-sm-inline">Users</span>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover" id="userTable">
                            <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Display name</th>
                                  <th scope="col">Email</th>
                                  <th scope="col">Mobile</th>
                                  <th scope="col" class="text-center">Account Type</th>
                                  <th scope="col">Activity</th>
                                </tr>
                              </thead>
                              <tbody class="userData">
                              </tbody>
                        </table>
                    </div>
                </div>
<script>
document.addEventListener('DOMContentLoaded', function () {

  const userData = [];
  
  function updateuserData(data) {
      
  userData.length = 0; // Clear the existing userData array
  // Push each fetched event to the userData array
    data.forEach(system => {
      userData.push({
        id: system.id,
        displayName: system.displayName,
        email: system.email,
        contact: system.contact,
        status: system.status,
        type: system.type
      });
    });
  
    updateSource();
  
  }
  
  function fetchuserData() {
    fetch('../php/users.php')
    .then(response => response.json()) // Assuming the PHP returns JSON data
    .then(data => {
    // Use the received data as the userData
      updateuserData(data);
    })
    .catch(error => console.error('Error fetching userData data:', error));
  }

  function updateSource(){
    const tbody = document.querySelector('.userData');
    const defaultText = 'No User Data Found.';
    tbody.innerHTML = '';

    let i = 1;

    userData.forEach( data => {

     let accountType = '';
      if(data.type === '0'){
        accountType = `<button class="active-btn btn-type" data-type="2" data-id="${data.id}">Admin</button>`;
      }else if(data.type === '2'){
        accountType = `<button class="pending-btn btn-type" data-type="0" data-id="${data.id}">Sub-Admin</button>`;
      }else{
        accountType = `<div class="student">Student</div>`;
      }

      const userHTMLData = `
      <tr>
        <th scope="row">${i++}</th>
        <td>${data.displayName}</td>
        <td>${data.email}</td>
        <td>${data.contact}</td>
        <td class="text-center">${accountType}</td>
        <td>
          <button class="btn btn-danger delete" data-id="${data.id}" data-type="${data.type}" role="button">Delete</button>
        </td>
      </tr>
      `;
      tbody.insertAdjacentHTML('beforeend', userHTMLData);
    })
    document.querySelectorAll('.delete').forEach(element => {
      element.addEventListener('click', function () {
        
        $.ajax({
        type: 'POST',
        url: 'function/action.php?action=DeleteUser',
        data: {
          id: this.getAttribute('data-id'),
          type: this.getAttribute('data-type')
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
    $(document).ready( function() {
      $('.btn-type').click( function(event) {
        console.log('Account Status Button Click. ID:',event.target.getAttribute('data-id'));
        $.ajax({
          type: 'POST',
          url: 'function/action.php?action=changeType',
          data: {
            id: event.target.getAttribute('data-id'),
            type: event.target.getAttribute('data-type')
          },
          error: err => {
                console.log('Error: ', err);
          },
          success: function(data) {
            console.log('Success data Recieve');
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
  }

  let table = new DataTable('#userTable', {
    responsive: true
  });
    fetchuserData();

})
</script>