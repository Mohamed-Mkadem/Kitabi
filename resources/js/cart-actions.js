import { Cart } from './Cart.js';
import { decrementQuantity, incrementQuantity, listenForProductRemoval, listenForAddingProductToCart } from './functions.js';
// Also create the same thing with the wishlist : no wishlist must be created using l database, to make save the data
let cart = new Cart();


cart.updateCountElements()
cart.printOnDropdown()
// cart.empty()
listenForAddingProductToCart(cart)

incrementQuantity()
decrementQuantity()

listenForProductRemoval(cart)
let actualPage = window.location.pathname
if (actualPage == '/Pages/client/cart.html') {
    cart.printOnPage()
}