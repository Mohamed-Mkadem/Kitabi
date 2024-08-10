import { Validator } from "./Validator.js";
import { alert } from "./functions.js";
const allowedExtensions = ['.png', '.jpg'];
const validator = new Validator;
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
const avatarInput = document.getElementById('avatar-input')

avatarInput.addEventListener('change', (e) => {
    if (validator.validateFileType(avatarInput, allowedExtensions)) {
        let userType = avatarInput.dataset.usertype
        updateProfileAvatar(userType)

    } else {
        avatarInput.value = ''
        alert('الرجاء إختيار صورة ضمن الامتدادات التالية jpeg, png', 'error')
    }
})


function updateProfileAvatar(userType) {
    const formData = new FormData()
    const avatar = avatarInput.files[0]
    formData.set('avatar', avatar)
    let url = buildUrl(userType)
    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            "X-CSRF-TOKEN": csrfToken,
        }
    })
        .then(response => {
            avatarInput.value = ''
            return response.json()
        })
        .then(data => {
            if (data.success) {
                alert(data.success, 'success')
                changeImgSrc(data.photo)
            } else if (data.errors) {
                let avatarErrors = data.errors.avatar
                showErrors(avatarErrors)
            } else {
                throw ('حصل خطأ اثناء تحديث الصورة, الرجاء المحاولة لاحقا')
            }
        })
        .catch(err => alert(err, 'error'));

}

function buildUrl(userType) {
    let prefix = userType == 'admin' ? 'dashboard/' : ''
    return `http://127.0.0.1:8000/${prefix}profile/avatar`

}




function changeImgSrc(newPath) {
    let img = document.getElementById('avatar-image')
    img.src = newPath

    let headerImg = document.getElementById('header-avatar')
    if (headerImg) headerImg.src = newPath
}



function showErrors(errors, duration = 10000) {
    let toastsHolder = document.createElement('div')
    toastsHolder.className = 'toasts-holder show'

    errors.forEach(error => {
        let toastDiv = document.createElement('div')
        toastDiv.className = 'toast show error'
        let p = document.createElement('p')
        p.textContent = error
        toastDiv.append(p)
        toastsHolder.append(toastDiv)
    })
    document.body.append(toastsHolder)
    setTimeout(() => {
        let toastsHolder = document.querySelector('.toasts-holder.show')
        toastsHolder.remove()
    }, duration);

}
