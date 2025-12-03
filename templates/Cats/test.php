<?php
/**
 * @var \App\View\AppView $this
 */
?>

<div>
    <label for="search-input">Text</label>
    <textarea class="js-get-area-text" id="search-input" placeholder="Text..."></textarea>
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
    <button class="js-write delete-button">X</button>
</div>
<div class="list-group-item js-html-placeholder html-segment" style="display: none">
    <button class="js-write delete-button">X</button>
</div>
<div class="list-group-item js-comment-placeholder comment-segment" style="display: none">
    <button class="js-write delete-button">X</button>
</div>

<style>
    .delete-button {
        height: unset;
        padding: 5px;
        margin-bottom: 5px;
        display: flex;
        justify-self: right;
    }

    .list-group-item {
        z-index: 10;
        border: none;
    }

    .list-group {
        border: 1px solid lightgray;
        padding: 5px;
        background-color: #C93941;
    }

    pre {
        padding-left: 2px;
        font-size: 20px;
        border: none;
        background-color: unset;
    }

    .code-segment {
        background-color: wheat;
    }

    .comment-segment {
        background-color: wheat;

        pre {
            color: green;
        }
    }

    .html-segment {
        background-color: wheat;

        pre {
            color: #212529;
            background-color: whitesmoke;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>
<script>
    new Sortable(example1, {
        animation : 150,
        ghostClass: 'blue-background-class'
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

            // Create a <pre> tag to preserve whitespace
            const preElement            = document.createElement('pre');
            preElement.style.whiteSpace = 'pre-wrap'; // Allows wrapping while preserving whitespace
            if (areaText === 0 ||!areaText) {
                preElement.innerHTML = '&nbsp;';
            } else {
                preElement.textContent = areaText;
            }
            newElement.appendChild(preElement);

            // Add eventlistener to button
            addRemoveElementListener(newElement.querySelector('.js-write'));

            itemBlock.appendChild(newElement);
        })
    })

    function addRemoveElementListener(element) {
        element.addEventListener('click', () => {
            element.parentElement.remove();
        })
    }

</script>
