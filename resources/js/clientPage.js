import { removeAria, addAria, removeArias } from "./functions.js";


const filtersBtns = Array.from(document.querySelectorAll('.tabs-filters-grid  li button'))


const tabs = Array.from(document.querySelectorAll('.tab'))



filtersBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        let tabIndex = btn.dataset.index
        removeArias('aria-checked', filtersBtns)
        addAria('aria-checked', btn)
        let targetTab = document.querySelector(`[data-tab="${tabIndex}"]`)
        removeArias('aria-expanded', tabs)
        addAria('aria-expanded', targetTab)
    })
})