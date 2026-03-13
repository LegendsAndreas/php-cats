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
        <?= $this->Paginator->first('<< <span class="cat-index__pagination__text">' . __('First') . '</span>', ['escape' => false]) ?>
        <?= $this->Paginator->prev('< <span class="cat-index__pagination__text">' . __('Previous') . '</span>', ['escape' => false]) ?>
        <?= $this->Paginator->numbers(['before' => '', 'after' => '', 'modulus' => $modulus]) ?>
        <?= $this->Paginator->next('<span class="cat-index__pagination__text">' . __('Next') . '</span> >', ['escape' => false]) ?>
        <?= $this->Paginator->last('<span class="cat-index__pagination__text">' . __('Last') . '</span> >>', ['escape' => false]) ?>
    </ul>
</div>
<p class="text-center"><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
