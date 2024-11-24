function togglePassword(id, eyeId) {
    var passwordField = document.getElementById(id);
    var eyeIcon = document.getElementById(eyeId);
    if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
    } else {
        passwordField.type = "password";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
    }
}

const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});
loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});

document.addEventListener("DOMContentLoaded", function() {
    const toggleSignupPassword = document.getElementById('toggle-signup-password');
    const signupPassword = document.getElementById('signup-password');
    const toggleSigninPassword = document.getElementById('toggle-signin-password');
    const signinPassword = document.getElementById('signin-password');

    toggleSignupPassword.addEventListener('click', function() {
        togglePassword('signup-password', 'toggle-signup-password');
    });

    toggleSigninPassword.addEventListener('click', function() {
        togglePassword('signin-password', 'toggle-signin-password');
    });
});

