const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#inputPassword');

const togglePassword1 = document.querySelector('#togglePassword1');
const password1 = document.querySelector('#test_password_first');
const password2 = document.querySelector('#test_password_second');

togglePassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye / eye slash icon
    this.classList.toggle('bi-eye');
});

togglePassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = password1.getAttribute('type') === 'password' ? 'text' : 'password';
    password1.setAttribute('type', type);
    // toggle the eye / eye slash icon
    this.classList.toggle('bi-eye');
});

togglePassword1.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = password2.getAttribute('type') === 'password' ? 'text' : 'password';
    password2.setAttribute('type', type);
    // toggle the eye / eye slash icon
    this.classList.toggle('bi-eye');
});
