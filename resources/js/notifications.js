import { addError, addLoader, handlePaginationClick } from "./functions.js";

const statuseRadioInputs = Array.from(document.querySelectorAll('input[name=status]')
)
const notificationsContainer = document.getElementById('notifications-container')
statuseRadioInputs.forEach(input => {
    input.addEventListener('change', () => {
        getNotifications(input.value, input.dataset.type)
    })
})


function getNotifications(notificationsStaus, userType) {
    let url = buildUrl(notificationsStaus, userType)
    window.history.pushState({ path: url }, '', url);
    addLoader(notificationsContainer)
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
            notificationsContainer.innerHTML = data.html
        })
        .catch(err => addError(notificationsContainer, err.message));
}

function buildUrl(notificationsStaus, userType) {
    let prefix = userType == 'admin' ? 'dashboard/' : ''


    return `http://127.0.0.1:8000/${prefix}notifications/filter?status=${notificationsStaus}`
}

notificationsContainer.addEventListener('click', (e) => {
    let target = e.target
    if (target.classList.contains('page-link') && target.tagName == 'A') {
        e.preventDefault()
        let nextPageUrl = target.href
        handlePaginationClick(nextPageUrl, notificationsContainer)
    }
});
