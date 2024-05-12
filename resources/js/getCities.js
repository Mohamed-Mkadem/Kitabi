import { alert } from "./functions.js";
const stateSelect = document.getElementById('state-options')
const citiesSelect = document.getElementById('cities-options')

if (stateSelect) {
    stateSelect.addEventListener('change', () => {
        let hasAllOption = stateSelect.classList.contains('has-all')
        console.log(hasAllOption);
        if (stateSelect.value != 'all') {
            getCities(stateSelect.value, hasAllOption)
        }
        else {
            updateCitiesWithAllOption()
        }

    })
}


function getCities(stateId, hasAllOption) {
    let url = `http://127.0.0.1:8000/api/state/${stateId}/cities`

    fetch(url)
        .then(res => {
            if (res.ok) { return res.json() }
            throw Error('حصل خطأ ما أثناء معالجة الطلب الرجاء المحاولة لاحفا')
        })
        .then(cities => updateCities(cities, hasAllOption))
        .catch(err => alert(err.message, 'error'))

}

function updateCities(cities, hasAllOption) {
    citiesSelect.innerHTML = ''

    let html = ''
    if (hasAllOption) html += `<option value="all">الكلّ</option>`
    cities.forEach(city => {
        html += `
            <option value="${city.id}"> ${city.name}</option>
            `
    });
    citiesSelect.innerHTML = html
}

function updateCitiesWithAllOption() {

    citiesSelect.innerHTML = `<option value="all">الكلّ</option>`
}
