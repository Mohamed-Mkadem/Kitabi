import { alert, handlePaginationClick, addLoader, addError } from "./functions.js";
const container = document.querySelector('.results-container')
const exportLink = document.getElementById('export-link')
const filterForm = document.getElementById('filter-form')




buildExportUrl()
filterForm.addEventListener('submit', (e) => {
    e.preventDefault()

    let filters = createFilters();
    buildExportUrl()
    let baseUrl = 'http://127.0.0.1:8000/dashboard/publishers/filter'
    let url = `${baseUrl}?${new URLSearchParams(filters)}`
    window.history.pushState({ path: url }, '', url);
    addLoader(container)
    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json'
        }

    }).then(response => {
        if (response.ok) return response.json()
        throw new Error('حصل خطأ ما أثناء معالجة الطلب, الرجاء المحاولة لاحقا')
    }
    )
        .then(data => {
            container.innerHTML = data.html
        })
        .catch(err => addError(container, err.message));

})




container.addEventListener('click', (e) => {
    let target = e.target
    if (target.classList.contains('page-link') && target.tagName == 'A') {
        e.preventDefault()
        let nextPageUrl = target.href
        handlePaginationClick(nextPageUrl, container)
    }
});


function createFilters() {
    let searchInputValue = filterForm.querySelector('input[name="search"').value
    let sortInpuValuet = filterForm.querySelector('select[name="sort"').value
    let minDateInputValue = filterForm.querySelector('input[name="min_date"').value
    let maxDateInputValue = filterForm.querySelector('input[name="max_date"').value
    let minBookCountValue = filterForm.querySelector('input[name="min_books_count"]').value
    let maxBookCountValue = filterForm.querySelector('input[name="max_books_count"]').value

    return {
        min_books_count: minBookCountValue,
        max_books_count: maxBookCountValue,
        search: searchInputValue,
        sort: sortInpuValuet,
        min_date: minDateInputValue,
        max_date: maxDateInputValue
    }

}


function buildExportUrl() {
    let filters = createFilters()
    let exportUrl = `http://127.0.0.1:8000/dashboard/publishers/export?${new URLSearchParams(filters)}`
    exportLink.href = exportUrl
}
