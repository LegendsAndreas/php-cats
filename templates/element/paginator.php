<?php
/**
 * @var \App\View\AppView $this
 * @var int               $modulus
 */
if (!($this->Paginator->counter('{{count}}') > $this->Paginator->param('perPage'))) {
    return;
}
?>

<div class="pagination cat-index__pagination">
    <ul style="list-style: none; display: flex; padding-left: 0">
        <?= $this->Paginator->first('<< ' . __('First')) ?>
        <?= $this->Paginator->prev('< ' . __('Previous')) ?>
        <?= $this->Paginator->numbers(['before' => '', 'after' => '', 'modulus' => $modulus]) ?>
        <?= $this->Paginator->next(__('Next') . ' >') ?>
        <?= $this->Paginator->last(__('Last') . ' >>') ?>
    </ul>
</div>
<p class="text-center"><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>

<script>
    (function () {
        let originalContent = new Map();
        document.addEventListener('DOMContentLoaded', () => {
            const paginatorLinks = document.querySelectorAll('.cat-index__pagination a');
            for (let paginatorLink of paginatorLinks) {
                originalContent.set(paginatorLink, paginatorLink.innerHTML);
            }

            removePaginationText();
            addEventListener('resize', () => removePaginationText());
        });

        function removePaginationText() {
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
    })();
</script>
