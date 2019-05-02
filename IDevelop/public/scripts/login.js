const loginBtn = document.querySelector('.auth .login');
const signupBtn = document.querySelector('.auth .signup');

const loginSection = document.querySelector('#login');
const signupSection = document.querySelector('#signup');

signupBtn.addEventListener('click', function() {
  loginSection.classList.remove('show');
  signupSection.classList.add('show');
  loginBtn.classList.remove('selected');
  signupBtn.classList.add('selected');
});

loginBtn.addEventListener('click', function() {
  signupSection.classList.remove('show');
  loginSection.classList.add('show');
  signupBtn.classList.remove('selected');
  loginBtn.classList.add('selected');
});