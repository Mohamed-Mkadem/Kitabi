import { Validator } from "./Validator.js";
import { liveSearch } from "./functions.js";

const categoriesSearchInput = document.getElementById('categories-input')
const authorsSearchInput = document.getElementById('authors-input')
const publishersSearchInput = document.getElementById('publishers-input')
const authorsChoices = Array.from(document.querySelectorAll('.authors-choices .choice'))
const publishersChoices = Array.from(document.querySelectorAll('.publishers-choices .choice'))
const categoriesChoices = Array.from(document.querySelectorAll('.categories-choices .choice'))
const bookForm = document.getElementById('book-form')
liveSearch(categoriesSearchInput, categoriesChoices)
liveSearch(authorsSearchInput, authorsChoices)
liveSearch(publishersSearchInput, publishersChoices)


const validator = new Validator

const imageInput = document.getElementById('file-input')
const imageInputErrorMessage = document.getElementById('file-input-error-message')
const allowedExtensions = ['.jpg', '.png']


imageInput.addEventListener('change', () => {
    if (validator.validateFileType(imageInput, allowedExtensions)) {
        validator.showFileInfo(imageInput)
    } else {
        validator.showFileTypeError(imageInput)
    }
})

bookForm.addEventListener('submit', (e) => {

    e.preventDefault()

    let bookName = document.getElementById('name-input').value
    let bookNameErrorMessage = document.querySelector('.name-error-message')

    let bookDescription = document.getElementById('description-input').value
    let bookDescriptionErrorMessage = document.querySelector('.description-error-message')

    let bookCostPrice = document.getElementById('cost-price-input').value
    let bookCostPriceErrorMessage = document.querySelector('.cost-price-error-message')

    let bookPrice = document.getElementById('price-input').value
    let bookPriceErrorMessage = document.querySelector('.price-error-message')

    let bookQuantity = document.getElementById('quantity-input').value
    let bookQuantityErrorMessage = document.querySelector('.quantity-error-message')

    let bookStockAlert = document.getElementById('stock-alert-input').value
    let bookStockAlertErrorMessage = document.querySelector('.stock-alert-error-message')

    let bookStatus = document.querySelector('input[name="status"]:checked')
    let bookStatusErrorMessage = document.querySelector('.status-error-message')

    let bookCategory = document.querySelector('input[name="category_id"]:checked')
    let bookCategoryErrorMessage = document.querySelector('.category-error-message')

    let bookAuthor = document.querySelector('input[name="author_id"]:checked')
    let bookAuthorErrorMessage = document.querySelector('.author-error-message')

    let bookPublisher = document.querySelector('input[name="publisher_id"]:checked')
    let bookPublisherErrorMessage = document.querySelector('.publisher-error-message')



    const isValidBookName = validator.isRequired(bookName, bookNameErrorMessage)

    const isValidBookDescription = validator.isRequired(bookDescription, bookDescriptionErrorMessage)

    const isValidBookPrice = validator.isRequired(bookPrice, bookPriceErrorMessage)

    const isValidBookCostPrice = validator.isRequired(bookCostPrice, bookCostPriceErrorMessage)

    const isValidQuantity = validator.isRequired(bookQuantity, bookQuantityErrorMessage)

    const isValidBookStockAlert = validator.isRequired(bookStockAlert, bookStockAlertErrorMessage)

    const isValidBookStatus = validator.isRequiredRadioField(bookStatus, bookStatusErrorMessage)

    const isValidBookCategory = validator.isRequiredRadioField(bookCategory, bookCategoryErrorMessage)

    const isValidBookAuthor = validator.isRequiredRadioField(bookAuthor, bookAuthorErrorMessage)

    const isValidBookPublisher = validator.isRequiredRadioField(bookPublisher, bookPublisherErrorMessage)

    const isValidBookImage = imageInput.classList.contains('required') ? validator.isRequired(imageInput.value, imageInputErrorMessage) : true
    // const isValidBookImage = true


    if (isValidBookAuthor && isValidBookCategory && isValidBookCostPrice && isValidBookDescription && isValidBookImage && isValidBookName && isValidBookPrice && isValidBookCostPrice && isValidBookStatus && isValidQuantity && isValidBookStockAlert && isValidBookPublisher) bookForm.submit()

})
