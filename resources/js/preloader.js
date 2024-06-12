let preloader = document.getElementById('pre-loader')

if (preloader) {
    setTimeout(() => {
        preloader.classList.remove('show')
    }, 1000);
}

