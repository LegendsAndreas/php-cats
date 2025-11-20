document.addEventListener('DOMContentLoaded', function () {
    let currentContributorIndex = 0;
    document.querySelector('.js-add-contributor').addEventListener('click', function () {
        currentContributorIndex++;
        let newContributor = document.querySelector('.contributor').cloneNode(true);
        newContributor     = resetData(newContributor);
        document.querySelector('.contributors').appendChild(newContributor);
    })

    function resetData(el) {
        el.querySelectorAll("input").forEach(input => {
            input.value = '';
            input.name  = input.name.replace(/\d+/g, currentContributorIndex);
        })
        el.querySelector('legend').textContent = `Contributor ${currentContributorIndex + 1}`;
        return el;
    }
})
