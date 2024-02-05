<form class="card" id="accountForm">
    <div class="card-header">
        <i class="fa-solid fa-gear"></i> <span class="ms-1 d-sm-inline">Profile Settings</span>
    </div>
    <div class="card-body">
    <div class="row">
                <div class="col-3">
                    <input type="hidden" name="id">
                    <div class="mb-3">
                        <img src="https://www.freeiconspng.com/uploads/no-image-icon-6.png" alt="image" width="300" class="rounded img-thumbnail" id="imageHolder">
                    </div>
                    <div class="mb-3">
                        <input type="file" class="form-control" accept="image/*" id="imagein" name="image" >
                    </div>
                </div>
                <div class="col">
                    <div class="row">
                        <div class="col">
                            <input type="text" name="displayName" class="form-control" placeholder="Display Name">
                        </div>
                        <div class="col">
                            <select name="gender" class="form-control">
                                <option hidden>-Select Gender-</option>
                                <option value="0">Male</option>
                                <option value="1">Female</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <input type="text" name="firstname" class="form-control" placeholder="First Name">
                        </div>
                        <div class="col">
                            <input type="text" name="middlename" class="form-control" placeholder="Middle Name">
                        </div>
                        <div class="col">
                            <input type="text" name="lastname" class="form-control" placeholder="Last Name">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col input-group">
                            <span class="input-group-text" id="addon-email">@</span>
                            <input type="email" class="form-control" aria-describedby="addon-email" name="email" placeholder="Email@example.com">
                        </div>
                        <div class="col input-group">
                            <span class="input-group-text" id="addon-mobile">+63</span>
                            <input type="tel" class="form-control" name="contact" id="mobile" aria-describedby="addon-mobile" placeholder="Mobile">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <input type="password" aria-label="Password" name="password" class="form-control" placeholder="Change Password">
                        </div>
                        <div class="col">
                            <input type="password" aria-label="Password" id="conPwd" class="form-control" placeholder="Confirm Password">
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div class="card-footer">
        <input type="submit" class="btn btn-primary" value="Submit">
    </div>
</form>
<script src="../js/token.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

$('#mobile').keydown(function(event) {
    if(!isNaN(event.key) || event.key === 'Backspace') {
        if($(this).val().length >= 10 && event.key !== 'Backspace'){
            event.preventDefault();
        }
    }else{
        event.preventDefault();       
    }
})

const adminData = [];

function updateAdminData(data) {
    
    adminData.length = 0; // Clear the existing eventData array
      // Push each fetched event to the alumniData array
    data.forEach(admin => {
      adminData.push({
        id: admin.id,
        firstname: admin.firstname,
        middlename: admin.middlename,
        lastname: admin.lastname,
        gender: admin.gender,
        photo: admin.photo
      });
    });
}

function fetchCoursesData() {
    const adminFetch = fetch('../php/admins.php')
        .then(response => response.json())
        .then(data => {

            updateAdminData(data);
        })
        .catch(error => console.error('Error fetching courses data:', error));

    adminFetch.then(() => profileData());
}

function profileData() {
    let user = JSON.parse(sessionStorage.user);

    const profileDetails = adminData.find(admin => admin.id === user.id);

    $('input[name="id"]').val(profileDetails.id);
    $('input[name="firstname"]').val(profileDetails.firstname);
    $('input[name="middlename"]').val(profileDetails.middlename);
    $('input[name="lastname"]').val(profileDetails.lastname);
    $('select[name="gender"]').val(profileDetails.gender);
    $('#imageHolder').attr('src', profileDetails.photo || 'https://www.freeiconspng.com/uploads/no-image-icon-6.png');

    $('input[name="email"]').val(user.email);
    $('input[name="contact"]').val(user.contact);

    $('input[name="displayName"]').val(user.displayName);
}

fetchCoursesData();

$('#imagein').on('change', function(event) {
    const file = event.target.files[0];
    if (file) {
      $('#imageHolder').attr('src', URL.createObjectURL(file))
    }
})

$(document).ready(function(e) {
  $('#accountForm').on('submit',function(e){
    e.preventDefault();

    $.ajax({
      type: 'POST',
      url: 'function/action.php?action=updateProfile',
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
          showMessage('erorr',data.error);
        }else{
          showMessage('success','Your account successfull change.');
          data.authToken = generateToken(data.email);
          sessionStorage.user = JSON.stringify(data);
          setInterval(() => {
            location.reload();
          }, 5000);
        }
      }
    })
  })
})

})
</script>