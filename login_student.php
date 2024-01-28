<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Au Cite Alumni Login</title>

    <!-- Bootstrap@5.3.2 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Local css/style.css -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Data Tables & jquery 3.6.0 -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
</head>
<?php
include 'db/dbcon.php';
?>
<body style="background: white;">

    <ul class="notifications"></ul>
    <!-- Login Form -->
    <div class="card box-form" id="login-form">
        <div class="logo">
            <img src="https://www.freeiconspng.com/uploads/no-image-icon-4.png" alt="Simple No Png" class="imgLogo"/>
        </div>
        <h5 class="text-center mt-4">
            Login
        </h5>
        <form>
            <div class="mb-3">
                <input type="email" class="form-control" id="emailLog" placeholder="Email@">
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" id="pwdLog" placeholder="Password">
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
                <button type="button" class="btn btn-primary" id="submit-login">Login</button>
                <button type="button" class="btn btn-danger" id="back">Back</button>
                <!-- <a href="#" id="forgetPassword">Forget password</a> -->
                <a href="#" id="sign-up">Register</a>
            </div>
        </form>
    </div>
    <!-- Forget Password -->
    <div class="card box-form" id="forget-form" style="display: none;">
        <div class="logo">
            <img src="https://www.freeiconspng.com/uploads/no-image-icon-4.png" alt="Simple No Png" class="imgLogo"/>
        </div>
        <h5 class="text-center mt-4">
            Forget Password
        </h5>
        <form>
            <div class="mb-3">
                <input type="email" class="form-control" id="emailForget" placeholder="Email@">
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
                <button type="button" class="btn btn-primary" id="submit-forgetpass">Submit</button>
                <a href="#" class="back-to-login mx-auto">Back</a>
            </div>
        </form>
    </div>
    <!-- Registration Form -->
    <div class="card box-form" id="register-form" style="display: none;">
        <div class="logo">
            <img src="https://www.freeiconspng.com/uploads/no-image-icon-4.png" alt="Simple No Png" class="imgLogo"/>
        </div>
        <h5 class="text-center mt-4">
            Register
        </h5>
        <form>
            <div class="mb-3 input-group">
                <span class="input-group-text" id="addon-number">Student No.</span>
                <input type="text" class="form-control" id="student_number" aria-describedby="addon-number">
            </div>
            <div class="mb-3">
                <select id="gender" class="form-control">
                    <option hidden>-Select Gender-</option>
                    <option value="0">Male</option>
                    <option value="1">Female</option>
                </select>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" id="firstname" placeholder="Firstname">
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" id="middlename" placeholder="Middlename">
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" id="lastname" placeholder="Lastname">
            </div>
            <div class="mb-3 input-group">
                <span class="input-group-text" id="addon-mobile">+63</span>
                <input type="tel" class="form-control" id="mobile" aria-describedby="addon-mobile" placeholder="Mobile">
            </div>
            <div class="mb-3 input-group">
            <span class="input-group-text" id="addon-course">Course</span>
                <select id="course" class="form-control" aria-describedby="addon-course">
                    <option hidden>-Select Course-</option>
                    <?php
                    $result1 = mysqli_query($conn,'SELECT * FROM `courses`');
                    if(mysqli_num_rows($result1) > 0){
                      while($row1 = mysqli_fetch_assoc($result1)):
                    ?>
                    <option value="<?= $row1['id'] ?>"><?= $row1['course'] ?></option>
                    <?php
                      endwhile;
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3 input-group">
                <span class="input-group-text" id="addon-year">Batch</span>
                <select class="form-control" aria-describedby="addon-year" id="year">
                    <option hidden>-Select Batch Graduated-</option>
                </select>
            </div>
            <div class="mb-3 input-group">
                <span class="input-group-text" id="addon-email">@</span>
                <input type="email" class="form-control" id="emailReg" aria-describedby="addon-email" placeholder="Email@example.com">
            </div>
            <div class="mb-3">
                <input type="password" aria-label="Password" id="pwdReg" class="form-control" placeholder="Password">
            </div>
            <div class="mb-3">
                <input type="password" aria-label="Password" id="conPwd" class="form-control" placeholder="Confirm Password">
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
                <button type="button" class="btn btn-primary" id="submit-register">Submit</button>
                <a href="#" class="back-to-login mx-auto">Login</a>
            </div>
        </form>
    </div>
<script src="js/showMessage.js"></script>
<script src="js/token.js"></script>
<script src="js/systemSetting.js"></script>
<script>    
document.addEventListener('DOMContentLoaded', function () {

const loginForm = document.getElementById('login-form');
const registerForm = document.getElementById('register-form');
const forgetPassword = document.getElementById('forget-form');
const firstname = document.getElementById('firstname');
const middlename= document.getElementById('middlename');
const lastname = document.getElementById('lastname');
const gender = document.getElementById('gender');
const mobile = document.getElementById('mobile');
const emailReg = document.getElementById('emailReg');
const pwdReg = document.getElementById('pwdReg');
const student_number = document.getElementById('student_number');
const batch = document.getElementById('year');
const course = document.getElementById('course');
const emailLog = document.getElementById('emailLog');
const pwdLog = document.getElementById('pwdLog');
const conPwd = document.getElementById('conPwd');
const emailForget = document.getElementById('emailForget');

var messageText = document.querySelector('#messageText');
var messagePlaceholder = document.querySelector('#messageBox');

window.onload = () => {
    let user = JSON.parse(sessionStorage.user || null);
    if(user != null){
        if(user.userType !== 'admins'){
            location.replace('index.php');
        }else{
            location.replace('');
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

$('#student_number').keydown(function(event) {
    if(isNaN(event.key) && event.key !== 'Backspace') {
    event.preventDefault();
  }
})

$('#sign-up').click(function() {
    console.log('Click Signup.');
    loginForm.style.display = 'none';
    registerForm.style.display = 'block';
    forgetPassword.style.display = 'none'
})
$('#back').click(function() {
    console.log('Click back.');
    location.replace('index.php');
})
$('.back-to-login').click(function() {
    console.log('Click Back to login.');
    loginForm.style.display = 'block';
    registerForm.style.display = 'none';
    forgetPassword.style.display = 'none';
})
$('#forgetPassword').click(function() {
    console.log('Click Forget Password.');
    loginForm.style.display = 'none';
    registerForm.style.display = 'none';
    forgetPassword.style.display = 'block';
})
$(document).ready(function() {
    var numbers = /[0-9]/g;
    var upperCaseLetters = /[A-Z]/g;
    var lowerCaseLetters = /[a-z]/g;
    //login
  $('#submit-login').click(function() {
    console.log('Click Login.');
    if(!emailLog.value.length || !pwdLog.value.length){
        console.log('No Input email and password.');
        showMessage('error','No Input email and password.');
    }else{
        console.log('Details are ready to process.');
        $.ajax({
            type: 'POST',
            url: 'php/action.php?action=login',
            data: {
                email: emailLog.value,
                password: pwdLog.value,
                userType: 'student'
            },
            error: err => {
                console.log('Error: ', err);
            },
            success: function(data) {
                if(data.error){
                    showMessage('error',data.error);
                }else{
                    console.log('Success data Recieve');
                    if(!data.error){
                        data.authToken = generateToken(data.email);
                        sessionStorage.user = JSON.stringify(data);
                        showMessage('success','Account successfully login.');
                        setInterval(() => {
                        location.replace('index.php')
                        }, 1000);
                    }else{
                        showMessage('error',data.error);
                    }
                }
            }
        })
    }
  })
  //forget password
  $('#submit-forgetpass').click(function() {
    console.log('Click Submit forget password.');
    if(!emailForget.value.length){
        console.log('No email provide.');
        showMessage('error','No email provide.');
    }else{
        console.log('Details are ready to process.');
        $.ajax({
            type: 'POST',
            url: 'action.php?action=forgetPass',
            data: {
                email: emailForget.value,
            },
            error: err => {
                console.log('Error: ', err);
            },
            success: function(data) {
                console.log('Success data Recieve:', data);
            }
        })
    }
  })

const alumniData = [];
const userData = [];

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
      photo: alumni.photo
    });
  });
}
  
function updateUserData(data) {
      
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
}

function fetchData() {
  const alumniFetch = fetch('php/alumnis.php')
    .then(response => response.json()) // Assuming the PHP returns JSON data
    .then(data => {
      // Use the received data as the alumniData
      updateAlumniData(data);
    })
    .catch(error => console.error('Error fetching alumni data:', error));

  const userFetch = fetch('php/users.php')
    .then(response => response.json()) // Assuming the PHP returns JSON data
    .then(data => {
    // Use the received data as the userData
      updateUserData(data);
    })
    .catch(error => console.error('Error fetching userData data:', error));

    Promise.all([alumniFetch,userFetch])
    .then(() => registerCheck());
}

function registerCheck(){
  //registration

  $('#submit-register').click(function() {
    console.log('Click Registration.');

    const checkStdNo = alumniData.filter(alumni => alumni.student_number === student_number.value);
    const checkEmail = userData.filter(user => user.email === emailReg.value);

    if(!batch.value.length || !course.value.length || !student_number.value.length || 
    !emailReg.value.length || !pwdReg.value.length || !firstname.value.length || 
    !lastname.value.length || !mobile.value.length || !conPwd.value.length ||
    !gender.value.length ){
        showMessage('error','Incomplete details.')
        console.log('Incomplete details.');
    }else if(gender.value.length === ''){
        showMessage('error','Please select gender.')
        console.log('Please select gender.');
    }else if(firstname.value.length < 3){
        showMessage('error','Invalid firstname must contain at least 3 letter.')
        console.log('Invalid firstname must contain at least 3 letter.');
    }else if(lastname.value.lenth < 4){
        showMessage('error','Invalid lastname must contain at least 4 letter.')
        console.log('Invalid lastname must contain at least 4 letter.');
    }else if(!pwdReg.value.match(/[A-Z]/g)){
        showMessage('error','Valid Password Must have uppercase letter.')
        console.log('Valid Password Must have uppercase letter.');
    }else if(!pwdReg.value.match(/[a-z]/g)){
        showMessage('error','Valid Password Must have lowecase letter.')
        console.log('Valid Password Must have lowecase letter.');
    }else if(!pwdReg.value.match(/[0-9]/g)){
        showMessage('error','Valid Password Must have at least one number.')
        console.log('Valid Password Must have at least one number.');
    }else if(!pwdReg.value.match(conPwd.value)){
        showMessage('error','Confirm password not match.')
        console.log('Confirm password not match.');
    }else if(checkStdNo.length > 0){
        showMessage('error',`Student No.:${student_number.value} already used.`)
        console.log(`Student No.:${student_number.value} already used.`);
    }else if(checkEmail.length > 0){
        showMessage('error','Email has already used.')
        console.log('Email has already used.');
    }else{
        console.log('Details are ready to process.');
        $.ajax({
            type: 'POST',
            url: 'php/action.php?action=register',
            data: {
                stdno: student_number.value,
                gender: gender.value,
                firstname: firstname.value,
                middlename: middlename.value,
                lastname: lastname.value,
                email: emailReg.value,
                password: pwdReg.value,
                mobile: mobile.value,
                course: course.value,
                batch: batch.value,
                userType: 'student',
                type: '1'
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
                    setTimeout(function(){
                        showMessage('success', data);
                        location.reload();
                    },500)
                }
            }
        })
    }
  })
}

fetchData();
})
})
</script>
</body>
</body>
</html>