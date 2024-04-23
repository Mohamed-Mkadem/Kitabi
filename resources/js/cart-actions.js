import { Cart } from './Cart.js';
import { decrementQuantity, incrementQuantity, listenForProductRemoval, listenForAddingProductToCart, productsContainers } from './functions.js';
let cart = new Cart();
// console.log(productsContainers);

cart.updateCountElements()
cart.printOnDropdown()
listenForAddingProductToCart(cart)



listenForProductRemoval(cart)
let actualPage = window.location.pathname
if (actualPage == '/Pages/client/cart.html') {
    cart.printOnPage()
}
