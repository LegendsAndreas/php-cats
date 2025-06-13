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
        One way that you can help, is by sending me more pictures of cats, which you think would fit the function definitions, and maybe even come with
        suggestions on what functionalities of PHP/CakePHP should be added to the site!
    </p>
    <p class="cats-help__text">Right now, you can just contact me with an email at my business email:
        <a href="mailto:andreas2x2@gmail.com">andreas2x2@gmail.com</a>
    </p>
    <p class="cats-help__text">
        I am also trying to setup an emailing service, so if you have any suggestions, please do contact me!
    </p>

<!--    <?php /*= $this->Form->create(null, [
        'type' => 'file', // Allows file uploads
        'url' => ['controller' => 'Cats', 'action' => 'help'], // Use correct controller and action
        'class' => 'cats-help-form'
    ]) */?>
    <div>
        <?php /*= $this->Form->control('email_title', [
            'label' => 'Title',
            'required' => true,
            'class' => 'cats-help-form__input'
        ]) */?>
    </div>

    <div>
        <?php /*= $this->Form->control('email_description', [
            'type' => 'textarea',
            'label' => 'Description',
            'required' => true,
            'class' => 'cats-help-form__input'
        ]) */?>
    </div>

    <div>
        <?php /*= $this->Form->control('email_pictures', [
            'type' => 'file',
            'multiple' => true,
            'accept' => 'image/*',
            'label' => 'Attach Pictures',
            'class' => 'cats-help-form__input'
        ]) */?>
    </div>

    <?php /*= $this->Form->button('Send Email', ['class' => 'cats-help-form__button']) */?>
    --><?php /*= $this->Form->end() */?>

</div>
