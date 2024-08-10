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
export const toastsHolder = document.querySelector('.toasts-holder')
export const productsContainers = Array.from(document.querySelectorAll('.products-container'))
const notificationsHandler = document.getElementById("notifications-handler");
const notificationsWrapper = document.getElementById("notifications-wrapper");
export function listenForAddingProductToCart(cart) {

    productsContainers.forEach(container => {
        container.addEventListener('click', e => {
            let target = e.target


            if (target.classList.contains('add-to-cart-btn')) {
                let quantity = (target.nextElementSibling.querySelector('input[type=number]').value).trim()
                let link = target.closest('.product').querySelector('h3.title a')

                let product = {
                    productId: parseInt(target.dataset.productId),
                    quantity: parseInt(quantity),
                    imageUrl: target.closest('.product').querySelector('.img-holder img').src,
                    title: link ? link.textContent : target.closest('.product').querySelector('h3.title ').textContent,
                    price: target.closest('.product').querySelector('p.price span').textContent * 1000,
                    author: target.closest('.product').querySelector('p.author').textContent,
                    publisher: target.closest('.product').querySelector('p.publisher').textContent,
                    availability: true,
                }
                let totalQuantity = cart.getProductQuantity(product.productId, product.quantity)

                cart.checkAvailabilityInInventory(product.productId, totalQuantity)

                    .then(res => {
                        if (!res.ok) {
                            throw new Error('حصل خطأ ما أثناء معالجة هذه العمليّة, الرجاء المحاولة لاحقا')
                        }
                        return res.json()
                    })
                    .then(data => {
                        let isAvailable = data.availability
                        let quantity = data.quantity
                        if (!isAvailable && quantity == 0) {
                            alert('للأسف لقد نفد هذا الكتاب من مخازننا', 'error')
                        } else if (!isAvailable && quantity != 0) {
                            alert(` للأسف الكمّية المضافة للسلّة أكثر ممّا هو موجود في مخازننا, لا يمكن تجاوز عدد ${quantity} كتاب `, 'error')

                        } else {
                            cart.add(product)
                            alert('تمّ إضافة الكتاب إلى السلّة بنجاح', 'success')
                            target.setAttribute('disabled', 'true')
                            setTimeout(() => {
                                target.removeAttribute('disabled')
                            }, 1000)
                        }
                    }).catch(err => {
                        alert(err.message, 'error')

                    })


            } else if (target.classList.contains('minus-btn')) {
                let quantityInput = target.nextElementSibling
                if (quantityInput.value == 1) return
                quantityInput.value--
            } else if (target.classList.contains('plus-btn')) {
                let quantityInput = target.previousElementSibling
                quantityInput.value++
            } else if (target.classList.contains('quantity-input')) {
                target.addEventListener('change', () => {
                    if (0 >= target.value) {
                        target.value = 1
                    }
                })
            }
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
    let resultsContainer = document.getElementById('results-container')
    resultsContainer.classList.add('list')
}
export function removeListVue() {
    gridVueToggle.setAttribute('aria-selected', 'true')
    listVueToggle.removeAttribute('aria-selected')
    let resultsContainer = document.getElementById('results-container')
    resultsContainer.classList.remove('list')
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
export function hideToasts() {
    if (toastsHolder) {
        setTimeout(() => {
            toastsHolder.classList.remove('show')
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

export function handlePaginationClick(nextPageUrl, container) {


    fetch(nextPageUrl, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            container.innerHTML = data.html;
            window.history.pushState({ path: nextPageUrl }, '', nextPageUrl);
        })
        .catch(err => alert('حصل خطأ ما أثناء معالجة الطلب', 'error'));
}

export function addLoader(container) {
    container.innerHTML = `<div class="spinner-container">
                        <div class="spinner"></div>
                        <p>جاري التحميل...</p>
                    </div>
                    `
}
export function addError(container, message) {
    container.innerHTML = `<div class="error-container">
    <i class="fa-solid fa-face-frown"></i>
                        <p>${message}</p>
                    </div>
                    `
}


export function showNotification(data) {

    let notificationModal = createNotificationModal(data)

    document.body.append(notificationModal)

    setTimeout(() => {
        notificationModal.classList.remove('show')
    }, 5000);
}

function createNotificationModal(data) {
    let notificationModal = document.createElement("div");
    notificationModal.className = "notification-modal show";
    let notificationModalWrapper = document.createElement("div");
    notificationModalWrapper.className =
        "notification-modal-wrapper p-1 d-flex j-start gap-1 a-start";
    let img = document.createElement("img");
    img.className = "notification-modal-img";
    img.src = `${data.image}`;

    notificationModalWrapper.append(img);
    let notificationModalBody = document.createElement("p");
    notificationModalBody.textContent = data.body;
    notificationModalWrapper.append(notificationModalBody);
    let link = document.createElement("a");
    link.className = "notification-modal-link";
    link.href = ` ${data.url}`;

    notificationModalWrapper.append(link);
    notificationModal.append(notificationModalWrapper);
    return notificationModal
}




export function incrementNotificationsCounter() {
    notificationsHandler.classList.add("has-notifications");
    notificationsHandler.dataset.count =
        (parseInt(notificationsHandler.dataset.count) + 1);

}


export function addTheNewNotificationToTheNotificationsHolder(data) {
    // Create the elements
    const notification = document.createElement("li");
    notification.className = "notification unread";

    const img = document.createElement("img");
    img.src = `${data.image}`;
    img.alt = "";

    const details = document.createElement("div");
    details.className = "details";

    const body = document.createElement("p");
    body.className = "notification-body";
    const link = document.createElement("a");
    link.href = ` ${data.url}`;
    link.textContent = data.body;
    body.appendChild(link);

    const time = document.createElement("p");
    time.className = "notification-time";
    const timeIcon = document.createElement("i");
    timeIcon.className = "fa-regular fa-clock";
    const timestamp = new Date(data.created_at * 1000); // Convert timestamp to milliseconds
    const formattedTime = timestamp.toLocaleString("ar", {
        month: "long",
        day: "numeric",
        year: "numeric",
        hour: "numeric",
        minute: "numeric",
        hour12: false,
    });
    time.innerHTML = `${timeIcon.outerHTML} ${formattedTime}`;

    // Append elements
    details.appendChild(body);
    details.appendChild(time);

    notification.appendChild(img);
    notification.appendChild(details);

    // Prepend the notification to notificationsWrapper

    notificationsWrapper.prepend(notification);

    // Check if there are more than 4 notifications and remove the last one
    const notifications =
        notificationsWrapper.getElementsByClassName("notification");
    if (notifications.length > 4) {
        notifications[notifications.length - 1].remove();
    }
}
