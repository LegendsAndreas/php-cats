// phpcs:ignoreFile
let originalContent = new Map();
document.addEventListener('DOMContentLoaded', () => {
    modifySearchHref();
    toggleCheckbox();

    const paginatorLinks = document.querySelectorAll('.cat-index__pagination a');
    for (let paginatorLink of paginatorLinks) {
        originalContent.set(paginatorLink, paginatorLink.innerHTML);
    }
    removeArrowsOnMobile();
    addEventListener('resize', () => removeArrowsOnMobile());
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

function removeArrowsOnMobile() {
    const paginatorLinks = document.querySelectorAll('.cat-index__pagination a');

    if (window.matchMedia('(max-width: 768px)').matches) {
        for (let paginatorLink of paginatorLinks) {
            paginatorLink.innerHTML = paginatorLink.innerHTML.replace(/Next|Last|First|Previous/g, '');
        }
    } else {
        for (let paginatorLink of paginatorLinks) {
            if (originalContent.has(paginatorLink)) {
                paginatorLink.innerHTML = originalContent.get(paginatorLink);
            }
        }
    }
}

window.modifySearchHref = modifySearchHref;
window.toggleCheckbox = toggleCheckbox;
