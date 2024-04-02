import { Validator } from "./Validator.js";
import { liveSearch } from "./functions.js";
const validator = new Validator

const bookForm = document.getElementById('book-form')


bookForm.addEventListener('submit', event => {
    event.preventDefault()
    // Input Values
    let bookName = document.getElementById('name-input').value
    let description = document.getElementById('description-input').value
    let status = document.querySelector('input[name=status]:checked')
    let quantity = document.getElementById('quantity-input').value
    let stockAlert = document.getElementById('stock-alert-input').value
    let author = document.querySelector('input[name=author]:checked')
    let category = document.querySelector('input[name=category]:checked')
    let publisher = document.querySelector('input[name=publisher]:checked')
    let file = document.getElementById('file-input').value
    let price = document.getElementById('price-input').value
    let costPrice = document.getElementById('cost-price-input').value


    // Error messages
    let bookNameErrorMessage = document.querySelector('.name-error-message')
    let descriptionErrorMessage = document.querySelector('.description-error-message')
    let statusErrorMessage = document.querySelector('.status-error-message')
    let quantityErrorMessage = document.querySelector('.quantity-error-message')
    let priceErrorMessage = document.querySelector('.price-error-message')
    let costPriceErrorMessage = document.querySelector('.cost-price-error-message')
    let stockAlertErrorMessage = document.querySelector('.stock-alert-error-message')
    let fileErrorMessage = document.getElementById('file-input-error-message')
    let authorErrorMessage = document.querySelector('.author-error-message')
    let categoryErrorMessage = document.querySelector('.category-error-message')
    let publisherErrorMessage = document.querySelector('.publisher-error-message')




    const isNameValid = validator.isRequired(bookName, bookNameErrorMessage)
    const isDescriptionValid = validator.isRequired(description, descriptionErrorMessage)
    const isQuantityValid = validator.isRequired(quantity, quantityErrorMessage)
    const isPriceValid = validator.isRequired(price, priceErrorMessage)
    const isCostPriceValid = validator.isRequired(costPrice, costPriceErrorMessage)
    const isStockAlertValid = validator.isRequired(stockAlert, stockAlertErrorMessage)

    const isStatusValid = validator.isRequiredRadioField(status, statusErrorMessage)
    const isAuthorValid = validator.isRequiredRadioField(author, authorErrorMessage)
    const isCategoryValid = validator.isRequiredRadioField(category, categoryErrorMessage)
    const isPublisherValid = validator.isRequiredRadioField(publisher, publisherErrorMessage)

    const isValidFile = validator.isRequired(file, fileErrorMessage)
    if (
        isCostPriceValid && isNameValid && isDescriptionValid && isQuantityValid && isPriceValid && isStockAlertValid &&
        isAuthorValid && isCategoryValid && isStatusValid && isPublisherValid && isValidFile
    ) {
        bookForm.submit()
    }

})

const allowedExtensions = ['.png', '.jpeg', '.jpg'];
const fileInput = document.getElementById('file-input')
fileInput.addEventListener('change', () => {
    if (validator.validateFileType(fileInput, allowedExtensions)) {
        validator.showFileInfo(fileInput)
    } else {
        validator.showFileTypeError(fileInput)
    }
})




const categoriesSearchInput = document.getElementById('categories-input')
const authorsSearchInput = document.getElementById('authors-input')
const publishersSearchInput = document.getElementById('publishers-input')
const authorsChoices = Array.from(document.querySelectorAll('.authors-choices .choice'))
const publishersChoices = Array.from(document.querySelectorAll('.publishers-choices .choice'))
const categoriesChoices = Array.from(document.querySelectorAll('.categories-choices .choice'))

liveSearch(categoriesSearchInput, categoriesChoices)
liveSearch(authorsSearchInput, authorsChoices)
liveSearch(publishersSearchInput, publishersChoices)
