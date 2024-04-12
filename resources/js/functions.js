export const quantityInputs = Array.from(document.querySelectorAll('.quantity-holder input'))
export const minusBtns = Array.from(document.querySelectorAll('.quantity-holder button.minus-btn'))
export const plusBtns = Array.from(document.querySelectorAll('.quantity-holder button.plus-btn'))
export let cartDropdown = document.getElementById('cart-content-dropdown')
export const addToCartBtns = Array.from(document.querySelectorAll('.add-to-cart-btn'))
export const overlay = document.getElementById('overlay')
export const dropdowns = Array.from(document.querySelectorAll('.dropdown'))
export const asideToggle = document.getElementById('sidebar-toggle')
export const closeAsideBtn = document.getElementById('close-aside')
export const aside = document.getElementById('shop-aside')
export const navigationMenu = document.getElementById('navigation-menu')
export const navigationMenuToggler = document.getElementById('navigation-menu-toggle')
export const dropDownBtns = Array.from(document.querySelectorAll('.dropdown-btn'));
export const modalHoldersTogglers = Array.from(document.querySelectorAll('.modal-holder-toggler'))
export const modalHolders = Array.from(document.querySelectorAll('.modal-holder'))
export const listVueToggle = document.getElementById('list-vue')
export const gridVueToggle = document.getElementById('grid-vue')
export const productsGrid = document.querySelector('.products-grid');
export const alerts = Array.from(document.querySelectorAll('.alert.show'))
export function listenForAddingProductToCart(cart) {
    addToCartBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            let quantity = (btn.nextElementSibling.querySelector('input[type=number]').value).trim()
            let link = btn.closest('.product').querySelector('h3.title a')

            let product = {
                productId: parseInt(btn.dataset.productId),
                quantity: parseInt(quantity),
                imageUrl: btn.closest('.product').querySelector('.img-holder img').src,
                title: link ? link.textContent : btn.closest('.product').querySelector('h3.title ').textContent,
                price: btn.closest('.product').querySelector('p.price span').textContent * 1000,
                author: btn.closest('.product').querySelector('p.author').textContent,
                publisher: btn.closest('.product').querySelector('p.publisher').textContent,
                availability: true,
            }
            cart.add(product)
            btn.setAttribute('disabled', 'true')
            setTimeout(() => {
                btn.removeAttribute('disabled')
            }, 1000)

        })
    })

}

export function listenForProductRemoval(cart) {
    cartDropdown.addEventListener('click', (e) => {

        if (e.target.classList.contains('remove-btn')) {
            let btn = e.target
            cart.remove(btn.dataset.id)

        }
    })

}
export function decrementQuantity() {
    minusBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            let quantityInput = btn.nextElementSibling
            if (quantityInput.value == 1) return
            quantityInput.value--
        })
    })
}
export function incrementQuantity() {
    plusBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            let quantityInput = btn.previousElementSibling

            quantityInput.value++
        })
    })
}

export function toggleOverlay(dark = null) {
    overlay.classList.toggle('show')
    if (dark) overlay.classList.toggle('dark')
}
export function hideOverlay() {
    overlay.classList.remove('show')
    overlay.classList.remove('dark')

}

export function hideDropDowns() {
    dropdowns.forEach(dropdown => {
        dropdown.classList.remove('show')
    })
}

export function preventBodyScroll() {
    document.body.classList.add('no-scroll');
}
export function allowBodyScroll() {
    document.body.classList.remove('no-scroll');
}

export function openAside() {
    aside.classList.add('show')
}
export function closeAside() {
    aside.classList.remove('show')
}

export function closeNavigationMenu() {
    navigationMenu.setAttribute('aria-expanded', 'false')
    navigationMenuToggler.setAttribute('aria-expanded', 'false')
}

export function openNavigationMenu() {
    navigationMenu.setAttribute('aria-expanded', 'true')
    navigationMenuToggler.setAttribute('aria-expanded', 'true')

}

export function showDropDown(btn) {
    let dropdown = btn.nextElementSibling
    dropdown.classList.toggle('show')
}

export function showModalHolder(btn) {
    let modalHolder = btn.nextElementSibling
    let searchInput = modalHolder.querySelector('input[type=search]')
    modalHolder.classList.toggle('show')
    searchInput.focus()
}

export function closeModalHolder(modalHolder) {
    modalHolder.classList.remove('show')
}

export function addListVue() {
    listVueToggle.setAttribute('aria-selected', 'true')
    gridVueToggle.removeAttribute('aria-selected')
    productsGrid.classList.add('list')
}
export function removeListVue() {
    gridVueToggle.setAttribute('aria-selected', 'true')
    listVueToggle.removeAttribute('aria-selected')
    productsGrid.classList.remove('list')
}


export function removeArias(ariaName, array) {
    array.forEach(item => {
        item.removeAttribute(ariaName)
    })
}
export function addAria(ariaName, element) {
    element.setAttribute(ariaName, 'true');
}
export function removeAria(ariaName, element) {
    element.removeAttribute(ariaName)
}

export function liveSearch(searchInput, choicesArray) {
    searchInput.addEventListener('input', () => {

        getChoices(choicesArray, searchInput)

    });
}

export function getChoices(choicesArray, searchInput) {
    choicesArray.forEach((choice) => {
        const searchText = searchInput.value.toLowerCase(); // Get the typed search text

        const label = choice.querySelector('label');
        const labelValue = label.textContent.toLowerCase();

        if (labelValue.includes(searchText)) {
            // If the state name contains the search text, show the choice
            choice.style.display = 'flex';
        } else {
            // Otherwise, hide the choice
            choice.style.display = 'none';
        }
    });
}

export function showChoices(choicesArray) {
    choicesArray.forEach((choice) => {
        choice.style.display = 'flex'
    })
}

export function hideAlerts() {
    if (alerts) {
        setTimeout(() => {
            alerts.forEach(alert => {
                alert.classList.remove('show')
            })

        }, 5000);
    }
}
export function alert(message, status, duration = 5000) {
    let alertDiv = document.createElement('div')
    alertDiv.className = 'alert show ' + status
    let p = document.createElement('p')
    p.textContent = message
    alertDiv.append(p)
    document.body.append(alertDiv)
    setTimeout(() => {
        let alert = document.querySelector('.alert.show')
        alert.remove()
    }, duration);
}
