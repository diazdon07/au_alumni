<?php 
include '../db/dbcon.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AU Cite Alumni Capstone Batch 2023</title>
  <!-- Bootstrap@5.3.2 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <!-- Local css/style.css -->
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
  <!-- modal alert -->
<div class="message-box" id="messageBox">
  <span class="close-button btn-close " role="button"></span>
  <p id="messageText"></p>
</div>

<nav class="navbar navbar-expand-lg navbar-dark bg-crimson bg-gradient">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <h2 class="text-warning">
                <img src="../image/logo.png" alt="logo" width="40rem">
                Admin
            </h2>
            <h6 class="text-white">Alumni Management System</h6>
        </a>
        <div class="navbar container-{breakpoint}">
            <div class="d-none" id="profile">
              <img src="../image/user.png" alt="" width="40rem" id="profileImage">
              <div class="btn-group" style="margin-right: 1rem; margin-left: 1rem;">
                <a class="nav-link dropdown-toggle" href="#" id="profileMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: larger;">
                </a>
                <ul class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="profileMenu">
                  <li><a class="dropdown-item" href="#">Profile Settings</a></li>
                  <li><a class="dropdown-item" href="#" id="logout">Logout</a></li>
                </ul>
              </div>
            </div>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row flex-nowrap">
      <?php 
        include 'navbar.php';
      ?>
    </div>
        <div class="col py-3">
            <div class="container-fluid">
            <?php 
              $page = isset($_GET['page']) ? $_GET['page'] :'dashboard';
              include $page.'.php';
            ?>
            </div>
        </div>
    </div>
</div>
<footer class="bg-dark text-white">@AuCiteAlumniCapstone</footer>
<!-- <script src="../js/token.js"></script> -->
<script>
var profileForm = document.getElementById('profile');
const profileImage = document.querySelector('#profileImage');
const profilename = document.querySelector('#profileMenu');
const logout = document.querySelector('#logout');

var messageText = document.querySelector('#messageText');
var messagePlaceholder = document.querySelector('#messageBox');
  //Alert
const showAlert = (alert, message) => {
    if(alert === 'error'){
        messagePlaceholder.classList.add('bg-danger');
    }else if(alert === 'success'){
        messagePlaceholder.classList.add('bg-success');
    }else{
        messagePlaceholder.classList.add('bg-primary');
    }
    messagePlaceholder.style.display = "inline-block";
    messageText.textContent = message;
  }
  
messagePlaceholder.addEventListener('click', (event) => {
    if (event.target.classList.contains('close-button')) {
        const messageBox = event.target.closest('.message-box');
        if (messageBox) {
            messageBox.style.display = 'none';
            messagePlaceholder.classList.remove('bg-danger');
            messagePlaceholder.classList.remove('bg-success');
            messagePlaceholder.classList.remove('bg-primary');
        }
    }
});

window.onload = () => {
  let user = JSON.parse(sessionStorage.user || null);
  if(user != null){
    if(user.userType != 'admin'){
      location.replace('../index.php');
    }else{
      profileForm.classList.add("d-block");
      profileForm.classList.remove("d-none");
      profilename.innerHTML = `${user.lastname}, ${user.firstname}`;
      if(user.photo !== ''){
        profileImage.src = `../upload/${user.photo}`
      }
      logout.addEventListener('click', () => {
          sessionStorage.clear();
          location.reload();
      })
    }
  }else{
    location.replace('../login_admin.html')
  }
}
</script>
</body>
</html>