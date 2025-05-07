<?php
/**
 * @var \App\Model\Entity\Cat[] $cats
 */

?>

<div class="container my-5">
    <div class="row text-center">
        <div class="col">
            <a href="cats/add">
                <button class="fs-3">Add new Cat</button>
            </a>
        </div>
    </div>
    <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-3 g-3">
        <?php
        foreach ($cats as $cat): ?>

            <div class="col cat-index">
                <div class="cat-index__wrapper">
                    <?= $this->Html->link(
                        $this->Html->image(
                            'data:image/png;base64,' . $cat->base64_image,
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
</div>
