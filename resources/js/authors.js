import { alert, handlePaginationClick } from "./functions.js";
const container = document.querySelector('.results-container')
const exportLink = document.getElementById('export-link')
const filterForm = document.getElementById('filter-form')




buildExportUrl()
filterForm.addEventListener('submit', (e) => {
    e.preventDefault()

    let filters = createFilters();
    buildExportUrl()
    let baseUrl = 'http://127.0.0.1:8000/dashboard/authors/filter'
    let url = `${baseUrl}?${new URLSearchParams(filters)}`
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

    return {
        search: searchInputValue,
        sort: sortInpuValuet,
        min_date: minDateInputValue,
        max_date: maxDateInputValue
    }

}


function buildExportUrl() {
    let filters = createFilters()
    let exportUrl = `http://127.0.0.1:8000/dashboard/authors/export?${new URLSearchParams(filters)}`
    exportLink.href = exportUrl
}
