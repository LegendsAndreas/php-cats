<?php
/**
 * @var \App\View\AppView $this
 * @var int $modulus
 */

?>

<div class="pagination mt-5 cat-index__pagination">
    <?= $this->Paginator->first('<< ' . __('First')) ?>
    <?= $this->Paginator->prev('< ' . __('Previous')) ?>
    <?= $this->Paginator->numbers(['before' => '', 'after' => '', 'modulus' => $modulus]) ?>
    <?= $this->Paginator->next(__('Next') . ' >') ?>
    <?= $this->Paginator->last(__('Last') . ' >>') ?>
</div>
<p class="text-center"><?= $this->Paginator->counter(
        __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total'),
    ) ?></p>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        removeArrowsOnMobile();
    });

    function removeArrowsOnMobile() {
        if (window.matchMedia('(max-width: 768px)').matches) {
            const paginatorLinks = document.querySelectorAll('.cat-index__pagination a');
            for (let paginatorLink of paginatorLinks) {
                paginatorLink.innerHTML = paginatorLink.innerHTML.replace(/&lt;|&gt;/g, '');
            }
        }
    }
</script>
