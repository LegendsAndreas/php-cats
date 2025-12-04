<?php
/**
 * Using the tag "pre" keeps the indentation of the text
 *
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

<?= $this->Form->create(); ?>
<div id="example1" class="list-group col mt-3 js-item-block">
</div>
<?= $this->Form->button('Save', ['class' => 'mt-3']); ?>
<?= $this->Form->end(); ?>

<div class="list-group-item js-code-placeholder d-none">
    <div class="d-flex">
        <div class="col">
        <pre class="js-add-text-to-pre">
        </pre>
        </div>
        <div class="col-auto">
            <button class="js-write delete-button">X</button>
        </div>
    </div>
    <?= $this->Form->hidden('items.0.content') ?>
    <?= $this->Form->hidden('items.0.type') ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>
<script>
    new Sortable(example1, {
        animation: 150,
    });

    let itemIndex = 0;

    document.querySelectorAll('.js-add-text').forEach(element => {
        element.addEventListener('click', () => {
            const type      = document.querySelector('#search-type').value;
            const itemBlock = document.querySelector('.js-item-block');
            let areaText    = document.querySelector('.js-get-area-text').value;

            const chosenPlaceholder = document.querySelector('.js-code-placeholder');
            let newElement          = chosenPlaceholder.cloneNode(true);
            newElement.classList.remove('js-code-placeholder');
            newElement.classList.remove('d-none');
            newElement.classList.add(`${type}-segment`);

            let preElement = newElement.querySelector('.js-add-text-to-pre');
            if (areaText === 0 || !areaText) {
                preElement.innerHTML = '&nbsp;';
            } else {
                preElement.innerHTML = areaText;
            }

            // Update hidden field names and values
            newElement.querySelectorAll('input[type="hidden"]').forEach(input => {
                if (input.name.includes('content')) {
                    input.name = `items[${itemIndex}][content]`;
                    input.value = areaText;
                } else if (input.name.includes('type')) {
                    input.name = `items[${itemIndex}][type]`;
                    input.value = type;
                }
            });

            addRemoveElementListener(newElement.querySelector('.js-write'));

            itemBlock.appendChild(newElement);
            itemIndex++;
        })
    })

    document.querySelectorAll('.js-bold-text').forEach(element => {
        element.addEventListener('click', () => {
            const textarea     = document.querySelector('.js-get-area-text');
            const start        = textarea.selectionStart;
            const end          = textarea.selectionEnd;
            const selectedText = textarea.value.substring(start, end);

            if (selectedText.length > 0) {
                const beforeText = textarea.value.substring(0, start);
                const afterText  = textarea.value.substring(end);
                const boldText   = `<strong>${selectedText}</strong>`;

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
