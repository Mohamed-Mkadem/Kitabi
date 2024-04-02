import { Validator } from './Validator.js'

let validator = new Validator
const infoForm = document.getElementById('info-form')
const passwordForm = document.getElementById('passwords-form')
infoForm.addEventListener('submit', (event) => {

    event.preventDefault();
    const phone = document.getElementById('phone').value
    const phoneError = document.querySelector('#phone + .error-message');

    const firstName = document.getElementById('first_name').value
    const firstNameError = document.querySelector('#first_name + .error-message');

    const lastName = document.getElementById('last_name').value
    const lastNameError = document.querySelector('#last_name + .error-message');

    const email = document.getElementById('email').value
    const emailError = document.querySelector('#email + .error-message');

    const state = document.getElementById('state-options').value
    const stateError = document.getElementById('state-error')

    const address = document.getElementById('address').value
    const addressError = document.querySelector('#address + .error-message');

    const city = document.getElementById('cities-options').value
    const cityError = document.getElementById('city-error')

    const isFirstNameValid = validator.isRequired(firstName, firstNameError);
    const isLastNameValid = validator.isRequired(lastName, lastNameError);
    const isAddressValid = validator.isRequired(address, addressError)
    const isStateValid = validator.isRequired(state, stateError)
    const isCityValid = validator.isRequired(city, cityError)
    const isEmail = validator.isValidEmail(email, emailError);
    const isPhone = validator.phoneFormat(phone, phoneError);

    if (isEmail && isFirstNameValid && isLastNameValid && isCityValid && isStateValid && isAddressValid && isPhone) {
        infoForm.submit();
    }
});

passwordForm.addEventListener('submit', (event) => {
    event.preventDefault()

    const password = document.getElementById('current-password').value
    const passwordError = document.querySelector('#current-password + .error-message');

    const newPassword = document.getElementById('new-password').value
    const newPasswordError = document.querySelector('#new-password + .error-message');

    const confirmPassword = document.getElementById('confirm-password').value
    const confirmPasswordError = document.querySelector('#confirm-password + .error-message');

    const isPasswordValid = validator.isRequired(password, passwordError)
    const isNewPasswordValid = validator.isRequired(newPassword, newPasswordError)
    const isConfirmPasswordValid = validator.passwordsMatch(newPassword, confirmPassword, confirmPasswordError)

    if (isPasswordValid && isConfirmPasswordValid && isNewPasswordValid) {
        passwordForm.submit()
    }

})