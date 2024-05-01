import { Cart } from './Cart.js';
import { decrementQuantity, incrementQuantity, listenForProductRemoval, listenForAddingProductToCart, productsContainers, } from './functions.js';
let cart = new Cart();

cart.updateCountElements()
cart.printOnDropdown()
listenForAddingProductToCart(cart)



listenForProductRemoval(cart)
let actualPage = window.location.pathname
if (actualPage.startsWith('/cart')) {
    cart.printOnPage()
}
if (!actualPage.startsWith('checkout')) {
    cart.removeQuantityUpdates()
}
