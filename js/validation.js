var exampleModal = document.getElementById("signup"); 

var signUp = document.getElementById('signUp');

var email = document.getElementById('email');
var password = document.getElementById('password');
var firstname = document.getElementById('firstname') || null;
var lastname = document.getElementById('lastname') || null;
var middlename = document.getElementById('middlename') || null;
var gender = document.getElementById('gender') || null;
var address = document.getElementById('address') || null;
var city = document.getElementById('city') || null;
var course = document.getElementById('course') || null;
var batch = document.getElementById('year') || null;
var contact = document.getElementById('contact') || null;
var photo = document.getElementById('photo') || null;

var closeBtn = document.getElementById('close');
var loaderBtn = document.getElementById('btnLoader');

var messageText = document.querySelector('#messageText');
var messagePlaceholder = document.querySelector('#messageBox');
const wrapper = document.createElement('div')

var numbers = /[0-9]/g;
var upperCaseLetters = /[A-Z]/g;
var lowerCaseLetters = /[a-z]/g;

var myCarousel = document.querySelector('#carouselExampleControls')
var carousel = new bootstrap.Carousel(myCarousel, {
  interval: 2000
})

window.onload = function () {
  //Reference the DropDownList.
  var ddlYears = document.getElementById("year");
  //Determine the Current Year.
  var currentYear = (new Date()).getFullYear();
  //Loop and add the Year values to DropDownList.
  for (var i = 1950; i <= currentYear; i++) {
    var option = document.createElement("OPTION");
    option.innerHTML = i;
    option.value = i;
    ddlYears.appendChild(option);
  }
};

// contact number allows only number
var inputField = document.getElementById('contact');
inputField.onkeydown = function(event) {
  // Only allow if the e.key value is a number or if it's 'Backspace'
  if(isNaN(event.key) && event.key !== 'Backspace') {
    event.preventDefault();
  }
};
// password validation
var password = document.getElementById("password");
var lowercase = document.getElementById("lowercase");
var uppercase = document.getElementById("uppercase");
var number = document.getElementById("number");
var length = document.getElementById("length");
var confirmPassword = document.getElementById("confirm-password");
var matchpass = document.getElementById("match");

confirmPassword.onkeyup = function(){
  if(password.value.match(confirmPassword.value)) {
    matchpass.style.display = "none"
  } else {
    matchpass.style.display = "block"
  }
}

password.onblur = function() {
  document.getElementById("message").style.display = "none";
}
password.onfocus = function() {
  document.getElementById("message").style.display = "block";
}
password.onkeyup = function() {
  
  if(password.value.match(lowerCaseLetters)) {
    lowercase.classList.remove("invalid");
    lowercase.classList.add("valid");
  } else {
    lowercase.classList.remove("valid");
    lowercase.classList.add("invalid");
  }
  if(password.value.match(upperCaseLetters)) {
    uppercase.classList.remove("invalid");
    uppercase.classList.add("valid");
  } else {
    uppercase.classList.remove("valid");
    uppercase.classList.add("invalid");
  }
  if(password.value.match(numbers)) {
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }
  if(password.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}

//Alert
const showAlert = (message) => {
    messagePlaceholder.style.display = "inline-block";
    messageText.textContent = message;
  }
  
messagePlaceholder.addEventListener('click', (event) => {
    if (event.target.classList.contains('close-button')) {
        const messageBox = event.target.closest('.message-box');
        if (messageBox) {
            messageBox.style.display = 'none';
        }
    }
});

