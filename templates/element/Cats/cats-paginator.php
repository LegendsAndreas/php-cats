<?php
/**
 * @var \App\View\AppView $this
 * @var int               $modulus
 */

?>

<div class="pagination mt-5 cat-index__pagination">
    <ul style="list-style: none; display: flex; padding-left: 0">
        <?= $this->Paginator->first('<< ' . __('First')) ?>
        <?= $this->Paginator->prev('< ' . __('Previous')) ?>
        <?= $this->Paginator->numbers(['before' => '', 'after' => '', 'modulus' => $modulus]) ?>
        <?= $this->Paginator->next(__('Next') . ' >') ?>
        <?= $this->Paginator->last(__('Last') . ' >>') ?>
    </ul>
</div>
<p class="text-center"><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
