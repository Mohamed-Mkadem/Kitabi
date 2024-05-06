
import { Cart } from './Cart.js'
import { Validator } from './Validator.js'

let cart = new Cart;
let validator = new Validator;
(async () => {
    const hasUpdates = await cart.hasQuantityUpdates();
    if (hasUpdates) {
        cart.informUserToCheckQuantityUpdates()
    } else {
        cart.printOnCheckoutPage(window.user, window.statesData, window.cities, window.shippingCost)
    }

    const checkoutForm = document.getElementById('checkout-form')

    if (checkoutForm) {

        checkoutForm.addEventListener('submit', e => {
            e.preventDefault()

            const firstName = document.getElementById('first_name').value

            const firstNameError = document.querySelector('#first_name + .error-message');

            const lastName = document.getElementById('last_name').value

            const lastNameError = document.querySelector('#last_name + .error-message');


            const phone = document.getElementById('phone').value

            const phoneError = document.querySelector('#phone + .error-message');

            const address = document.getElementById('address').value

            const addressError = document.querySelector('#address + .error-message');

            const state = document.getElementById('state-options').value

            const stateError = document.getElementById('state-error')

            const city = document.getElementById('cities-options').value
            const cityError = document.getElementById('city-error')

            const isCityValid = validator.isRequired(city, cityError)

            const isFirstNameValid = validator.isRequired(firstName, firstNameError);

            const isLastNameValid = validator.isRequired(lastName, lastNameError);

            const isAddressValid = validator.isRequired(address, addressError)

            const isStateValid = validator.isRequired(state, stateError)

            const isPhone = validator.phoneFormat(phone, phoneError);

            if (isFirstNameValid && isLastNameValid && isPhone && isStateValid && isCityValid && isAddressValid) {
                checkoutForm.submit();
            }
        })

    }

})();
