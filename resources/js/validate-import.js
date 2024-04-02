import { Validator } from "../../js/Validator.js";
let validator = new Validator;
const fileInput = document.getElementById('file-input')
const fileInputErrorMessage = document.getElementById('file-input-error-message')
const importForm = document.getElementById('import-form')
const allowedExtensions = ['.csv', '.xlsx', '.xls'];

fileInput.addEventListener('change', () => {
    if (validator.validateFileType(fileInput, allowedExtensions)) {
        validator.showFileInfo(fileInput)
    } else {
        validator.showFileTypeError(fileInput)
    }
})

importForm.addEventListener('submit', event => {
    event.preventDefault()

    const file = document.getElementById('file-input').value

    const isValidFile = validator.isRequired(file, fileInputErrorMessage)

    if (isValidFile) importForm.submit()
})