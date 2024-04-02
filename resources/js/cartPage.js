import { Cart } from './Cart.js'

let cart = new Cart

let cartContainer = cart.cartContainer




cartContainer.addEventListener('click', e => {
    // Product removal logic
    if (e.target.classList.contains('remove-btn')) {
        let targetTr = e.target.closest('tr')

        if (cart.remove(targetTr.dataset.product)) {
            targetTr.remove()
            cart.updateCartDetailsHolder()
            if (cart.isEmpty()) {

                cart.printOnPage()
            }
        } else {
            cart.generateAlertHtml('error', 'حصل خطأ ما أثناء حذف المنتج. الرجاء المحاولة لاحقا')
            setTimeout(() => {
                let alert = document.querySelector('.alert.show')
                alert.remove()
            }, 3000);
        }
    }

    // Quantity update logic
    if (e.target.classList.contains('plus-btn')) {
        let targetTr = e.target.closest('tr')
        let quantityInput = e.target.previousElementSibling
        let totalPriceTd = targetTr.querySelector('.total-td')
        let existingProduct = cart.has(cart.getCart(), targetTr.dataset.product)
        if (existingProduct) {
            quantityInput.value++
            cart.update(existingProduct, 1, 'increment')

            totalPriceTd.textContent = cart.productTotal(existingProduct.index)
            cart.updateCartDetailsHolder()
        } else {
            cart.generateAlertHtml('error', 'حصل خطأ ما أثناء تحديث كمّية المنتج. الرجاء المحاولة لاحقا')
            setTimeout(() => {
                let alert = document.querySelector('.alert.show')
                alert.remove()
            }, 3000);
        }
    }
    if (e.target.classList.contains('minus-btn')) {
        let targetTr = e.target.closest('tr')
        let quantityInput = e.target.nextElementSibling
        let totalPriceTd = targetTr.querySelector('.total-td')


        let existingProduct = cart.has(cart.getCart(), targetTr.dataset.product)
        if (existingProduct) {
            if (quantityInput.value == 1) return
            quantityInput.value--
            cart.update(existingProduct, 1, 'deccrement')
            totalPriceTd.textContent = cart.productTotal(existingProduct.index)
            cart.updateCartDetailsHolder()
        } else {
            cart.generateAlertHtml('error', 'حصل خطأ ما أثناء تحديث كمّية المنتج. الرجاء المحاولة لاحقا')
            setTimeout(() => {
                let alert = document.querySelector('.alert.show')
                alert.remove()
            }, 3000);
        }
    }


})

