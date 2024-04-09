import { dropdowns, hideDropDowns, overlay, toggleOverlay, hideOverlay, preventBodyScroll, allowBodyScroll, closeAside, aside, navigationMenu, closeNavigationMenu, openNavigationMenu, navigationMenuToggler, showDropDown, dropDownBtns, modalHoldersTogglers, modalHolders, showModalHolder, closeModalHolder, hideAlerts } from './functions.js';

if (window.location.pathname != '/Pages/client/shop.html' && sessionStorage.getItem('filters')) {
    sessionStorage.removeItem('filters')
}

modalHoldersTogglers.forEach(btn => {
    btn.addEventListener('click', () => {
        showModalHolder(btn)
        preventBodyScroll()
    })
})

modalHolders.forEach(modalHolder => {
    modalHolder.addEventListener('click', (e) => {
        if (e.target.classList.contains('modal-holder')) {
            closeModalHolder(e.target)
            allowBodyScroll()
        }
    })
})



navigationMenuToggler.addEventListener('click', () => {
    if (navigationMenu.getAttribute('aria-expanded') == 'false') {
        openNavigationMenu()
        preventBodyScroll()
        toggleOverlay(true)
    }
})


dropDownBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        showDropDown(btn)
        toggleOverlay()
    })
})




if (overlay) {
    overlay.addEventListener('click', () => {
        hideOverlay()
        if (aside) closeAside()
        if (navigationMenu) closeNavigationMenu()
        allowBodyScroll()
        hideDropDowns()
    })
}

hideDropDowns()
hideAlerts()
