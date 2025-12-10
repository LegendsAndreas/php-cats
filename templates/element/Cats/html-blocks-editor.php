<?php
/**
 * @var \App\View\AppView             $this
 * @var \App\Model\Entity\HtmlBlock[] $htmlBlocks
 * @var array                         $selectOptions
 */
$colorOptions = [
    ['value' => '#9f55b7', 'text' => 'Purple', 'class' => 'js-set-hexa-color'],
    ['value' => '#008000', 'text' => 'Green', 'class' => 'js-set-hexa-color'],
    ['value' => '#00acff', 'text' => 'Blue', 'class' => 'js-set-hexa-color'],
];

$selectOptions = [
    'code'     => 'Code',
    'comment'  => 'Comment',
    'html'     => 'HTML',
    'terminal' => 'Terminal',
];
?>
<div class="html-blocks">
    <div>
        <label for="search-input">Function Examples</label>
        <textarea class="js-get-area-text" id="search-input" placeholder="Text..."></textarea>
        <div class="text-actions d-flex align-items-center flex-wrap">
            <button class="js-bold-text" type="button">Bolden text</button>
            <div class="d-flex">
                <button class="js-color-text color-wheel-button" type="button">Color text</button>
                <input id="color-picker" type="color" class="js-color-picker me-2 color-wheel" value="#8E7397">
                <?= $this->Form->select('color-type', $colorOptions, [
                    'id'    => 'color-type',
                    'class' => 'js-set-color color-selector',
                ]) ?>
            </div>
            <div class="d-flex align-items-center mx-3">
                <?= $this->Form->label('escape-html', 'Escape HTML', ['class' => 'escape-html-label']) ?>
                <?= $this->Form->checkbox('escape_html', [
                    'id'      => 'escape-html',
                    'class'   => 'js-escape-html-checkbox js-check-checkbox ',
                    'checked' => false,
                ]) ?>
            </div>
        </div>
        <div>
            <?= $this->Form->label('format-type', 'Type') ?>
            <?= $this->Form->select('format-type', $selectOptions, ['id' => 'format-type']) ?>
        </div>

        <button class="js-add-text mt-3" type="button">
            Add text
        </button>
        <?= $this->element('HtmlBlocks/actions-blocks') ?>
    </div>

    <?php if (!empty($htmlBlocks)) { ?>
        <div id="sortableHtmlBlocks" class="list-group mt-3 js-item-block">
            <?php
            $counter = 0;
            foreach ($htmlBlocks as $htmlBlock) { ?>
                <div class="list-group-item <?= $htmlBlock->type ?>-segment">
                    <div class="d-flex">
                        <div class="overflow-hidden me-3 pre-wrapper js-remove-scroll">
                            <pre
                                class="js-add-text-to-pre js-copy-to-clipboard-content js-break-white-spaces"><?= ($htmlBlock->escape_html ? h($htmlBlock->content) : $htmlBlock->content) ?></pre>
                        </div>
                        <div class="list-group-item-actions">
                            <button class="js-delete-list-item delete-button" type="button">X</button>
                            <button class="js-copy-to-clipboard-button copy-button" type="button">Copy</button>
                        </div>
                    </div>
                    <?= $this->Form->hidden('html_blocks.' . $counter . '.content') ?>
                    <?= $this->Form->hidden('html_blocks.' . $counter . '.type') ?>
                    <?= $this->Form->hidden('html_blocks.' . $counter . '.escape_html') ?>
                    <?= $this->Form->hidden('html_blocks.' . $counter++ . '.sort_order') ?>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <div id="sortableHtmlBlocks" class="list-group mt-3 js-item-block"></div>
    <?php } ?>

    <?= $this->element('Cats/html-block-placeholder') ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        new Sortable(sortableHtmlBlocks, {
            animation: 150,
        });

        let itemDifferentialNum = <?= isset($htmlBlocks) ? count($htmlBlocks) : 0 ?>;

        document.querySelectorAll('.js-add-text').forEach(element => {
            element.addEventListener('click', () => {
                const type      = document.querySelector('#format-type').value;
                const itemBlock = document.querySelector('.js-item-block');
                let areaText    = document.querySelector('.js-get-area-text').value;
                let escapeHtml  = document.querySelector('.js-escape-html-checkbox').checked;

                let newElement = document.querySelector('.js-code-placeholder').cloneNode(true);
                newElement.classList.remove('js-code-placeholder', 'd-none');
                newElement.classList.add(`${type}-segment`);

                let preElement = newElement.querySelector('.js-add-text-to-pre');
                if (areaText === 0 || !areaText) {
                    preElement.innerHTML = '&nbsp;';
                } else {
                    if (escapeHtml) {
                        preElement.textContent = areaText;
                    } else {
                        preElement.innerHTML = areaText;
                    }
                }

                // Update hidden field names and values, and enable them
                newElement.querySelectorAll('input[type="hidden"]').forEach(input => {
                    input.removeAttribute('disabled');
                    if (input.name.includes('content')) {
                        input.name  = `html_blocks[${itemDifferentialNum}][content]`;
                        input.value = areaText;
                    } else if (input.name.includes('type')) {
                        input.name  = `html_blocks[${itemDifferentialNum}][type]`;
                        input.value = type;
                    } else if (input.name.includes('order')) {
                        input.name  = `html_blocks[${itemDifferentialNum}][sort_order]`;
                        input.value = itemDifferentialNum;
                    } else if (input.name.includes('escape_html')) {
                        input.name  = `html_blocks[${itemDifferentialNum}][escape_html]`;
                        input.value = escapeHtml;
                    }
                });

                addRemoveElementListener(newElement.querySelector('.js-delete-list-item'));
                addCopyToClipboardListener(newElement.querySelector('.js-copy-to-clipboard-button'));

                itemBlock.appendChild(newElement);
                itemDifferentialNum++;
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

        document.querySelectorAll('.js-color-text').forEach(element => {
            element.addEventListener('click', () => {
                const textarea     = document.querySelector('.js-get-area-text');
                const start        = textarea.selectionStart;
                const end          = textarea.selectionEnd;
                const selectedText = textarea.value.substring(start, end);

                if (selectedText.length > 0) {
                    const hexaColor  = document.querySelector('.js-color-picker').value;
                    const beforeText = textarea.value.substring(0, start);
                    const afterText  = textarea.value.substring(end);
                    const boldText   = `<span style="color: ${hexaColor}">${selectedText}</span>`;

                    textarea.value = beforeText + boldText + afterText;

                    // Restore cursor position after the bold markers
                    textarea.focus();
                    textarea.setSelectionRange(start + 2, end + 2);
                }
            });
        });

        document.querySelectorAll('.js-delete-list-item').forEach(element => {
            addRemoveElementListener(element);
        });

        document.querySelectorAll('.js-copy-to-clipboard-button').forEach(element => {
            addCopyToClipboardListener(element);
        });

        document.querySelector('.js-set-color').addEventListener('change', (e) => {
            document.querySelector('.js-color-picker').value = e.target.value;
        });
    });

    function addRemoveElementListener(element) {
        element.addEventListener('click', () => {
            console.log("Deleting element");
            element.closest('.list-group-item').remove();
        })
    }

    function addCopyToClipboardListener(element) {
        element.addEventListener('click', () => {
            navigator.clipboard.writeText(element.closest('.list-group-item').querySelector('input[name*="[content]"]').value);
            callModal('Copied', 1500);
        })
    }

</script>
