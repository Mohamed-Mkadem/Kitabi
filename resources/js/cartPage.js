import { Cart } from './Cart.js'
import { alert } from "./functions.js";
let cart = new Cart

let cartContainer = cart.cartContainer




cartContainer.addEventListener('click', e => {
    let target = e.target
    // Product removal logic
    if (target.classList.contains('remove-btn')) {
        let targetTr = target.closest('tr')

        if (cart.remove(targetTr.dataset.product)) {
            targetTr.remove()
            cart.updateCartDetailsHolder()
            if (cart.isEmpty()) {

                cart.printOnPage()
            }
        } else {
            alert('حصل خطأ ما أثناء حذف المنتج. الرجاء المحاولة لاحقا', 'error')
        }
    }

    // Quantity update logic
    if (target.classList.contains('plus-btn')) {
        let targetTr = target.closest('tr')
        let quantityInput = target.previousElementSibling
        let totalPriceTd = targetTr.querySelector('.total-td')
        let existingProduct = cart.has(cart.getCart(), targetTr.dataset.product)
        if (existingProduct) {
            let totalQuantity = existingProduct.product.quantity + 1
            cart.checkAvailabilityInInventory(existingProduct.product.productId, totalQuantity)
                .then(res => {
                    if (!res.ok) throw new Error('حصل خطأ ما أثناء معالجة طلبكم, الرجاء المحاولة لاحقا')
                    return res.json()
                })
                .then(data => {
                    let isAvailable = data.availability
                    let inventoryQuantity = data.quantity
                    if (isAvailable) {
                        quantityInput.value++
                        cart.update(existingProduct, 1, 'increment')
                        totalPriceTd.textContent = cart.productTotal(existingProduct.index)
                        cart.updateCartDetailsHolder()
                    } else {
                        alert(`كمّية المنتج في مخازننا هي ${inventoryQuantity} فالرجاء عدم تجاوز هذه الكمّية`, 'error')
                    }
                })
                .catch(err => alert(err.message, 'error'))
        } else {

            alert('حصل خطأ ما أثناء تحديث كمّية المنتج. الرجاء المحاولة لاحقا', 'error')
        }
    }
    if (target.classList.contains('minus-btn')) {
        let targetTr = target.closest('tr')
        let quantityInput = target.nextElementSibling
        let totalPriceTd = targetTr.querySelector('.total-td')


        let existingProduct = cart.has(cart.getCart(), targetTr.dataset.product)
        if (existingProduct) {
            if (quantityInput.value == 1) return
            quantityInput.value--
            cart.update(existingProduct, 1, 'deccrement')
            totalPriceTd.textContent = cart.productTotal(existingProduct.index)
            cart.updateCartDetailsHolder()
        } else {
            alert('حصل خطأ ما أثناء تحديث كمّية المنتج. الرجاء المحاولة لاحقا', 'error')

        }
    }


})

