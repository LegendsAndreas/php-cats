<?php

use App\Utility;

/**
 * @var \App\View\AppView       $this
 * @var \App\Model\Entity\Cat[] $cats
 * @var \App\Model\Entity\User  $currentUser
 */
$modulus = 4;
?>
<div class="level-1">
    <div class="my-5">
        <h1 class="cat-index__header">
            |--PHP cats--|
        </h1>

        <a href="https://http.cat/" target="_blank" title="Go to HTTP.cat">
            See also HTTP cats ->
        </a>
        <a href="<?= $this->Url->build('/cats/help') ?>" target="_blank" title="Go to help page">
            I need your help...
        </a>
        <div class="py-4" style="background-color: wheat; border-radius: 5px;">
            <div class="row text-center row-cols-1 row-cols-md-3 row-cols-lg-4 row-cols-xxl-4">
                <div class="col">
                    <a href="<?= $this->Url->build(['controller' => 'Cats', 'action' => 'add']) ?>" class="fs-3 mt-3 cat-index__top-button-link" title="Add new Cat">
                        Add new Cat
                    </a>
                </div>
                <div class="col">
                    <a href="<?= $this->Url->build(['controller' => 'Cats', 'action' => 'deleted']) ?>" class="fs-3 mt-3 cat-index__top-button-link"
                       title="Go to deleted Cats">
                        Deleted Cats
                    </a>
                </div>
                <div class="col">
                    <a href="<?= $this->Url->build(['controller' => 'Contributors', 'action' => 'index']) ?>" class="fs-3 mt-3 cat-index__top-button-link"
                       title="Go to Contributors">
                        Contributors
                    </a>
                </div>
                <?php
                if ($currentUser) { ?>
                    <div class="col">
                        <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>" class="fs-3 mt-3 cat-index__top-button-link" title="Logout">
                            Logout
                        </a>
                    </div>
                    <?php
                } else { ?>
                    <div class="col">
                        <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']) ?>" class="fs-3 mt-3 cat-index__top-button-link" title="Login">
                            Login
                        </a>
                    </div>
                    <?php
                }; ?>
            </div>

            <div class="row text-center mt-5 justify-content-md-center">
                <div class="col">
                    <div>
                        <input type="text"
                               class="form-control js-input-search fs-3 w-25 cat-index__input-search"
                               placeholder="Search by name">
                        <?= $this->Html->link('Search', ['controller' => 'Cats', 'action' => 'index'], [
                            'escape' => false,
                            'class'  => 'text-decoration-none js-link-search fs-3 js-search-button cat-index__input-search__button cat-index__top-button-link',
                            'href'   => '/cats/index/0',
                        ],) ?>

                        <div>
                            <?= $this->Form->label('select-column', 'Reverse Order', ['class' => 'form-check-label fs-3']) ?>
                            <?= $this->Form->checkbox('select_column', [
                                'class'   => 'form-check-input js-order-checkbox cat-index__order-checkbox',
                                'id'      => 'select-column',
                                'checked' => false,
                            ]) ?>
                        </div>
                    </div>

                </div>
            </div>

            <div class="mt-5">
                <?= $this->element('paginator', [
                    'modulus' => $modulus,
                ]) ?>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-lg-2 row-cols-xxl-3 g-3" style="justify-self: center">
            <?php
            foreach ($cats as $cat) { ?>
                <div class="col cat-index">
                    <?= $this->element('Cats/cat-template', [
                        'cat'     => $cat,
                        'buttons' => [
                            $this->Form->postLink('Delete', ['action' => 'delete', $cat->id, '?' => ['page' => $this->request->getQuery('page')]],
                                ['confirm' => 'Are you sure?', 'title' => 'Delete cat ' . $cat->id]),
                            $this->Html->link('Edit', [
                                'action' => 'edit',
                                $cat->id,
                            ], [
                                'title' => 'Edit cat ' . $cat->id,
                            ]),
                        ],
                    ]) ?>
                </div>
                <?php
            }; ?>
        </div>

        <div class="cat-index__bottom-paginator">
            <?= $this->element('paginator', [
                'modulus' => $modulus,
            ]) ?>
        </div>
    </div>
</div>

<?= $this->Html->script('Cats/index.js', ['defer' => true]); ?>
