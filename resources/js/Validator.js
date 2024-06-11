export class Validator {
    isRequired(value, errorMessageElement) {
        if (!value.trim()) {
            errorMessageElement.classList.add('show')
            errorMessageElement.textContent = 'هذا الحقل إجباري';
            return false;
        }
        errorMessageElement.classList.remove('show')
        errorMessageElement.textContent = '';
        return true;
    }

    isValidEmail(email, errorMessageElement) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (this.isRequired(email, errorMessageElement)) {

            if (!emailRegex.test(email.trim())) {
                errorMessageElement.textContent = 'البريد الإلكتروني غير صحيح';
                errorMessageElement.classList.add('show')
                return false;
            }
            errorMessageElement.classList.remove('show')
            errorMessageElement.textContent = '';
            return true;
        }

    }

    phoneFormat(value, errorMessageElement) {
        const digitsRegex = /^\d{8}$/;
        if (this.isRequired(value, errorMessageElement)) {

            if (!digitsRegex.test(value.trim())) {
                errorMessageElement.textContent = 'يجب أن يحتوي هذا الحقل على 8 أرقام';
                errorMessageElement.classList.add('show')
                return false;
            }
            errorMessageElement.classList.remove('show')
            errorMessageElement.textContent = '';
            return true;
        }
    }

    passwordsMatch(password, confirmPassword, errorMessageElement) {
        if (password.trim() !== confirmPassword.trim()) {
            errorMessageElement.textContent = 'كلمة المرور غير متطابقة';
            errorMessageElement.classList.add('show')
            return false;
        }
        errorMessageElement.classList.remove('show')
        errorMessageElement.textContent = '';
        return true;
    }

    validateFileType(actualFileInput, allowedExtensions) {
        const file = actualFileInput.files[0]
        if (!file) return false
        const fileName = file.name;
        const extension = '.' + fileName.split('.').pop();
        return allowedExtensions.some(allowedExt => allowedExt.toLowerCase() === extension.toLowerCase());
    }


    showFileTypeError(input) {
        let errorMessage = input.parentElement.nextElementSibling
        let uploadArea = errorMessage.nextElementSibling
        uploadArea.classList.remove('show')
        input.value = ''
        errorMessage.textContent = 'الرجاء اختيار ملف بأحد الامتدادات المذكورة'
        errorMessage.classList.add('show')
    }

    showFileInfo(input) {
        const formControl = input.parentElement.parentElement
        const errorMessage = formControl.querySelector('#file-input-error-message')
        const serverErrorMessage = formControl.querySelector('.error-message.show')
        const uploadArea = formControl.querySelector('.upload-area');
        const fileNameHolder = uploadArea.querySelector('.file-name');
        const fileSizeHolder = uploadArea.querySelector('.file-size');

        // Hide error message and clear its content
        errorMessage.classList.remove('show');
        errorMessage.textContent = '';
        if (serverErrorMessage) serverErrorMessage.textContent = '';

        const file = input.files[0];

        const fileSize = Math.floor(file.size / 1000);
        let fileName = file.name;

        // Truncate long file names
        if (fileName.length > 12) {
            const splitName = fileName.split('.');
            fileName = `${splitName[0].substring(0, 12)}... .${splitName[1]}`;

        }

        // Display file information
        uploadArea.classList.add('show');
        fileNameHolder.textContent = fileName;
        fileSizeHolder.textContent = fileSize > 1000 ? `${Math.floor(fileSize / 1000)} MB` : `${fileSize} KB`;
    }

    isRequiredRadioField(field, errorMessageElement) {
        if (!field) {
            errorMessageElement.classList.add('show')
            errorMessageElement.textContent = 'هذا الحقل إجباري';
            return false;
        }
        errorMessageElement.classList.remove('show')
        errorMessageElement.textContent = '';
        return true;
    }


}





