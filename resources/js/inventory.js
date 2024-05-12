import { liveSearch, getChoices, showChoices } from "./functions.js";
import { Validator } from "./Validator.js";


const categoriesSearchInput = document.getElementById('categories-input')
const authorsSearchInput = document.getElementById('authors-input')
const publishersSearchInput = document.getElementById('publishers-input')
const authorsChoices = Array.from(document.querySelectorAll('.authors-choices .choice'))
const publishersChoices = Array.from(document.querySelectorAll('.publishers-choices .choice'))
const categoriesChoices = Array.from(document.querySelectorAll('.categories-choices .choice'))

liveSearch(categoriesSearchInput, categoriesChoices)
liveSearch(authorsSearchInput, authorsChoices)
liveSearch(publishersSearchInput, publishersChoices)


let validator = new Validator;
const manageForms = Array.from(document.querySelectorAll('form.manage-form'))

if (manageForms) {
    manageForms.forEach(form => {
        form.addEventListener('submit', event => {
            event.preventDefault()

            let operationInput = form.querySelector('select').value
            let operationInputErrorMessage = Array.from(form.querySelectorAll('.error-message'))[0]
            const isValidOperationType = validator.isRequired(operationInput, operationInputErrorMessage)

            const valueInput = form.querySelector('input[type=number]').value

            let valueInputErrorMessage = Array.from(form.querySelectorAll('.error-message'))[1]

            const isValidValue = validator.isRequired(valueInput, valueInputErrorMessage)
            if (isValidOperationType && isValidValue) {
                form.submit();
            }
        })
    })
}
