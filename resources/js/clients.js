
import { liveSearch, getChoices, showChoices } from "./functions.js";


const statesSearchInput = document.getElementById('states-input')
const citiesSearchInput = document.getElementById('cities-input')
const statesChoices = Array.from(document.querySelectorAll('.states-choices .choice'))
const citiesChoices = Array.from(document.querySelectorAll('.cities-choices .choice'))


liveSearch(statesSearchInput, statesChoices)
liveSearch(citiesSearchInput, citiesChoices)