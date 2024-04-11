

import { data } from "autoprefixer";
import { Validator } from "./Validator.js";
let validator = new Validator;


const signupForm = document.getElementById('signup-form')

signupForm.addEventListener('submit', function (event) {

    event.preventDefault();

    const firstName = document.getElementById('first_name').value
    const firstNameError = document.querySelector('#first_name + .error-message');

    const lastName = document.getElementById('last_name').value
    const lastNameError = document.querySelector('#last_name + .error-message');

    const email = document.getElementById('email').value
    const emailError = document.querySelector('#email + .error-message');

    const phone = document.getElementById('phone').value
    const phoneError = document.querySelector('#phone + .error-message');
    const address = document.getElementById('address').value
    const addressError = document.querySelector('#address + .error-message');

    const password = document.getElementById('password').value
    const passwordError = document.querySelector('#password + .error-message');

    const confirmPassword = document.getElementById('confirm-password').value
    const confirmPasswordError = document.querySelector('#confirm-password + .error-message');

    const state = document.getElementById('state-options').value
    const stateError = document.getElementById('state-error')


    const city = document.getElementById('cities-options').value
    const cityError = document.getElementById('city-error')

    const isFirstNameValid = validator.isRequired(firstName, firstNameError);
    const isLastNameValid = validator.isRequired(lastName, lastNameError);
    const isAddressValid = validator.isRequired(address, addressError)

    const isPasswordValid = validator.isRequired(password, passwordError);
    const isConfirmPasswordValid = validator.passwordsMatch(password, confirmPassword, confirmPasswordError);

    const isStateValid = validator.isRequired(state, stateError)
    const isCityValid = validator.isRequired(city, cityError)

    const isEmail = validator.isValidEmail(email, emailError);


    const isPhone = validator.phoneFormat(phone, phoneError);


    if (isEmail && isFirstNameValid && isLastNameValid && isPasswordValid && isConfirmPasswordValid && isPhone && isCityValid && isStateValid && isAddressValid) {
        signupForm.submit();
    }
});



