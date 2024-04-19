import { liveSearch, getChoices, showChoices, alert, handlePaginationClick } from "./functions.js";
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


// Filter Request

const container = document.querySelector('.results-container')
const exportLink = document.getElementById('export-link')
const filterForm = document.getElementById('filter-form')




if (exportLink) {
    buildExportUrl()
}
if (filterForm) {
    filterForm.addEventListener('submit', (e) => {
        e.preventDefault()

        let filters = createFilters();
        buildExportUrl()


        const queryString = buildQueryString(filters);

        const url = `http://127.0.0.1:8000/dashboard/books/filter?${queryString}`;
        window.history.pushState({ path: url }, '', url);

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            }

        }).then(response => response.json())
            .then(data => {

                container.innerHTML = data.html

            })
            .catch(err => alert('حصل خطأ ما أثناء معالجة الطلب', 'error'));

    })
}


if (container) {
    container.addEventListener('click', (e) => {
        let target = e.target
        if (target.classList.contains('page-link') && target.tagName == 'A') {
            e.preventDefault()
            let nextPageUrl = target.href
            handlePaginationClick(nextPageUrl, container)
        }
    });
}

function createFilters() {
    let searchInputValue = filterForm.querySelector('input[name="search"').value
    let sortInpuValuet = filterForm.querySelector('select[name="sort"').value
    let minDateInputValue = filterForm.querySelector('input[name="min_date"').value
    let maxDateInputValue = filterForm.querySelector('input[name="max_date"').value
    let minPriceInputValue = filterForm.querySelector('input[name="min_price"').value
    let maxPriceInputValue = filterForm.querySelector('input[name="max_price"').value
    let minQuantityInputValue = filterForm.querySelector('input[name="min_quantity"').value
    let maxQuantityInputValue = filterForm.querySelector('input[name="max_quantity"').value
    let authors = filterForm.querySelectorAll('input[name="authors[]"]:checked')
    let categories = filterForm.querySelectorAll('input[name="categories[]"]:checked')
    let publishers = filterForm.querySelectorAll('input[name="publishers[]"]:checked')
    let statuses = filterForm.querySelectorAll('input[name="statuses[]"]:checked')



    let filters = {
        search: searchInputValue,
        sort: sortInpuValuet,
        min_date: minDateInputValue,
        max_date: maxDateInputValue,
        max_quantity: maxQuantityInputValue,
        min_quantity: minQuantityInputValue,
        min_price: minPriceInputValue,
        max_price: maxPriceInputValue,
        authors: {},
        categories: {},
        publishers: {},
        statuses: {}
    }

    authors.forEach(author => {
        filters['authors'][author.id] = author.value
    })
    categories.forEach(category => {
        filters['categories'][category.id] = category.value
    })
    publishers.forEach(publisher => {
        filters['publishers'][publisher.id] = publisher.value
    })
    statuses.forEach(status => {
        filters['statuses'][status.id] = status.value
    })
    return filters

}


function buildExportUrl() {
    let filters = createFilters()
    let queryString = buildQueryString(filters)
    let exportUrl = `http://127.0.0.1:8000/dashboard/books/export?${queryString}`
    exportLink.href = exportUrl
}


function buildQueryString(filters) {
    const filtersArray = [];


    for (const filterKey in filters) {
        if (Object.hasOwnProperty.call(filters, filterKey)) {
            const filterValue = filters[filterKey];

            if (typeof filterValue === 'object') {
                if (Object.keys(filterValue).length > 0) {

                    for (const id in filterValue) {
                        if (Object.hasOwnProperty.call(filterValue, id)) {
                            const element = filterValue[id];
                            filtersArray.push(`${filterKey}[]=${element}`);
                        }
                    }

                }
            } else {

                filtersArray.push(`${filterKey}=${filterValue}`);
            }
        }
    }

    return filtersArray.join('&');
}
