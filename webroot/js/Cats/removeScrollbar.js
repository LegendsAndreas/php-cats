function removeScrollbar(button) {
    const isActive = button.classList.toggle('active');

    const preElements = document.querySelectorAll('.js-remove-scroll');
    preElements.forEach(pre => {
        pre.classList.toggle('remove-scroll', isActive);
    });
}
window.removeScrollbar = removeScrollbar;
