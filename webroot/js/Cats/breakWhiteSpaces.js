function breakWhiteSpaces(button) {
    const isActive = button.classList.toggle('active');

    const preElements = document.querySelectorAll('.js-break-white-spaces');
    preElements.forEach(pre => {
        pre.classList.toggle('break-spaces-active', isActive);
    });
}
window.breakWhiteSpaces = breakWhiteSpaces;
