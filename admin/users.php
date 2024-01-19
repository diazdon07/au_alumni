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
                                  <th scope="col">Status</th>
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
        displayName: system.displayName,
        email: system.email,
        contact: system.contact,
        status: system.status
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
      const userHTMLData = `
      <tr>
        <th scope="row">${i++}</th>
        <td>${data.displayName}</td>
        <td>${data.email}</td>
        <td>${data.contact}</td>
        <td>${data.status}</td>
        <td>
          <button class="btn btn-danger" role="button">Delete</button>
        </td>
      </tr>
      `;
      tbody.insertAdjacentHTML('beforeend', userHTMLData);
    })
    
  }

  let table = new DataTable('#userTable', {
    responsive: true
  });
  setInterval(() => {
    fetchuserData();
  }, 500);

})
</script>