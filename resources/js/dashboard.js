import { hideOverlay, toggleOverlay, overlay, preventBodyScroll, allowBodyScroll, hideAlerts } from "./functions.js";

const layoutToggle = document.getElementById("layout-toggle");
const root = document.documentElement;
const aside = document.getElementById("aside");
const asideToggle = document.getElementById("aside-toggle");
const navLinks = document.querySelectorAll(".nav-link");
const contentSection = document.querySelector('section#content')

hideAlerts()

if (window.sessionStorage.preferedLayout == "full-width") {
    root.classList.add("full-width");
    handleAsideStatus();
}
window.addEventListener("load", () => {
    if (window.innerWidth < 767) {
        enableFullWidth();
        aside.setAttribute("aria-current", "hidden");
        closeSubMenus();
    }
});
layoutToggle.addEventListener("click", () => {
    if (root.classList.contains("full-width")) {

        disableFullWidth();
    } else {

        enableFullWidth();
        handleAsideStatus();
        closeSubMenus();
    }
});
if (asideToggle) {
    asideToggle.addEventListener("click", () => {
        if (root.classList.contains("full-width")) {

            disableFullWidth();
        } else {
            enableFullWidth();
            aside.setAttribute("aria-current", "hidden");
            closeSubMenus();
        }
    });
}

const dropdownsTogglers = Array.from(
    document.querySelectorAll(".dropdown-toggle")
);
const dropdowns = Array.from(document.querySelectorAll(".dropdown-menu"));

dropdownsTogglers.forEach((btn) => {
    btn.addEventListener("click", () => {
        hideDropDowns();
        removeAriaPressed(btn);
        showDropDown(btn);
    });
});

overlay.addEventListener("click", () => {
    hideDropDowns();
    removeAriaPressed();
    overlay.classList.remove("show");
});

function showDropDown(dropdownBtn) {
    const dropdown = dropdownBtn.nextElementSibling;
    let currentStatus = dropdownBtn.getAttribute("aria-pressed");
    let currentId = dropdownBtn.getAttribute("id");
    let currentWidth = window.innerWidth;

    if (currentStatus == "false") {
        overlay.classList.add("show");
        dropdown.classList.add("show");
        dropdownBtn.setAttribute("aria-pressed", "true");
    } else {
        overlay.classList.remove("show");
        dropdown.classList.remove("show");
        dropdownBtn.setAttribute("aria-pressed", "false");
    }
}

function hideDropDowns() {
    dropdowns.forEach((dMenu) => {
        dMenu.classList.remove("show");
    });
}
function removeAriaPressed(exceptionBtn = null) {
    dropdownsTogglers.forEach((btn) => {

        if (btn != exceptionBtn) {
            btn.setAttribute("aria-pressed", "false");
        }
    });
}

const navCollapsedLinks = document.querySelectorAll(".nav-link.collapsed");
navCollapsedLinks.forEach((navLink) => {
    navLink.addEventListener("click", () => {
        let dropdown = navLink.nextElementSibling;

        if (aside.getAttribute("aria-current") != "detached") {
            dropdown.classList.toggle("show");
        } else {

            disableFullWidth();
            dropdown.classList.toggle("show");
        }
    });
});

const subMenus = document.querySelectorAll(".nav-sub-dropdown");

// Close Sub Menus
function closeSubMenus() {
    subMenus.forEach((subMenu) => {
        subMenu.classList.remove("show");
    });
}

// Aside Status
function handleAsideStatus() {
    if (window.innerWidth > 768) {
        aside.setAttribute("aria-current", "detached");
    } else {
        aside.setAttribute("aria-current", "hidden");
    }
}

// Enable full width

function enableFullWidth() {
    window.sessionStorage.preferedLayout = "full-width";
    root.classList.add("full-width");
}

// Disable full width

function disableFullWidth() {
    window.sessionStorage.preferedLayout = "boxed";
    root.classList.remove("full-width");
    aside.setAttribute("aria-current", "expanded");
}

const preLoader = document.getElementById("preloader");

setTimeout(() => {
    if (preLoader) {
        preLoader.style.display = "none";
    }
}, 1500);

if (overlay) {
    overlay.addEventListener('click', (e) => {
        if (e.target.classList.contains('overlay')) {
            hideActionHolders()
            hideOverlay()
        }
    })
}

function hideActionHolders() {
    const actionHolders = Array.from(document.querySelectorAll('.actions-holder'))
    actionHolders.forEach(holder => {
        holder.classList.remove('show')
    })
}


const resetBtn = document.querySelector('form button[type=reset]')
if (resetBtn) {
    resetBtn.addEventListener('click', () => {

        const choices = document.querySelectorAll('.choice')
        if (choices) {
            choices.forEach(choice => {
                choice.style.display = 'flex'
            })
        }
    })
}


contentSection.addEventListener('click', (e) => {
    let target = e.target
    if (target.classList.contains('action-controller')) {
        toggleActionsHolder(target)
    } else if (target.classList.contains('cancelBtn')) {
        e.preventDefault();
        manageCancelBtns(target)

    } else if (target.classList.contains('modal-controller')) {
        manageModalsControllers(target)
    } else if (target.classList.contains('modal-holder')) {
        manageModalsHolders(target)
    } else if (target.classList.contains('modal-closer')) {
        manageModalsClosers(target)
    }

})

function toggleActionsHolder(actionController) {
    let actionHolder = actionController.nextElementSibling
    actionHolder.classList.toggle('show')
    toggleOverlay()
}

function manageCancelBtns(target) {
    let parentModalHolder = target.closest('.modal-holder')
    parentModalHolder.classList.remove("show");
    allowBodyScroll()
}

function manageModalsControllers(target) {

    let modalHolder = target.nextElementSibling
    modalHolder.classList.add('show')
    preventBodyScroll()
}

function manageModalsHolders(target) {
    target.classList.remove('show')
    allowBodyScroll()
}

function manageModalsClosers(target) {
    let modalHolder = target.closest('.modal-holder')
    modalHolder.classList.remove('show')
    allowBodyScroll()
}
