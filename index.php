
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
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/calendarDisplay.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Boxicon -->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<?php 
  include 'db/dbcon.php';
  include 'nav.php';

  $page = isset($_GET['page']) ? $_GET['page'] :'home';
  include $page.'.php';
?>
<footer>@AuCiteAlumniCapstone</footer>
</body>
</html>
<script>
var profileForm = document.getElementById('profile');
var loginForm = document.getElementById('formlogin');
const profileImage = document.querySelector('#profileImage');
const profilename = document.querySelector('#profileMenu');
const logout = document.querySelector('#logout');

window.onload = () => {
  let user = JSON.parse(sessionStorage.user || null);
  if(user != null){
      if(user.userType == 'admin'){
          location.replace('admin/index.php');
      }else{
        loginForm.classList.add("d-none");
        loginForm.classList.remove("d-flex");
        profileForm.classList.add("d-block");
        profileForm.classList.remove("d-none");
        profilename.innerHTML = `${user.lastname}, ${user.firstname}`;
        if(user.photo !== ''){
        profileImage.src = `upload/${user.photo}`
        }
        logout.addEventListener('click', () => {
            sessionStorage.clear();
            location.reload();
        })
      }
    }else{
      loginForm.classList.add("d-flex");
      loginForm.classList.remove("d-none");
      profileForm.classList.add("d-none");
      profileForm.classList.remove("d-block");
    }
}
</script>