document.addEventListener('DOMContentLoaded', function () {

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
          profilename.innerHTML = `${user.displayName}`;
          if(user.photo !== null){
          profileImage.src = user.photo
          
          }
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

})