import { removeAria, addAria, removeArias } from "./functions.js";
const filtersBtns = Array.from(document.querySelectorAll('.tabs-filters ul li button'))

const tabs = Array.from(document.querySelectorAll('.tab'))



const accordionsTogglers = Array.from(document.querySelectorAll('.accordion-header button'))





filtersBtns.forEach(filterBtn => {
    filterBtn.addEventListener('click', () => {
        let BtnDataTab = filterBtn.dataset.index

        removeArias('aria-checked', filtersBtns)
        addAria('aria-checked', filterBtn)
        let tagetTab = document.querySelector(`[data-tab="${BtnDataTab}"]`)
        removeArias('aria-expanded', tabs)
        // tagetTab.setAttribute('aria-expanded', 'true')
        addAria('aria-expanded', tagetTab)
    })
})



accordionsTogglers.forEach(btn => {
    btn.addEventListener('click', () => {
        if (btn.getAttribute('aria-checked') == 'true') {
            removeAria('aria-checked', btn)
            return
        } else {
            removeArias('aria-checked', accordionsTogglers)
            addAria('aria-checked', btn)

        }
    })
})