<?php
/**
 * Using the tag "pre" keeps the indentation of the text
 * @var \App\View\AppView $this
 */
?>

<div>
    <label for="search-input">Text</label>
    <textarea class="js-get-area-text" id="search-input" placeholder="Text..."></textarea>
    <button class="js-bold-text" type="button">Bold</button>
    <label for="search-type">Type</label>
    <select id="search-type">
        <option value="code">Code</option>
        <option value="comment">Comment</option>
        <option value="html">HTML</option>
    </select>

    <button class="js-add-text">
        Add text
    </button>
</div>

<div id="example1" class="list-group col mt-3 js-item-block">
</div>

<div class="list-group-item js-code-placeholder code-segment" style="display: none">
    <div class="d-flex">
        <div class="col">
        <pre class="js-add-text-to-pre">
        </pre>
        </div>
        <div class="col-auto">
            <button class="js-write delete-button">X</button>
        </div>
    </div>
</div>

<div class="list-group-item js-html-placeholder html-segment" style="display: none">
    <div class="d-flex" style="background-color: whitesmoke">
        <div class="col">
        <pre class="js-add-text-to-pre">
        </pre>
        </div>
        <div class="col-auto">
            <button class="js-write delete-button">X</button>
        </div>
    </div>
</div>

<div class="list-group-item js-comment-placeholder comment-segment" style="display: none">
    <div class="d-flex">
        <div class="col">
        <pre class="js-add-text-to-pre">
        </pre>
        </div>
        <div class="col-auto">
            <button class="js-write delete-button">X</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>
<script>
    new Sortable(example1, {
        animation : 150,
    });

    document.querySelectorAll('.js-add-text').forEach(element => {
        element.addEventListener('click', () => {
            // Get elements
            const type      = document.querySelector('#search-type').value;
            const itemBlock = document.querySelector('.js-item-block');
            let areaText    = document.querySelector('.js-get-area-text').value;
            console.log(areaText);
            console.log(type);

            // Clone the appropriate placeholder
            const chosenPlaceholder = document.querySelector(`.js-${type}-placeholder`);
            let newElement          = chosenPlaceholder.cloneNode(true);
            newElement.classList.remove(`js-${type}-placeholder`);
            newElement.style.display = 'block';

            // Add to pre-tag
            let preElement              = newElement.querySelector('.js-add-text-to-pre');
            if (areaText === 0 || !areaText) {
                preElement.innerHTML = '&nbsp;';
            } else {
                preElement.innerHTML = areaText;
            }

            // Add eventlistener to button
            addRemoveElementListener(newElement.querySelector('.js-write'));

            itemBlock.appendChild(newElement);
        })
    })

    document.querySelectorAll('.js-bold-text').forEach(element => {
        element.addEventListener('click', () => {
            const textarea = document.querySelector('.js-get-area-text');
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const selectedText = textarea.value.substring(start, end);

            if (selectedText.length > 0) {
                const beforeText = textarea.value.substring(0, start);
                const afterText = textarea.value.substring(end);
                const boldText = `<strong>${selectedText}</strong>`;

                textarea.value = beforeText + boldText + afterText;

                // Restore cursor position after the bold markers
                textarea.focus();
                textarea.setSelectionRange(start + 2, end + 2);
            }
        });
    });

    function addRemoveElementListener(element) {
        element.addEventListener('click', () => {
            element.closest('.list-group-item').remove();
        })
    }

</script>
