<?php
// phpcs:ignoreFile
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cat[] $cats
 * @var \App\Model\Entity\User $currentUser
 */

?>

<div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-3 g-3">
    <?php
    foreach ($cats as $cat): ?>

        <div class="col cats-deleted">
            <div class="cats-deleted__wrapper">
                <div class="position-relative cats-deleted__wrapper">
                    <?= $this->Html->link(
                        $this->Html->image(
                            'data:image/png;base64,' . h($cat->base64_image),
                            [
                                'style' => 'width: 100%; height: 100%; object-fit: cover;',
                                'alt' => 'Cat',
                                'class' => 'cats-deleted__image',
                            ],
                        ),
                        ['controller' => 'Cats', 'action' => 'view', $cat->id],
                        ['escape' => false, 'class' => 'position-relative'],
                    ) ?>
                </div>

                <div class="cats-deleted__image__footer">
                    <h1><?= $cat->function_name ?></h1>
                    <div class="cats-deleted__image__footer__button-a d-inline">
                        <?= $this->Form->postLink(
                            'Restore',
                            ['action' => 'restore', $cat->id],
                            ['confirm' => 'Are you sure?'],
                        )
                        ?>
                    </div>
                </div>
            </div>
        </div>

    <?php
    endforeach; ?>
</div>
