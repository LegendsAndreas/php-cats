<?php
/**
 * @var \App\View\AppView $this
 */
?>

<div class="cats-help">
    <p class="cats-help__text">
        Hello friendo! This site is not fully completed, as you might have noticed. For example, some of the cat pictures chosen don't really fit
        the actual function definition, the same picture is used multiple times, and the list of functions/functionalities is not very long.
    </p>
    <p class="cats-help__text">
        One way that you can help, is by sending me more pictures of cats that you think would fit the function definitions, and maybe even come with
        suggestions on what functionalities of PHP/CakePHP should be added to the site!
    </p>
    <p class="cats-help__text">Right now, you can just contact me with an email at my business email:
        <a href="mailto:andreasbxb@pm.me">andreasbxb@pm.me</a>
    </p>

    <?= $this->Form->create(null, [
        'type' => 'file', // Allows file uploads
        'url' => ['controller' => 'Cats', 'action' => 'help'], // Use correct controller and action
        'class' => 'cats-help-form'
    ]) ?>
    <div>
        <?= $this->Form->control('email_title', [
            'label' => 'Title',
            'required' => true,
            'class' => 'cats-help-form__input'
        ]) ?>
    </div>

    <div>
        <?= $this->Form->control('email_description', [
            'type' => 'textarea',
            'label' => 'Description',
            'required' => true,
            'class' => 'cats-help-form__input'
        ]) ?>
    </div>

    <div>
        <?= $this->Form->control('email_pictures', [
            'type' => 'file',
            'multiple' => true,
            'accept' => 'image/*',
            'label' => 'Attach Pictures',
            'class' => 'cats-help-form__input'
        ]) ?>
    </div>

    <?= $this->Form->button('Send Email', ['class' => 'cats-help-form__button']) ?>
    <?= $this->Form->end() ?>

</div>
