<nav class="navbar navbar-expand-lg navbar-dark bg-crimson bg-gradient">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <h2 class="text-warning">
        <img class="imgLogo" alt="logo" width="40rem">
        <span class="systemName"></span>
      </h2>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mob-navbar" aria-label="Toggle">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mob-navbar">
      <ul class="navbar-nav mb-2 mb-lg-0 mx-auto">
        <li class="nav-item">
            <a class="nav-link nav-home" aria-current="page" href="index.php?page=home" id="home">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link nav-about" href="index.php?page=about" id="about">About Us</a>
        </li>
      </ul>
    <div class="navbar container-{breakpoint}">
    <?php
    if (!empty($userData)) {
        $displayName = htmlspecialchars($userData['displayName'], ENT_QUOTES, 'UTF-8');
        $displayImage = !empty($userData['photo']) ? $userData['photo'] : 'https://www.freeiconspng.com/uploads/profile-icon-9.png';
        $displayJOB = ($userData['createJob'] !== '0') ? '<a class="dropdown-item" href="index.php?page=createJob">Create Job Offer</a>' : '';
        echo <<<HTML
        <div id="profile">
            <img src="{$displayImage}" alt="Profile image for {$displayName}" class="profileImg" id="profileImage">
            <div class="btn-group" style="margin-right: 1rem; margin-left: 1rem;">
                <a class="nav-link dropdown-toggle text-white" href="#" id="profileMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: larger;">
                {$displayName}
                </a>
                <ul class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="profileMenu">
                    <li>
                      <a class="dropdown-item" href="index.php?page=profileSettings">Profile Settings</a>
                    </li>
                    <li>
                      {$displayJOB}
                    </li>
                    <li>
                      <a class="dropdown-item" href="#" onclick="logoutFunction()" id="logout">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
        HTML;
    } else {
        echo <<<HTML
        <form class="d-flex" id="formlogin">
            <button class="btn bg-primary bg-gradient text-white" type="button" id="login">Login</button>
        </form>
        HTML;
    }
    ?>
    </div>
  </div>
</nav>
<!-- <script src="js/profileData.js"></script> -->

<script>

function logoutFunction(){
  $.ajax({
    type: 'POST',
    url: 'php/action.php?action=logout',
    datatype: 'json',
    contentType: false,
    cache: false,
    processData: false,
    error: function(err) {
      console.log('error: ', err);
    },
    success: function(data){
      console.log(data);
      location.replace('index.php');
    }     
  });
}

document.addEventListener('DOMContentLoaded', function () {

$('.nav_collapse').click(function(){
		console.log($(this).attr('href'))
		$($(this).attr('href')).collapse()
})
  $('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>')

$('#login').click(function(){
  location.replace('login_student.php');
})

// const alumniData = [];

// function updateAlumniData(data) {
    
//     alumniData.length = 0; // Clear the existing eventData array
//       // Push each fetched event to the alumniData array
//     data.forEach(alumni => {
//       alumniData.push({
//         id: alumni.id,
//         student_number: alumni.student_number,
//         firstname: alumni.firstname,
//         middlename: alumni.middlename,
//         lastname: alumni.lastname,
//         gender: alumni.gender,
//         address: alumni.address,
//         city: alumni.city,
//         course: alumni.course,
//         batch: alumni.batch,
//         photo: alumni.photo,
//         jobc: alumni.jobC,
//         forumc: alumni.forumC,
//         commentc: alumni.commentC
//       });
//     });
//     jobCreateRestriction();
//   }

// function fetchData(){
//   const alumniPromise = fetch('php/alumnis.php')
//   .then(response => response.json()) // Assuming the PHP returns JSON data
//   .then(data => {
//     updateAlumniData(data);
//   }).catch(error => console.error('Error fetching alumni data:', error));
// }

// function jobCreateRestriction(){
//   let user = JSON.parse(sessionStorage.user || null);
//   if(user != null){
//     const userData = alumniData.find(alumni => alumni.id === user.id);
//     const ilCreateJob = document.querySelector('#ilCreateJob');
//     ilCreateJob.innerHTML = '';
      
//     if (userData) {
//       if(userData.jobc!=='0'){
//         const ilCreateJobHTMLData = `
//         <a class="dropdown-item" href="index.php?page=createJob">Create Job Offer</a>
//         `;
//         ilCreateJob.insertAdjacentHTML('beforeend', ilCreateJobHTMLData);
//       }
//     }
//   }
  
// }
// setInterval(() => {
//   fetchData();
// }, 1000);

})
</script>