var profileForm = document.getElementById('profile');
var loginForm = document.getElementById('formlogin');
const profileImage = document.querySelector('#profileImage');
const profilename = document.querySelector('#profileMenu');
const logout = document.querySelector('#logout');

window.onload = () => {
    let user = JSON.parse(sessionStorage.user || null);
    if(user != null){
        loginForm.classList.add("d-none");
        loginForm.classList.remove("d-flex");
        profileForm.classList.add("d-block");
        profileForm.classList.remove("d-none");
        profilename.innerHTML = `${user.lastname}, ${user.firstname}`;
        logout.addEventListener('click', () => {
            sessionStorage.clear();
            location.reload();
        })
    }else{
        loginForm.classList.add("d-flex");
        loginForm.classList.remove("d-none");
        profileForm.classList.add("d-none");
        profileForm.classList.remove("d-block");
    }
}