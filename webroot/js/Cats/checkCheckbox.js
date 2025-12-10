document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.js-check-checkbox');
    checkboxes.forEach(checkbox => {
        checkCheckbox(checkbox);
    });
})

function checkCheckbox(checkbox) {
    checkbox.addEventListener('change', (event) => {
        checkbox.setAttribute('checked', event.target.checked);
    });
}
