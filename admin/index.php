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

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <!-- Local css/style.css -->
  <link rel="stylesheet" href="../css/style.css">
  
  <!-- Data Tables & jquery 3.6.0 -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
  <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
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
                <img src="../image/logo.png" alt="logo" class="imgLogo" width="40rem">
                Admin
            </h2>
            <h6 class="text-white systemName"></h6>
        </a>
        <div class="navbar container-{breakpoint}">
            <div class="d-none" id="profile">
              <img src="../image/user.png" class="profileImg" alt="" id="profileImage">
              <div class="btn-group" style="margin-right: 1rem; margin-left: 1rem;">
                <a class="nav-link dropdown-toggle text-white" href="#" id="profileMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: larger;">
                </a>
                <ul class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="profileMenu">
                  <li><a class="dropdown-item" href="index.php?page=profileSettings">Profile Settings</a></li>
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
<footer class="bg-dark">
  <h6 class="text-white" style="color: white;">Contact Us:</h6>
  <span class="systemContact text-white"></span>
  <p class="systemEmail text-white"></p>
</footer>
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
    if(user.userType === 0){
      
      const menuItem = document.querySelector('#menu');
      menuItem.innerHTML = '';

      const menuHTMLData = `
      <li>
                        <a href="index.php?page=dashboard" class="nav-link nav-dashboard px-0 align-middle" id="dashboard">
                            <i class="fa-solid fa-gauge"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span> </a>
                    </li>
                            <li class="w-100">
                                <a href="index.php?page=gallery" class="nav-link nav-gallery align-middle px-0" id="gallery">
                                    <i class="fa-solid fa-images"></i> <span class="ms-1 d-none d-sm-inline">Gallery List</span>
                                </a>
                            </li>
                            <li>
                                <a href="index.php?page=course" class="nav-link nav-course align-middle px-0" id="course">
                                    <i class="fa-solid fa-graduation-cap"></i> <span class="ms-1 d-none d-sm-inline">Course List</span>
                                </a>
                            </li>
                            <li>
                                <a href="index.php?page=alumni" class="nav-link nav-alumni align-middle px-0" id="alumni">
                                    <i class="fa-solid fa-user-graduate"></i> <span class="ms-1 d-none d-sm-inline">Alumni List</span>
                                </a>
                            </li>
                            <li>
                                <a href="index.php?page=job" class="nav-link nav-job align-middle px-0" id="job">
                                    <i class="fa-solid fa-user-tie"></i> <span class="ms-1 d-none d-sm-inline">Jobs List</span>
                                </a>
                            </li>
                            <li>
                                <a href="index.php?page=event" class="nav-link nav-event align-middle px-0" id="event">
                                    <i class="fa-solid fa-calendar-days"></i> <span class="ms-1 d-none d-sm-inline">Event List</span>
                                </a>
                            </li>
                            <li>
                                <a href="index.php?page=forum" class="nav-link nav-forum align-middle px-0" id="forum">
                                    <i class="fa-solid fa-comments"></i> <span class="ms-1 d-none d-sm-inline">Forum</span>
                                </a>
                    <li>
                        <a href="#" data-bs-target="#submenu2" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                            <i class="fa-solid fa-gears"></i> <span class="ms-1 d-none d-sm-inline">Maintenance</span> </a>
                        <ul class="collapse nav flex-column ms-1" id="submenu2" data-bs-parent="#menu">
                            <li>
                                <a href="index.php?page=users" class="nav-link nav-users align-middle px-0" id="user">
                                    <i class="fa-solid fa-user-gear"></i> <span class="ms-1 d-none d-sm-inline">Users</span>
                                </a>
                            </li>
                            <li>
                                <a href="index.php?page=system-settings" class="nav-link nav-system-settings align-middle px-0" id="setting">
                                    <i class="fa-solid fa-gear"></i> <span class="ms-1 d-none d-sm-inline">System Settings</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="index.php?page=report" class="nav-link nav-report align-middle px-0" id="report">
                            <i class="fa-brands fa-wpforms"></i> <span class="ms-1 d-none d-sm-inline">Report</span>
                        </a>
                    </li>
      `;

      menuItem.insertAdjacentHTML('beforeend', menuHTMLData);

      profileForm.classList.add("d-block");
      profileForm.classList.remove("d-none");
      profilename.innerHTML = `${user.lastname}, ${user.firstname}`;
      if(user.photo !== null){
        profileImage.src = user.photo
      }
      logout.addEventListener('click', () => {
          sessionStorage.clear();
          
      })
      
    }else if(user.userType === 2){
      const menuItem = document.querySelector('#menu');
      menuItem.innerHTML = '';

      const menuHTMLData = `
      <li>
                        <a href="index.php?page=dashboard" class="nav-link nav-dashboard px-0 align-middle" id="dashboard">
                            <i class="fa-solid fa-gauge"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span> </a>
                    </li>
                            <li class="w-100">
                                <a href="index.php?page=gallery" class="nav-link nav-gallery align-middle px-0" id="gallery">
                                    <i class="fa-solid fa-images"></i> <span class="ms-1 d-none d-sm-inline">Gallery List</span>
                                </a>
                            </li>
                            <li>
                                <a href="index.php?page=course" class="nav-link nav-course align-middle px-0" id="course">
                                    <i class="fa-solid fa-graduation-cap"></i> <span class="ms-1 d-none d-sm-inline">Course List</span>
                                </a>
                            </li>
                            <li>
                                <a href="index.php?page=alumni" class="nav-link nav-alumni align-middle px-0" id="alumni">
                                    <i class="fa-solid fa-user-graduate"></i> <span class="ms-1 d-none d-sm-inline">Alumni List</span>
                                </a>
                            </li>
                            <li>
                                <a href="index.php?page=job" class="nav-link nav-job align-middle px-0" id="job">
                                    <i class="fa-solid fa-user-tie"></i> <span class="ms-1 d-none d-sm-inline">Jobs List</span>
                                </a>
                            </li>
                            <li>
                                <a href="index.php?page=event" class="nav-link nav-event align-middle px-0" id="event">
                                    <i class="fa-solid fa-calendar-days"></i> <span class="ms-1 d-none d-sm-inline">Event List</span>
                                </a>
                            </li>
                            <li>
                                <a href="index.php?page=forum" class="nav-link nav-forum align-middle px-0" id="forum">
                                    <i class="fa-solid fa-comments"></i> <span class="ms-1 d-none d-sm-inline">Forum</span>
                                </a>
                    <li class="nav-item">
                        <a href="index.php?page=report" class="nav-link nav-report align-middle px-0" id="report">
                            <i class="fa-brands fa-wpforms"></i> <span class="ms-1 d-none d-sm-inline">Report</span>
                        </a>
                    </li>
      `;

      menuItem.insertAdjacentHTML('beforeend', menuHTMLData);
      profileForm.classList.add("d-block");
      profileForm.classList.remove("d-none");
      profilename.innerHTML = `${user.lastname}, ${user.firstname}`;
      if(user.photo !== null){
        profileImage.src = user.photo
      }
      logout.addEventListener('click', () => {
          sessionStorage.clear();
          location.reload();
      })
    }else{
      sessionStorage.clear();
      location.replace('../index.php');
    }
  }else{
    sessionStorage.clear();
    location.replace('../login_admin.html');
  }
}

const imgs = document.getElementsByClassName('imgLogo');
const aboutImgs = document.getElementsByClassName('imgAbout');
const name = document.getElementsByClassName('systemName');
const email = document.getElementsByClassName('systemEmail');
const contact = document.getElementsByClassName('systemContact');
const aboutcontent = document.getElementsByClassName('systemContent');

const systemData = [];
  
function updatesystemData(data) {
      
    systemData.length = 0; // Clear the existing systemData array
    // Push each fetched event to the systemData array
    data.forEach(system => {
    systemData.push({
      systemname: system.systemname,
      email: system.email,
      contact: system.contact,
      logo: system.logo,
      aboutimage: system.aboutimage,
      aboutcontent: system.aboutcontent
    });    
    });
    updateSource();
}
  
function fetchsystemData() {
      fetch('../php/system.php')
      .then(response => response.json()) // Assuming the PHP returns JSON data
      .then(data => {

        updatesystemData(data);
      })
      .catch(error => console.error('Error fetching system data:', error));
    }

function updateSource() {

const defaultImageSrc = 'https://www.freeiconspng.com/uploads/no-image-icon-4.png';
const defaultText = 'No Text Data.';

Array.from(imgs).forEach((img) => {
  if (systemData.length === 0 || systemData[0].logo === null) {
    img.src = defaultImageSrc;
  } else {
    img.src = systemData[0].logo;
  }
});

Array.from(aboutImgs).forEach((aboutImg) => {
  if (systemData.length === 0 || systemData[0].aboutimage === null) {
    aboutImg.src = defaultImageSrc;
  } else {
    aboutImg.src = systemData[0].aboutimage;
  }
});

Array.from(name).forEach((names) => {
  if (systemData.length === 0 || systemData[0].systemname === null) {
    names.textContent = defaultText;
  } else {
    names.textContent = systemData[0].systemname;
  }
});

Array.from(email).forEach((emails) => {
  if (systemData.length === 0 || systemData[0].email === null) {
    emails.textContent = defaultText;
  } else {
    emails.textContent = systemData[0].email;
  }
});

Array.from(contact).forEach((contacts) => {
  if (systemData.length === 0 || systemData[0].contact === null) {
    contacts.textContent = defaultText;
  } else {
    contacts.textContent = '(+63)'+systemData[0].contact;
  }
});

Array.from(aboutcontent).forEach((aboutcontents) => {
  if (systemData.length === 0 || systemData[0].aboutcontent === null) {
    aboutcontents.textContent = defaultText;
  } else {
    aboutcontents.textContent = systemData[0].aboutcontent;
  }
});
}
setInterval(() => {
  fetchsystemData();
}, 500);

</script>
</body>
</html>