function breakWhiteSpaces(button) {
    button.classList.toggle('active');

    const preElements = document.querySelectorAll('.js-break-white-spaces');
    preElements.forEach(pre => {
        pre.style.whiteSpace = button.classList.contains('active') ? 'break-spaces' : '';
    });
}
window.breakWhiteSpaces = breakWhiteSpaces;
