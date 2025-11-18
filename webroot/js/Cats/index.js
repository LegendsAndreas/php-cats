// phpcs:ignoreFile
document.addEventListener('DOMContentLoaded', () => {
    resizeSearchBarMobile();
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

function resizeSearchBarMobile() {
    const searchBar = document.querySelector('.js-input-search');
    if (!searchBar) {
        console.warn('js-input-search element not found.');
        return
    }
    if (window.innerWidth < 768) {
        searchBar.classList.remove('w-25')
    } else {
        searchBar.classList.add('w-25')
    }
}

window.resizeSearchBarMobile = resizeSearchBarMobile;
window.modifySearchHref = modifySearchHref;
window.toggleCheckbox = toggleCheckbox;
