function modifySearchHref() {
    const searchButton = document.querySelector('.js-search-button');
    searchButton.addEventListener('click', () => {
        const searchValue = document.querySelector('.js-input-search').value;

        const linkSearch = document.querySelector('.js-link-search');
        const checkBox = document.querySelector('.js-order-checkbox');
        const checkBoxValue = checkBox.checked;

        linkSearch.setAttribute('href', '/cats/index/' + searchValue + '?' + 'reverseOrder=' + checkBoxValue);
        console.log(linkSearch.getAttribute('href'));
    });
}

function toggleCheckbox() {
    const checkbox = document.querySelector('.js-order-checkbox');
    checkbox.addEventListener('change', (event) => {
        checkbox.setAttribute('checked', event.target.checked);
    });
}

function resizeSearchBarMobile() {
    console.log('toggleSearchBarMobileWidth');
    const searchBar = document.querySelector('.js-input-search');
    if (window.innerWidth < 768) {
        console.log('window.innerWidth < 768');
        searchBar.classList.remove('w-25')
    } else {
        console.log('window.innerWidth > 768');
        searchBar.classList.add('w-25')
    }
}

window.resizeSearchBarMobile = resizeSearchBarMobile;
window.modifySearchHref = modifySearchHref;
window.toggleCheckbox = toggleCheckbox;
