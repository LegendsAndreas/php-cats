<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cat[] $cats
 * @var \App\Model\Entity\User $currentUser
 */

$modulus = 4;

?>

<div class="my-5">
    <div class="py-4" style="background-color: wheat; border-radius: 5px;">
        <div class="row text-center row-cols-1 row-cols-md-3 row-cols-lg-3 row-cols-xxl-3">
            <div class="col">
                <a href="<?= $this->Url->build(['controller' => 'Cats', 'action' => 'add']) ?>">
                    <button class="fs-3 mt-3 cat-index__top-button">Add new Cat</button>
                </a>
            </div>
            <div class="col">
                <a href="<?= $this->Url->build(['controller' => 'Cats', 'action' => 'deleted']) ?>">
                    <button class="fs-3 mt-3 cat-index__top-button">Deleted Cats</button>
                </a>
            </div>
            <?php
            if ($currentUser): ?>
                <div class="col">
                    <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>">
                        <button class="fs-3 mt-3 cat-index__top-button">Logout</button>
                    </a>
                </div>
            <?php
            else: ?>
                <div class="col">
                    <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']) ?>">
                        <button class="fs-3 mt-3 cat-index__top-button">Login</button>
                    </a>
                </div>
            <?php
            endif; ?>
        </div>

        <div class="row text-center mt-5 justify-content-md-center">
            <div class="col">
                <input type="text" class="form-control fs-3 mt-3 d-inline js-input-search w-25 cat-index__input-search"
                       placeholder="Search by name" style="background-color: white">
                <?= $this->Html->link(
                    '<button class="fs-3 mt-3 d-inline js-search-button cat-index__input-search__button">Search</button>',
                    ['controller' => 'Cats', 'action' => 'index'],
                    ['escape' => false, 'class' => 'text-decoration-none js-link-search', 'href' => '/cats/index//0'],
                ) ?>

                <div>
                    <?= $this->Form->label('select-column', 'Reverse Order', ['class' => 'form-check-label fs-3']) ?>
                    <?= $this->Form->checkbox('select_column', [
                        'class' => 'form-check-input js-order-checkbox cat-index__order-checkbox',
                        'id' => 'select-column',
                        'checked' => false,
                    ]) ?>
                </div>
            </div>
        </div>

        <?= $this->element('Cats/cats-paginator', [
            'modulus' => $modulus,
        ]) ?>
    </div>

    <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-3 g-3">
        <?php
        foreach ($cats as $cat): ?>

            <div class="col cat-index">
                <div class="cat-index__wrapper">
                    <div class="position-relative cat-index__wrapper">
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
                            ['escape' => false, 'class' => 'position-relative'],
                        ) ?>
                        <!--                        <div class="position-absolute top-0 end-0 m-3">
                            <div class="cat-index__image__footer__button-a d-inline">
                                <?php
                        /*= $this->Form->postLink(
                                                           'Delete',
                                                           ['action' => 'delete', $cat->id],
                                                           ['confirm' => 'Are you sure?'],
                                                       )
                                                       */ ?>
                            </div>
                            <div class="cat-index__image__footer__button-a d-inline">
                                <?php
                        /*= $this->Form->postLink(
                                                           'Edit',
                                                           ['action' => 'edit', $cat->id],
                                                       )
                                                       */ ?>
                            </div>
                        </div>-->
                    </div>

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
                            <?= $this->Html->link(
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

    <?= $this->element('Cats/cats-paginator', [
        'modulus' => $modulus,
    ]) ?>
</div>

<?php
$this->Html->script('index', ['defer' => true, 'type' => 'module']) ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        resizeSearchBarMobile();
        modifySearchHref();
        toggleCheckbox();
    });
</script>
