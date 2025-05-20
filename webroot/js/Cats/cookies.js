document.addEventListener("DOMContentLoaded", function(event) {
    toggleOrderCookie();
    getOrderCookie();

    toggleSearchQueryCookie();
    getSearchQueryCookie();
});

function toggleOrderCookie() {
    const checkbox = document.querySelector('.js-order-checkbox');
    checkbox.addEventListener('change', (event) => {
        const isChecked = event.target.checked;
        const expirationDate = new Date();
        expirationDate.setMinutes(expirationDate.getMinutes() + 30);

        document.cookie = `order=${isChecked};expires=${expirationDate.toUTCString()};path=/`;
    });
}

function getOrderCookie() {
    const checkbox = document.querySelector('.js-order-checkbox');
    const cookies = document.cookie.split(';');
    const orderCookie = cookies.find(cookie => cookie.trim().startsWith('order='));

    if (orderCookie) {
        checkbox.checked = orderCookie.split('=')[1] === 'true';
    }
}

function toggleSearchQueryCookie() {
    const searchInput = document.querySelector('.js-input-search');
    searchInput.addEventListener('input', () => {
        setCookie('searchQuery', searchInput.value, 7);
    });
}

function getSearchQueryCookie() {
    const searchQuery = getCookie('searchQuery');
    if (searchQuery) {
        console.log('Search Query Cookie:', searchQuery);
        // Optionally, set the value back into the search input
        const searchInput = document.querySelector('.js-input-search');
        if (searchInput) {
            searchInput.value = searchQuery; // Populate the search input field
        }
    } else {
        console.log('Search Query Cookie does not exist.');
    }
}

function setCookie(name, value, days) {
    const d = new Date();
    d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
    const expires = "expires=" + d.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

function getCookie(name) {
    const cookies = document.cookie.split(';');
    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i].trim();
        if (cookie.startsWith(name + '=')) {
            return cookie.substring((name.length + 1));
        }
    }
    return null;
}
