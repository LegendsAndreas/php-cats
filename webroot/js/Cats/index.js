// phpcs:ignoreFile
document.addEventListener('DOMContentLoaded', () => {
    modifySearchHref();
    toggleCheckbox();
});

function modifySearchHref() {
    const searchButton = document.querySelector('.js-search-button');
    if (!searchButton) {
        console.warn('js-search-button element not found.');
        return
    }
    searchButton.addEventListener('click', () => {
        const searchValue = document.querySelector('.js-input-search').value;

        const linkSearch = document.querySelector('.js-link-search');
        const checkBox = document.querySelector('.js-order-checkbox');
        const checkBoxValue = checkBox.checked;

        linkSearch.setAttribute('href', '/cats/index?catName=' + searchValue + '&' + 'reverseOrder=' + checkBoxValue);
        console.log(linkSearch.getAttribute('href'));
    });
}

function toggleCheckbox() {
    const checkbox = document.querySelector('.js-order-checkbox');
    if (!checkbox) {
        console.warn('js-order-checkbox element not found.');
        return
    }
    checkbox.addEventListener('change', (event) => {
        checkbox.setAttribute('checked', event.target.checked);
    });
}

