import { Validator } from "./Validator.js";
let validator = new Validator;


const signupForm = document.getElementById('login-form')

signupForm.addEventListener('submit', function (event) {

    event.preventDefault();
    const email = document.getElementById('email').value
    const emailError = document.querySelector('#email + .error-message');


    const password = document.getElementById('password').value
    const passwordError = document.querySelector('#password + .error-message');

    const isPasswordValid = validator.isRequired(password, passwordError);
    const isEmail = validator.isValidEmail(email, emailError);




    if (isEmail && isPasswordValid) {
        signupForm.submit();
    }
});