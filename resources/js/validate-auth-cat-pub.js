import { Validator } from "../../js/Validator.js";
let validator = new Validator;
const addNewRecord = document.getElementById('new-record-form')

addNewRecord.addEventListener('submit', (event) => {
    event.preventDefault()

    const nameInput = document.getElementById('name-input').value
    const nameInputErrorMessage = addNewRecord.querySelector('.error-message')

    const isNameValid = validator.isRequired(nameInput, nameInputErrorMessage)

    if (isNameValid) {
        addNewRecord.submit()
    }

})



// Edit Forms
const editForms = Array.from(document.querySelectorAll('.edit-form'))
if (editForms) {

    editForms.forEach(form => {
        form.addEventListener('submit', (e) => {
            e.preventDefault()
            let nameInput = form.querySelector('input[type=text]').value
            let nameInputErrorMessage = form.querySelector('.error-message')
            const isNameValid = validator.isRequired(nameInput, nameInputErrorMessage)

            if (isNameValid) form.submit()

        })
    })
}