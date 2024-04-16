import { toggleOverlay, hideOverlay, preventBodyScroll, allowBodyScroll, asideToggle, closeAside, closeAsideBtn, openAside, productsGrid, listVueToggle, gridVueToggle, addListVue, removeListVue } from './functions.js';

const categoriesSearchInput = document.getElementById('categories-input')
const authorsSearchInput = document.getElementById('authors-input')
const publishersSearchInput = document.getElementById('publishers-input')
const authorsChoices = Array.from(document.querySelectorAll('.authors-choices .choice'))
const publishersChoices = Array.from(document.querySelectorAll('.publishers-choices .choice'))
const categoriesChoices = Array.from(document.querySelectorAll('.categories-choices .choice'))

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
const minPriceInput = document.getElementById('minPrice')
const maxPriceInput = document.getElementById('maxPrice')
const bookInput = document.getElementById('bookName')
const selectedFiltersWrapper = document.getElementById('selected-filters-wrapper');

function updateSelectedFilterArea(filters) {
    let html = '';
    for (let filterKey in filters) {
        let filterValue = filters[filterKey];

        if (typeof filterValue === 'object') {
            html += createFilterItemForArray(filterKey, filterValue);
        } else {
            html += createFilterItemForSingleValue(filterKey, filterValue);
        }
    }
    selectedFiltersWrapper.innerHTML = html;
}

let filters = {};
if (sessionStorage.getItem('filters')) {
    filters = JSON.parse(sessionStorage.filters)

    setTheFiltersInputsValues(filters)
} else {
    filters = {
        categories: {},
        authors: {},
        publishers: {},

    }
}


function setTheFiltersInputsValues(filters) {
    for (let prop in filters) {
        if (typeof filters[prop] == 'object') {


            for (let id in filters[prop]) {
                let checkbox = document.getElementById(id)
                if (checkbox) checkbox.checked = true
            }
        } else {
            let input = document.getElementById(prop)
            if (input) input.value = decodeURI(filters[prop])
        }
    }
    updateSelectedFilterArea(filters)
}

function updateFilters() {
    const filtersArray = [];


    for (const filterKey in filters) {
        if (Object.hasOwnProperty.call(filters, filterKey)) {
            const filterValue = filters[filterKey];

            if (typeof filterValue === 'object') {
                if (Object.keys(filterValue).length > 0) {


                    const filterValuesArray = Object.keys(filterValue);
                    filtersArray.push(`${filterKey}=${filterValuesArray.join(`&${filterKey}=`)}`);
                }
            } else {

                filtersArray.push(`${filterKey}=${filterValue}`);
            }
        }
    }


    const queryString = filtersArray.join('&');
    sessionStorage.setItem('filters', JSON.stringify(filters))
    const newUrl = `${window.location.pathname}?${queryString}`;
    window.history.pushState({ path: newUrl }, '', newUrl);
    updateSelectedFilterArea(filters)
}



minPriceInput.addEventListener('change', () => {
    filters.minPrice = minPriceInput.value
    updateFilters()
})
maxPriceInput.addEventListener('change', () => {
    filters.maxPrice = maxPriceInput.value
    updateFilters()
})
bookInput.addEventListener('change', () => {
    filters.bookName = encodeURIComponent(bookInput.value)
    updateFilters()
})




function handleCheckboxChange(checkbox, filterType) {
    checkbox.addEventListener('change', function () {

        if (checkbox.checked) {
            filters[filterType][checkbox.id] = checkbox.value;
        } else {
            delete filters[filterType][checkbox.id];
        }

        updateFilters();
    });
}

const authorsInputs = document.querySelectorAll('input[name="authors[]"]');
authorsInputs.forEach(function (author) {
    handleCheckboxChange(author, 'authors');
});

const publishersInputs = document.querySelectorAll('input[name="publishers[]"]');
publishersInputs.forEach(function (publisher) {
    handleCheckboxChange(publisher, 'publishers');
});

const categoriesInputs = document.querySelectorAll('input[name="categories[]"]');
categoriesInputs.forEach(function (category) {
    handleCheckboxChange(category, 'categories');
});




function createFilterItemForArray(filterKey, filterValue) {
    let innerHtml = '';
    for (let innerFilter in filterValue) {
        innerHtml += createFilterItem(innerFilter, filterKey, filterValue[innerFilter]);
    }
    return innerHtml;
}

function createFilterItemForSingleValue(filterKey, filterValue) {
    let textContent = '';
    switch (filterKey) {
        case 'minPrice':
            textContent = ` أكثر من  : ${filterValue} د.ت `;
            break;
        case 'maxPrice':
            textContent = ` أقلّ من  : ${filterValue}  د.ت `;
            break;
        default:
            textContent = ` اسم الكتاب : ${decodeURIComponent(filterValue)} `;
            break;
    }

    return createFilterItem(filterKey, filterKey, textContent);
}

function createFilterItem(id, dataFilter, textContent) {
    return `<div class="filter-item">
                <p>${textContent}</p>
                <button class="remove-item" data-id="${id}" data-filter="${dataFilter}">
                    <i class="fa-solid fa-close"></i>
                </button>
            </div>`;
}

const clearAllFiltersBtn = document.getElementById('clear-all')
clearAllFiltersBtn.addEventListener('click', () => {
    filters = {
        categories: {},
        authors: {},
        publishers: {},
    }
    resetAllFilters()
    sessionStorage.filters = JSON.stringify({ categories: {}, authors: {}, publishers: {} })
    resetSearchInputs()
    showChoices(categoriesChoices)
    showChoices(publishersChoices)
    showChoices(authorsChoices)
    updateFilters()
    updateSelectedFilterArea(filters)
})

function resetSearchInputs() {
    categoriesSearchInput.value = ''
    authorsSearchInput.value = ''
    publishersSearchInput.value = ''

}

selectedFiltersWrapper.addEventListener('click', e => {
    if (e.target.classList.contains('remove-item')) {
        let target = e.target
        if (target.dataset.id == target.dataset.filter) {
            const inputElement = document.getElementById(target.dataset.id);

            if (inputElement) {
                inputElement.type == 'search' ? inputElement.value = '' : inputElement.value = 0
            }
            delete filters[target.dataset.id]

        } else {
            const inputElement = document.getElementById(target.dataset.id);
            if (inputElement) {
                inputElement.checked = false

            }
            delete filters[target.dataset.filter][target.dataset.id]
        }
        updateFilters()
        sessionStorage.filters = JSON.stringify(filters)
        updateSelectedFilterArea(filters)
    }
})

function resetAllFilters() {
    const checkboxChoices = document.querySelectorAll('.choices-wrapper input[type="checkbox"]:checked')
    checkboxChoices.forEach(checkbox => {
        checkbox.checked = false
    })
    minPriceInput.value = 0
    maxPriceInput.value = 0
    bookInput.value = ''
}



function liveSearch(searchInput, choicesArray) {
    searchInput.addEventListener('input', () => {

        getChoices(choicesArray, searchInput)

    });
}

liveSearch(categoriesSearchInput, categoriesChoices)
liveSearch(authorsSearchInput, authorsChoices)
liveSearch(publishersSearchInput, publishersChoices)

function getChoices(choicesArray, searchInput) {
    choicesArray.forEach((choice) => {
        const searchText = searchInput.value.toLowerCase(); // Get the typed search text

        const label = choice.querySelector('label');
        const stateName = label.textContent.toLowerCase();

        if (stateName.includes(searchText)) {
            // If the state name contains the search text, show the choice
            choice.style.display = 'flex';
        } else {
            // Otherwise, hide the choice
            choice.style.display = 'none';
        }
    });
}

function showChoices(choicesArray) {
    choicesArray.forEach((choice) => {
        choice.style.display = 'flex'
    })
}
