export class Cart {
    total = 0
    count = 0
    discountValue = sessionStorage.getItem('discountValue') ? sessionStorage.getItem('discountValue') : 0
    discountPercentage = sessionStorage.getItem('discountPercentage') ?? 0
    headerCartCounter = document.getElementById('cart-count')
    fiexedMenuCartCounter = document.getElementById('fixed-menu-count')
    cartContentDropdown = document.getElementById('cart-content-dropdown')
    addToCartSoundEffect = document.getElementById('add-to-cart-sound-effect')
    removeFromCartSoundEffect = document.getElementById('remove-from-cart-sound-effect')
    cartContainer = document.getElementById('cart-container')
    checkoutContainer = document.getElementById('checkout-container')
    errorMessage = document.querySelector('.message')

    printMessage(message) {
        let p = document.createElement('p')
        p.className = 'message'
        p.textContent = message
        return p
    }
    printOnPage() {


        let cart = this.getCart()
        let html = ''
        if (cart.length > 0) {

            html += `
            <div class="table-responsive products-table cart">

                    <table>
                        <thead>
                            <tr>
                                <th>المنتج</th>
                                <th> السعر (د.ت) </th>
                                <th>الكمّية</th>
                                <th>المجموع</th>
                                </tr>
                                </thead>
                                <tbody>
                                `
            cart.forEach(product => {
                // check availability in inventory
                let availability = this.checkAvailabilityInInventory()
                if (!availability) {
                    product.availability = false
                    this.errorMessage.classList.add('show')
                }

                html += `
                        <tr data-product=" ${product.productId} ">
                        <td class="product-td start ">
                            <button class="remove-btn">
                                <i class="fa-solid fa-square-xmark"></i>
                            </button>
                            <div class="img-holder">
                                <img  src=" ${product.imageUrl} " alt="">
                            </div>
                            <div class="product-info">
                                <a href="book.html">   ${product.title}    </a>
                                <p> ${product.author} </p>
                                <p> ${product.publisher} </p>
                            </div>
                        </td>
                        <td class="price-td">
                            ${(product.price / 1000).toFixed(3)}
                        </td>
                        <td>
                            <div class="quantity-holder">
                                <button class="minus-btn">-</button>
                                <input type="number" readonly class="${availability ? '' : 'danger'}" value="${product.quantity}"  lang="en">
                                <button class="plus-btn">+</button>
                            </div>
                        </td>
                        <td class="total-td">
                            ${((product.price * product.quantity) / 1000).toFixed(3)}
                        </td>
                    </tr>

                `
            })

            html += `               </tbody>
                                </table>
                        </div>
                        <div class="cart-details-holder">
                        <h2>مجموع سلّة التسوّق</h2>


                        <div class="row">
                            <h3>المجموع (د.ت)</h3>
                            <p class="total">${this.getTotal(true).toFixed(3)}</p>
                        </div>
                        <a href="checkout.html">تأكيد الطلب</a>
                    </div>
`


        } else {

            html = `

                <div class="empty-cart-holder">
                    <img src="../../assets/imgs/cart.png" alt="">
                    <p>سلّتك فارغة. ما رأيك ببعض التسوّق ؟</p>
                    <a href="shop.html">الذهاب للمتجر</a>
                </div>

            `
        }
        this.cartContainer.innerHTML = html

    }

    updateCartDetailsHolder() {
        let total = this.cartContainer.querySelector('.total')
        total.textContent = this.getTotal(true).toFixed(3)
    }


    checkAvailabilityInInventory(productId) {

        return true
    }
    productTotal(existingProduct) {
        let cart = this.getCart()
        let product = cart[existingProduct];

        return ((product.quantity * product.price) / 1000).toFixed(3)
    }
    getIndexInArray() { }
    get(id) { }
    remove(id) {
        let cart = this.getCart()

        for (let i = 0; i < cart.length; i++) {
            if (cart[i].productId == id) {
                cart.splice(i, 1);
                this.playSound('remove')
                this.save(cart)
                return 1
            }
        }
        return 0
    }
    empty() {
        let cart = this.getCart()
        cart = []
        this.save(cart)

    }

    printOnCheckoutPage() {
        let cart = this.getCart()
        let html = ''
        if (cart.length > 0) {
            html += `
            <div class=" checkout-wrapper mt-2 mb-2">
                <div class="col order-resume">
                    <h2>ملخص الطلب</h2>
                    <div class="products-holder">
            `
            cart.forEach(product => {
                html += `

                <div class="order-product">
                <div class="img-holder">
                    <img loading="lazy" src=" ${product.imageUrl} " alt="">
                </div>
                <div class="info">
                    <p class="title"> ${product.title} </p>
                    <p class="cart-item-price">
                        <sup dir="ltr"> <small>x <span> ${product.quantity} </span></small> </sup>
                        <span> ${(product.price / 1000).toFixed(3)} </span>
                    </p>
                </div>

                <p class="sub-total"> ${((product.quantity * product.price) / 1000).toFixed(3)} (د.ت)</p>

            </div>
                `
            })
            html += `
            </div>
            <div class="order-total">
                <div class="row">
                    <p class="heading">الشحن (د.ت)</p>
                    <p class="price">7.000</p>
                </div>
                <div class="row ">
                    <p class="heading total-item">المجموع (د.ت)</p>
                    <p class="price total-item"> ${this.getTotal(true).toFixed(3)} </p>
                </div>
            </div>
        </div>
        <div class="col shipping-info">
            <h2>معلومات التسليم</h2>
            <form action="" method="post" id="checkout-form">
                <div class="row">
                    <div class="form-control">
                        <label for="first_name">الاسم</label>
                        <input type="text" name="" id="first_name" value="محمّد" placeholder="الإسم">
                       <p class="error-message">هذا الحقل إجباري</p>
                    </div>
                    <div class="form-control">
                        <label for="last_name">اللقب</label>
                        <input type="text" name="" id="last_name" value="مقدّم" placeholder="اللّقب">
                       <p class="error-message">هذا الحقل إجباري</p>
                    </div>
                </div>
                <div class="row">
                    <div class="form-control">
                        <label for="phone">الهاتف</label>
                        <input type="text" name="" id="phone" value="12345678" placeholder="رقم هاتف يتكوّن من 8 أرقام">
                       <p class="error-message">هذا الحقل إجباري</p>
                    </div>
                </div>
                <div class="row">
                    <div class="form-control">
                        <label for="address">العنوان</label>
                        <input type="text" name="" placeholder="عنوان التسليم" id="address" value="هذا النص هو مثال لنص يمكن استبداله في نفس المساحة">

                       <p class="error-message">هذا الحقل إجباري</p>
                    </div>
                </div>
                <div class="row">
                    <div class="form-control">
                        <label for="state-options">الولاية</label>
                        <div class="select-box">
                            <select id="state-options">
                                <option value="tunis">تونس</option>
                                <option value="ariana">أريانة</option>
                                <option value="sousse">سوسة</option>
                                <option value="beja">باجة</option>
                            </select>
                        </div>
                       <p class="error-message" id="state-error">هذا الحقل إجباري</p>
                    </div>
                    <div class="form-control">
                        <label for="cities-options">المعتمديّة</label>
                        <div class="select-box">
                            <select id="cities-options">
                                <option value="1">المنيهلة</option>
                                <option value="2">المرسى</option>
                                <option value="3">باب بحر</option>
                                <option value="4">مساكن</option>
                            </select>
                        </div>
                       <p class="error-message" id="city-error">هذا الحقل إجباري</p>
                    </div>
                </div>
                <div class="row">
                    <div class="form-control">
                        <label for="note">ملاحظات تريد إضافتها للبائع (اختياري)</label>
                        <textarea name="" id="note" cols="30" rows="10" placeholder="اكتب ملاحظتك هنا"></textarea>
                    </div>
                </div>
                <div class="row payment-row">
                    <h2>طريقة الدفع</h2>
                    <div class="form-control">
                        <label for="payment-option">الدفع عند الاسنلام</label>
                        <input type="radio" name="payment-option" id="payment-option" value="cod" checked>
                    </div>
                </div>
                <button type="submit"  class=" submitBtn mb-1 mt-1">تأكيد الطلب</button>
            </form>
        </div>

            `
            this.checkoutContainer.innerHTML = html

        } else {
            html = `
            <div class="empty-cart-holder">
                <img src="../../assets/imgs/cart.png" alt="">
                <p>سلّتك فارغة. ما رأيك ببعض التسوّق ؟</p>
                <a href="shop.html">الذهاب للمتجر</a>
            </div>

                `
            this.checkoutContainer.innerHTML = html

        }
    }

    printOnDropdown() {
        let cart = this.getCart()
        if (cart.length) {
            let cartHTML = '<ul class="items-holder">';

            cart.forEach(product => {
                cartHTML += `
                    <li class="cart-item">
                        <img src="${product.imageUrl}" alt="">
                        <div class="cart-item-info">
                            <a class="cart-item-title" href="book.html">${product.title}</a>
                            <p class="cart-item-price">
                                <sup dir="ltr"> <small>x <span>${product.quantity}</span></small> </sup>
                                <span>${(product.price / 1000).toFixed(3)}</span> د.ت
                            </p>
                        </div>
                        <button class="remove-btn" data-id="${product.productId} "> <i class="fa-solid fa-close"></i> </button>
                    </li>
                `;
            });

            cartHTML += '</ul>';
            cartHTML += `
                <div class="cart-info-holder">
                    <div class="info-holder">
                        <p>المجموع :</p>
                        <p class="price"> <span>${this.getTotal(true).toFixed(3)}</span> د.ت </p>
                    </div>
                    <div class="info-holder">
                        <a href="cart.html" class="cart-link">السلة</a>
                        <a href="checkout.html" class="checkout-link">الدفع</a>
                    </div>
                </div>
            `;
            this.cartContentDropdown.innerHTML = cartHTML



        } else {
            let cartHTML = `<p class="cart-empty">السلة فارغة</p>`
            this.cartContentDropdown.innerHTML = cartHTML
        }
    }
    playSound(actionType) {
        if (actionType == 'add') {
            this.addToCartSoundEffect.play()
        } else {
            this.removeFromCartSoundEffect.play()
        }
    }


    has(cart, id) {
        for (let i = 0; i < cart.length; i++) {
            if (cart[i].productId == id) return { index: i, product: cart[i] }
        }
        return false
    }
    getTotal(dt = false) {
        let cart = this.getCart()
        let total = 0
        cart.forEach(product => {
            total += (product.price * product.quantity)
        });
        return dt ? total / 1000 : total

    }

    add(product) {
        this.createIfNotExist()
        if (this.isEmpty()) {
            let cart = this.getCart()
            cart.push(product)
            this.save(cart)
            this.showAddToCartMessage()
            this.playSound('add')
            return
        }

        let cart = this.getCart()
        let existingProduct = this.has(cart, product.productId)
        if (existingProduct) {
            this.update(existingProduct, product.quantity, 'increment')
            this.showAddToCartMessage()
            this.playSound('add')
        } else {
            cart.push(product)
            this.save(cart)
            this.showAddToCartMessage()
            this.playSound('add')
        }


    }

    createIfNotExist() {
        if (!this.exists()) this.createCart()
    }

    update(existingProduct, quantity, operation) {
        let cart = this.getCart()

        operation == 'increment' ? cart[existingProduct.index].quantity += quantity : cart[existingProduct.index].quantity -= quantity
        this.save(cart)
    }

    getCount() {
        return this.getCart().length
    }
    isEmpty() {
        let cart = this.getCart()
        return cart.length == 0
    }
    updateCountElements() {
        this.updateHeaderCounterValue()
        this.updateFixedMenuCount()
    }
    updateHeaderCounterValue() {
        this.headerCartCounter.textContent = this.getCount()
    }
    updateFixedMenuCount() {
        this.fiexedMenuCartCounter.textContent = this.getCount()
    }
    createCart() {
        sessionStorage.setItem('cart', '[]')
    }
    getCart() {
        this.createIfNotExist()
        return JSON.parse(sessionStorage.getItem('cart'))
    }
    exists() {
        return sessionStorage.getItem('cart');
    }
    clear() {
        sessionStorage.removeItem('cart')
    }
    save(cart) {
        sessionStorage.setItem('cart', JSON.stringify(cart))
        this.updateCountElements()
        this.printOnDropdown()

        if (this.is('/Pages/client/checkout.html')) {
            this.printOnCheckoutPage()
        }

    }
    is(url) {
        let currentUrl = window.location.pathname
        return url == currentUrl ? true : false
    }
    showAddToCartMessage() {
        let status = this.checkAvailabilityInInventory() ? 'success' : 'error'
        let message = this.checkAvailabilityInInventory() ? 'تم إضافة المنتج بنجاح' : 'حصل خطأ أثناء إضافة المنتج'
        this.generateAlertHtml(status, message)
        setTimeout(() => {
            let alert = document.querySelector('.alert.show')
            alert.remove()
        }, 5000);
    }
    generateAlertHtml(status, message) {
        let alertDiv = document.createElement('div')
        alertDiv.className = 'alert show ' + status
        let p = document.createElement('p')
        p.textContent = message
        alertDiv.append(p)
        document.body.append(alertDiv)

    }
}
