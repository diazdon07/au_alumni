<div style="margin: 1rem;">
    <div class="card" style="padding: 1rem; min-height: 30rem;">
        <h6 class="text-muted">Profile Settings</h6>
        <form id="profileAccount">
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
                        <div class="col mb-3">
                            Student No. : <span id="stdno"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5">
                        <input type="text" name="displayName" class="form-control" placeholder="Display Name">
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
                        <div class="col">
                            <input type="text" name="address" class="form-control" placeholder="Address">
                        </div>
                        <div class="col-2">
                            <input type="text" name="city" class="form-control" placeholder="City">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col input-group">
                            <span class="input-group-text" id="addon-course">Course</span>
                            <select name="course" id="courseDD" class="form-control" aria-describedby="addon-course">
                                <option hidden>-Select Course-</option>
                            </select>
                        </div>
                        <div class="col input-group">
                            <span class="input-group-text" id="addon-year">Batch</span>
                            <select class="form-control" aria-describedby="addon-year" name="batch" id="year">
                                <option hidden>-Select Batch Graduated-</option>
                            </select>
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
                            <select name="employmentStatus" id="status" class="form-control">
                                <option hidden>-Select Employement Status-</option>
                                <option value="0">Unemployed</option>
                                <option value="1">Employed</option>
                            </select>
                        </div>
                        <div class="col">
                            <input type="text" name="position" class="form-control emplyStat" placeholder="Position" disabled>
                        </div>
                        <div class="col">
                            <input type="text" name="company" class="form-control emplyStat" placeholder="Company Name" disabled>
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
            <input type="submit" class="btn btn-primary" value="Submit">
        </form>
    </div>
</div>
<script src="js/token.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

var profileForm = document.getElementById('profile');
var loginForm = document.getElementById('formlogin');
const profileImage = document.querySelector('#profileImage');
const profilename = document.querySelector('#profileMenu');
const logout = document.querySelector('#logout');

const courseData = [];
const alumniData = [];
const userData = [];

  window.onload = () =>{
    let user = JSON.parse(sessionStorage.user || null);
    if(user != null){
        if(user.userType == 'admin'){
            location.replace('admin/index.php');
        }else{
          loginForm.classList.add("d-none");
          loginForm.classList.remove("d-flex");
          profileForm.classList.add("d-block");
          profileForm.classList.remove("d-none");
          profilename.innerHTML = `${user.displayName}`;
          
          logout.addEventListener('click', () => {
              sessionStorage.clear();
              location.replace('index.php');
          })
        }
    }else{
      loginForm.classList.add("d-flex");
      loginForm.classList.remove("d-none");
      profileForm.classList.add("d-none");
      profileForm.classList.remove("d-block");
    }
   
  }
    

var ddlYears = document.getElementById("year");
var currentYear = (new Date()).getFullYear();

for (var i = 1950; i <= currentYear; i++) {
    var option = document.createElement("OPTION");
    option.innerHTML = i;
    option.value = i;
    ddlYears.appendChild(option);
}

$('#mobile').keydown(function(event) {
    if(!isNaN(event.key) || event.key === 'Backspace') {
        if($(this).val().length >= 10 && event.key !== 'Backspace'){
            event.preventDefault();
        }
    }else{
        event.preventDefault();       
    }
})

$('#imagein').on('change', function(event) {
    const file = event.target.files[0];
    if (file) {
      $('#imageHolder').attr('src', URL.createObjectURL(file))
    }
})

$('#status').change(function (){
    if ($(this).val() === '0') {
        $('.emplyStat').prop('disabled', true);
        $('.emplyStat').val(null);
    } else {
        $('.emplyStat').prop('disabled', false);
    }
})

function updateAlumniData(data) {

  alumniData.length = 0;

    data.forEach(alumni => {
      alumniData.push({
        id: alumni.id,
        student_number: alumni.student_number,
        firstname: alumni.firstname,
        middlename: alumni.middlename,
        lastname: alumni.lastname,
        gender: alumni.gender,
        address: alumni.address,
        city: alumni.city,
        course: alumni.course,
        batch: alumni.batch,
        photo: alumni.photo,
        status: alumni.status,
        position: alumni.position,
        company: alumni.company
      });
    });
}
  
function updateuserData(data) {
      
  userData.length = 0; 
  
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
}

function updateCoursesData(data) {
    
  courseData.length = 0;

    data.forEach(course => {
      courseData.push({
        id: course.id,
        course: course.course
      });
    });
    courseDropdownData();
}

function fetchCoursesData() {
    const courseFetch = fetch('php/courses.php')
        .then(response => response.json())
        .then(data => {

          updateCoursesData(data);
        })
        .catch(error => console.error('Error fetching courses data:', error));

    const alumniFetch = fetch('php/alumnis.php')
        .then(response => response.json())
        .then(data => {

          updateAlumniData(data);
        })
        .catch(error => console.error('Error fetching alumni data:', error));

    const userFetch = fetch('php/users.php')
        .then(response => response.json())
        .then(data => {

        updateuserData(data);
        })
        .catch(error => console.error('Error fetching userData data:', error));

    Promise.all([courseFetch, alumniFetch, userFetch])
    .then(() => profileData());
}

function courseDropdownData() {
    const ddlCourses = document.getElementById("courseDD");
  
    courseData.forEach(courses => {
        const optionCourses = document.createElement("option");
        optionCourses.innerHTML = courses.course;
        optionCourses.value = courses.id;
        ddlCourses.appendChild(optionCourses);
    });
}

function profileData(){
    let user = JSON.parse(sessionStorage.user || null);

    const profile = alumniData.find(alumni => alumni.id === user.id);

    $('#stdno').html(profile.student_number);
    $('input[name="id"]').val(user.id);
    $('input[name="firstname"]').val(user.firstname);
    $('input[name="middlename"]').val(profile.middlename);
    $('input[name="lastname"]').val(profile.lastname);
    $('input[name="city"]').val(profile.city);
    $('select[name="gender"]').val(profile.gender);
    $('input[name="address"]').val(profile.address);
    $('select[name="course"]').val(profile.course);
    $('select[name="employmentStatus"]').val(profile.status);
    $('input[name="position"]').val(profile.position);
    $('input[name="comapny"]').val(profile.comapny);
    $('#imageHolder').attr('src', profile.photo  || 'https://www.freeiconspng.com/uploads/no-image-icon-6.png');
    $('select[name="batch"]').val(profile.batch);

    $('input[name="email"]').val(user.email);
    $('input[name="contact"]').val(user.contact);

    $('input[name="displayName"]').val(user.displayName);
    if(profile.photo !== null){
    profileImage.src = profile.photo
    }
}

$(document).ready(function(e) {
  $('#profileAccount').on('submit',function(e){
    e.preventDefault();

    $.ajax({
      type: 'POST',
      url: 'php/action.php?action=updateProfile',
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
          console.log(data)
          sessionStorage.clear();
          showMessage('success','Updating profile please wait.');
          setInterval(() => {
            data.authToken = generateToken(data.email);
            sessionStorage.user = JSON.stringify(data);
            location.reload()
          }, 5000);
        }
      }
    })
  })
})

fetchCoursesData();
})
</script>