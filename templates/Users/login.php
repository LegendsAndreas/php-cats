<?php
/**
 * @var \App\View\AppView $this
 */

?>

<div class="users form login">
    <?= $this->Flash->render() ?>
    <h3>Login</h3>
    <div class="login__level-1">
        <?= $this->Form->create() ?>
        <fieldset>
            <legend><?= __('Please enter your username and password') ?></legend>
            <?= $this->Form->control('email', ['required' => true]) ?>
            <?= $this->Form->control('password', ['required' => true]) ?>
        </fieldset>
        <?= $this->Form->button('Login', ['class' => 'mt-3', 'type' => 'submit']) ?>
        <?= $this->Form->end() ?>

        <?= $this->Html->link("Add User", ['action' => 'add']) ?>
        <?= $this->Html->link("Go to index", ['controller' => 'Cats', 'action' => 'index', 'class' => 'd-block']) ?>
    </div>
</div>
