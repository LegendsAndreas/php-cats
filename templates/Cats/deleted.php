<?php
// phpcs:ignoreFile
/**
 * @var \App\View\AppView       $this
 * @var \App\Model\Entity\Cat[] $cats
 * @var \App\Model\Entity\User  $currentUser
 */

?>

<div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-3 g-3">
    <?php
    foreach ($cats as $cat): ?>

        <div class="col cats-deleted">
            <?= $this->element('Cats/cat-template', [
                'cat'     => $cat,
                'buttons' => [
                    $this->Form->postLink('Restore', ['action' => 'restore', $cat->id], ['confirm' => 'Are you sure?']),
                    $this->Form->postLink('Full Delete', ['action' => 'full_delete', $cat->id], ['confirm' => 'Are you sure?']),
                ],
            ]) ?>
        </div>

    <?php
    endforeach; ?>
</div>
