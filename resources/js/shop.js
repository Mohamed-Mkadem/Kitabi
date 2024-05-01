import { toggleOverlay, hideOverlay, preventBodyScroll, allowBodyScroll, asideToggle, closeAside, closeAsideBtn, openAside, productsGrid, listVueToggle, gridVueToggle, addListVue, removeListVue, liveSearch, alert, handlePaginationClick } from './functions.js';
import { Cart } from "./Cart.js";

const categoriesSearchInput = document.getElementById('categories-input')
const authorsSearchInput = document.getElementById('authors-input')
const publishersSearchInput = document.getElementById('publishers-input')
const authorsChoices = Array.from(document.querySelectorAll('.authors-choices .choice'))
const publishersChoices = Array.from(document.querySelectorAll('.publishers-choices .choice'))
const categoriesChoices = Array.from(document.querySelectorAll('.categories-choices .choice'))
liveSearch(categoriesSearchInput, categoriesChoices)
liveSearch(authorsSearchInput, authorsChoices)
liveSearch(publishersSearchInput, publishersChoices)


asideToggle.addEventListener('click', () => {
    openAside()
    toggleOverlay(true)
    preventBodyScroll()
})


closeAsideBtn.addEventListener('click', () => {
    closeAside()
    hideOverlay()
    allowBodyScroll()
})

listVueToggle.addEventListener('click', () => {
    addListVue()
})
gridVueToggle.addEventListener('click', () => {
    removeListVue()
})
const sortInput = document.getElementById('sort-options')
const minPriceInput = document.getElementById('minPrice')
const maxPriceInput = document.getElementById('maxPrice')
const bookInput = document.getElementById('bookName')
const resultsContainer = document.getElementById('results-container')
let authorsInputs = Array.from(document.querySelectorAll('input[name="authors[]"]'))
let categoriesInputs = Array.from(document.querySelectorAll('input[name="categories[]"]'))
let publishersInputs = Array.from(document.querySelectorAll('input[name="publishers[]"]'))

categoriesInputs.forEach(category => {
    category.addEventListener('change', getData)
})
authorsInputs.forEach(author => {
    author.addEventListener('change', getData)
})
publishersInputs.forEach(publisher => {
    publisher.addEventListener('change', getData)
})

sortInput.addEventListener('change', () => {
    getData()
})
minPriceInput.addEventListener('change', () => {
    getData()
})
maxPriceInput.addEventListener('change', () => {
    getData()
})
bookInput.addEventListener('change', () => {
    getData()
})


function getData() {
    let filters = createFilters();
    let queryString = buildQuerySting(filters);
    updateUrl(queryString)
    let url = `http://127.0.0.1:8000/shop/filter?${queryString}`
    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json'
        }

    }).then(res => res.json())
        .then(data => {

            resultsContainer.innerHTML = data.html

        })
        .catch(err => alert('حصل خطأ ما أثناء معالجة الطلب', 'error'));
}


function buildQuerySting(filters) {
    let filtersArray = [];

    for (const key in filters) {
        if (Object.hasOwnProperty.call(filters, key)) {
            const filterValue = filters[key];
            if (typeof filterValue == 'object') {
                if (Object.keys(filterValue).length > 0) {

                    for (const innerKey in filterValue) {
                        if (Object.hasOwnProperty.call(filterValue, innerKey)) {

                            filtersArray.push(`${key}[]=${innerKey}`)
                        }
                    }
                }
            } else {
                filtersArray.push(`${key}=${filterValue}`)
            }
        }
    }

    let queryString = filtersArray.join('&');
    return queryString
}


function createFilters() {
    let sort = sortInput.value
    let minPrice = minPriceInput.value
    let maxPrice = maxPriceInput.value
    let bookName = bookInput.value
    let filters = {
        search: bookName,
        min_price: minPrice,
        max_price: maxPrice,
        sort: sort,
        categories: {}, authors: {}, publishers: {}
    }

    authorsInputs.forEach(author => {
        if (author.checked) {
            let label = author.nextElementSibling
            filters['authors'][author.value] = label.textContent
        }
    })
    publishersInputs.forEach(publisher => {
        if (publisher.checked) {
            let label = publisher.nextElementSibling
            filters['publishers'][publisher.value] = label.textContent
        }
    })
    categoriesInputs.forEach(category => {
        if (category.checked) {
            let label = category.nextElementSibling
            filters['categories'][category.value] = label.textContent
        }
    })


    return filters
}

function updateUrl(queryString) {
    const newUrl = `http://127.0.0.1:8000/shop/filter/?${queryString}`;
    window.history.pushState({ path: newUrl }, '', newUrl);
}

if (resultsContainer) {
    resultsContainer.addEventListener('click', (e) => {
        let target = e.target
        if (target.classList.contains('page-link') && target.tagName == 'A') {
            e.preventDefault()
            let nextPageUrl = target.href
            handlePaginationClick(nextPageUrl, resultsContainer)
        }
    });
}


