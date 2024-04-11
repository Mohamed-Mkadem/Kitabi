const stateSelect = document.getElementById('state-options')
const citiesSelect = document.getElementById('cities-options')

stateSelect.addEventListener('change', () => {
    getCities(stateSelect.value)
})


function getCities(stateId) {
    let url = `http://127.0.0.1:8000/api/state/${stateId}/cities`

    fetch(url)
        .then(res => res.json())
        .then(cities => updateCities(cities))


        .catch(err => console.log(err))
}

function updateCities(cities) {
    citiesSelect.innerHTML = ''

    let html = ''
    cities.forEach(city => {
        html += `
            <option value="${city.id}"> ${city.name}</option>
        `
    });
    citiesSelect.innerHTML = html
}
