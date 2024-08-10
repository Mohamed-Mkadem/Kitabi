import { Validator } from "./Validator.js";

let validator = new Validator


const shippingCostForm = document.getElementById('shippingCostForm')


shippingCostForm.addEventListener('submit', (e) => {
    e.preventDefault()

    const shippingCostInput = document.getElementById('shipping_cost-input').value
    const shippingCostErrorMessage = shippingCostForm.querySelector('.error-message')

    const isShippingCostValid = validator.isRequired(shippingCostInput, shippingCostErrorMessage)

    if (isShippingCostValid) {
        shippingCostForm.submit()
    }
})
