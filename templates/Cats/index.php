<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cat[] $cats
 * @var \App\Model\Entity\User $currentUser
 */

?>

<div class="container my-5">
    <div class="row text-center">
        <div class="col">
            <a href="cats/add">
                <button class="fs-3 mt-3">Add new Cat</button>
            </a>
        </div>
        <?php if ($currentUser): ?>
            <div class="col">
                <a href="users/logout">
                    <button class="fs-3 mt-3">Logout</button>
                </a>
            </div>
        <?php else: ?>
            <div class="col">
                <a href="users/login">
                    <button class="fs-3 mt-3">Login</button>
                </a>
            </div>
        <?php endif; ?>
    </div>
    <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-3 g-3">
        <?php
        foreach ($cats as $cat): ?>

            <div class="col cat-index">
                <div class="cat-index__wrapper">
                    <?= $this->Html->link(
                        $this->Html->image(
                            'data:image/png;base64,' . h($cat->base64_image),
                            [
                                'style' => 'width: 100%; height: 100%; object-fit: cover;',
                                'alt' => 'Cat',
                                'class' => 'cat-index__image',
                            ],
                        ),
                        ['controller' => 'Cats', 'action' => 'view', $cat->id],
                        ['escape' => false],
                    ) ?>
                    <div class="cat-index__image__footer">
                        <h1><?= $cat->function_name ?></h1>
                        <div class="cat-index__image__footer__button-a d-inline">
                            <?= $this->Form->postLink(
                                'Delete',
                                ['action' => 'delete', $cat->id],
                                ['confirm' => 'Are you sure?'],
                            )
                            ?>
                        </div>
                        <div class="cat-index__image__footer__button-a d-inline">
                            <?= $this->Form->postLink(
                                'Edit',
                                ['action' => 'edit', $cat->id],
                            )
                            ?>
                        </div>
                    </div>
                </div>
            </div>

        <?php
        endforeach; ?>
    </div>

    <div class="pagination mt-5">
        <?= $this->Paginator->first('<< ' . __('First')) ?>
        <?= $this->Paginator->prev('< ' . __('Previous')) ?>
        <?= $this->Paginator->numbers(['before' => '', 'after' => '', 'modulus' => 3]) ?>
        <?= $this->Paginator->next(__('Next') . ' >') ?>
        <?= $this->Paginator->last(__('Last') . ' >>') ?>
    </div>
</div>
