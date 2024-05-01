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
    // errorMessage = document.querySelector('.message')
    errorsContainer = document.getElementById('errors-container')

    printMessage(message) {
        let p = document.createElement('p')
        p.className = 'message error mb-n1 mt-2 show'
        p.textContent = message
        return p
    }
    async printOnPage() {

        let cart = await this.checkAndUpdateCart();


        let html = '';
        if (cart.length > 0) {


            html += `
            <div class="table-responsive products-table cart">
                <table>
                    <thead>
                        <tr>
                            <th>المنتج</th>
                            <th> السعر (د.ت) </th>
                            <th>الكمّية</th>
                            <th> المجموع (د.ت) </th>
                        </tr>
                    </thead>
                    <tbody>`;

            for (const product of cart) {
                html += `
                <tr data-product="${product.productId}">
                    <td class="product-td start">
                        <button class="remove-btn">
                            <i class="fa-solid fa-square-xmark"></i>
                        </button>
                        <div class="img-holder">
                            <img src="${product.imageUrl}" alt="">
                        </div>
                        <div class="product-info">
                            <a href="/book/${product.productId}">${product.title}</a>
                            <p>${product.author}</p>
                            <p>${product.publisher}</p>
                        </div>
                    </td>
                    <td class="price-td">
                        ${(product.price / 1000).toFixed(3)}
                    </td>
                    <td>
                        <div class="quantity-holder">
                            <button class="minus-btn">-</button>
                            <input type="number" readonly value="${product.quantity}" lang="en" >
                            <button class="plus-btn">+</button>
                        </div>
                    </td>
                    <td class="total-td">
                        ${((product.price * product.quantity) / 1000).toFixed(3)}
                    </td>
                </tr>`;
            }
            html += `</tbody>
            </table>
        </div>
        <div class="cart-details-holder">
            <h2>مجموع سلّة التسوّق</h2>
            <div class="row">
                <h3>المجموع (د.ت)</h3>
                <p class="total">${this.getTotal(true).toFixed(3)}</p>
            </div>
            <a href="/checkout">تأكيد الطلب</a>
        </div>`;
        } else {
            html = `

            <div class="empty-cart-holder">
                <img src="../../assets/imgs/cart.png" alt="">
                <p>سلّتك فارغة. ما رأيك ببعض التسوّق ؟</p>
                <a href="/shop">الذهاب للمتجر</a>
            </div>

        `
        }
        this.cartContainer.innerHTML = html;
    }

    async updateCart(cart) {
        for (const product of cart) {
            try {
                const response = await this.checkAvailabilityInInventory(product.productId, product.quantity);
                if (!response.ok) {
                    throw new Error('حصل خطأ ما أثناء معالجة هذه العملية');
                }
                const { availability, quantity } = await response.json();

                let errorMessage = '';
                let existingProductIndex = this.getProductIndex(cart, product.productId);
                if (!availability && quantity > 0) {
                    cart[existingProductIndex].quantity = quantity;
                    this.save(cart);
                    errorMessage = this.printMessage(`لقد قمنا بتقليل كمّية المنتج ${product.title} لتصبح ${quantity} نظرا لنقص كمّية المنتج في مخازننا`);
                } else if (!availability && quantity === 0) {
                    let productName = product.title;
                    errorMessage = this.printMessage(`لقد قمنا بحذف  المنتج ${productName}  نظرا لنفاد المنتج من مخازننا`);
                    this.remove(product.productId, true);
                }
                this.errorsContainer.append(errorMessage);
            } catch (error) {

                this.generateAlertHtml('error', error.message)
            }
        }
    }




    async checkAndUpdateCart() {
        let cart = this.getCart();
        await this.updateCart(cart)
        return this.getCart()

    }


    updateCartDetailsHolder() {
        let total = this.cartContainer.querySelector('.total')
        total.textContent = this.getTotal(true).toFixed(3)
    }



    checkAvailabilityInInventory(productId, quantity) {
        return fetch(`/shop/product/availability/${productId}/${quantity}`)
    }
    productTotal(existingProduct) {
        let cart = this.getCart()
        let product = cart[existingProduct];

        return ((product.quantity * product.price) / 1000).toFixed(3)
    }
    getIndexInArray() { }
    getProductIndex(cart, id) {
        for (let i = 0; i < cart.length; i++) {
            if (cart[i].productId == id) return i
        }
        return false
    }
    remove(id, silentRemove = false) {
        let cart = this.getCart()

        for (let i = 0; i < cart.length; i++) {
            if (cart[i].productId == id) {
                cart.splice(i, 1);
                !silentRemove ? this.playSound('remove') : null
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

    printOnCheckoutPage(user, states, cities, shippingCost) {
        let cart = this.getCart()
        let html = ''
        let token = document.querySelector('meta[name=token]').content
        let stringifiedCart = JSON.stringify(cart)
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
                    <p class="price">${shippingCost.toFixed(3)}</p>
                </div>
                <div class="row ">
                    <p class="heading total-item">المجموع (د.ت)</p>
                    <p class="price total-item"> ${((this.getTotal() + (shippingCost * 1000)) / 1000).toFixed(3)} </p>
                </div>
            </div>
        </div>
        <div class="col shipping-info">
            <h2>معلومات التسليم</h2>
            <form action="" method="post" id="checkout-form">
            <input type="hidden" name="_token" value="${token}">
            <input type="hidden" name="cart" value="${stringifiedCart}">
                <div class="row">
                    <div class="form-control">
                        <label for="first_name">الاسم</label>
                        <input type="text" name="" id="first_name" value="${user.first_name}" placeholder="الإسم">
                       <p class="error-message">هذا الحقل إجباري</p>
                    </div>
                    <div class="form-control">
                        <label for="last_name">اللقب</label>
                        <input type="text" name="" id="last_name" value="${user.last_name}" placeholder="اللّقب">
                       <p class="error-message">هذا الحقل إجباري</p>
                    </div>
                </div>
                <div class="row">
                    <div class="form-control">
                        <label for="phone">الهاتف</label>
                        <input type="text" name="" id="phone" value="${user.phone}" placeholder="رقم هاتف يتكوّن من 8 أرقام">
                       <p class="error-message">هذا الحقل إجباري</p>
                    </div>
                </div>
                <div class="row">
                    <div class="form-control">
                        <label for="address">العنوان</label>
                        <input type="text" name="" placeholder="عنوان التسليم" id="address" value="${user.address}">

                       <p class="error-message">هذا الحقل إجباري</p>
                    </div>
                </div>
                <div class="row">
                    <div class="form-control">
                        <label for="state-options">الولاية</label>
                        <div class="select-box">
                            <select id="state-options">
                                `
            states.forEach(state => {
                html += `
                                    <option ${user.state_id == state.id ? "selected" : ''}  value="${state.id}">${state.name}</option>
                                    `
            })
            html += `
                            </select>
                        </div>
                       <p class="error-message" id="state-error">هذا الحقل إجباري</p>
                    </div>
                    <div class="form-control">
                        <label for="cities-options">المعتمديّة</label>
                        <div class="select-box">
                            <select id="cities-options">
                                `
            cities.forEach(city => {
                if (city.state_id == user.state_id) {

                    html += `
                    <option ${user.city_id == city.id ? "selected" : ''}  value="${city.id}">${city.name}</option>
                    `
                }
            })
            html += `
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
                <a href="/shop">الذهاب للمتجر</a>
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
                            <a class="cart-item-title" href="/book/${product.productId}">${product.title}</a>
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
                        <a href="/cart" class="cart-link">السلة</a>
                        <a href="/checkout" class="checkout-link">الدفع</a>
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
            this.playSound('add')
            return
        }

        let cart = this.getCart()
        let existingProduct = this.has(cart, product.productId)
        if (existingProduct) {
            this.update(existingProduct, product.quantity, 'increment')
            this.playSound('add')
        } else {
            cart.push(product)
            this.save(cart)
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
    }
    is(url) {
        let currentUrl = window.location.pathname
        return currentUrl.startsWith(url)
    }
    showAddToCartMessage(productId, quantity) {
        let status = this.checkAvailabilityInInventory(productId, quantity) ? 'success' : 'error'
        let message = status == 'success' ? 'تم إضافة المنتج بنجاح' : 'حصل خطأ أثناء إضافة المنتج'
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

    getProductQuantity(productId, addedQuantity) {
        let quantity = addedQuantity
        let existingProduct = this.has(this.getCart(), productId)
        if (existingProduct) quantity += existingProduct.product.quantity

        return quantity
    }
    setQuantityUpdates() {
        sessionStorage.setItem('quantity_updates')
    }
    removeQuantityUpdates() {
        sessionStorage.removeItem('quantity_updates')
    }
    async hasQuantityUpdates() {
        await this.checkForQuantitiesUpdate(this.getCart());
        return sessionStorage.getItem('quantity_updates')
    }
    async checkForQuantitiesUpdate(cart) {
        for (const product of cart) {
            try {
                const response = await this.checkAvailabilityInInventory(product.productId, product.quantity);
                if (!response.ok) {
                    throw new Error('حصل خطأ ما أثناء معالجة هذه العملية');
                }
                const { availability } = await response.json();
                if (!availability) {
                    sessionStorage.setItem('quantity_updates', true)
                }
            } catch (error) {

                this.generateAlertHtml('error', error.message)
            }
        }
    }

    informUserToCheckQuantityUpdates() {
        let html = `
        <div class="empty-cart-holder">
        <img src="../../assets/imgs/cart.png" alt="">
        <p>حصل بعض التغيير على سلّتك بسبب تغيّر كمّيّات المنتجات في مخازننا, فالرجاء التوجّه للسلّة والمصادقة على التغييرات</p>
        <a href="/cart">التوجّه للسلّة</a>
    </div>
        `
        this.checkoutContainer.innerHTML = html
    }
}
