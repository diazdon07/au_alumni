<nav class="navbar navbar-expand-lg navbar-dark bg-crimson bg-gradient">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <h2 class="text-warning">
        <img class="imgLogo" alt="logo" width="40rem">
        <span class="systemName"></span>
      </h2>
      <h6 class="text-white">Alumni Management System</h6>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mob-navbar" aria-label="Toggle">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mob-navbar">
      <ul class="navbar-nav mb-2 mb-lg-0 mx-auto">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">About Us</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Contact Us</a>
        </li>
      </ul>
    <div class="navbar container-{breakpoint}">
      <div class="d-none" id="profile">
        <img src="image/user.png" alt="" width="40rem" id="profileImage">
        <div class="btn-group" style="margin-right: 1rem; margin-left: 1rem;">
          <a class="nav-link dropdown-toggle" href="#" id="profileMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: larger;">
          </a>
          <ul class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="profileMenu">
            <li><a class="dropdown-item" href="#">Profile Settings</a></li>
            <li><a class="dropdown-item" href="#" id="logout">Logout</a></li>
          </ul>
        </div>
      </div>
      <form class="d-flex" id="formlogin">
          <button class="btn bg-primary bg-gradient text-white" type="button" id="login">Login</button>
      </form>
    </div>
  </div>
</nav>
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
        if(user.photo !== null){
        profileImage.src = user.photo
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

$('#login').click(function(){
  location.replace('login_student.php');
})
</script>