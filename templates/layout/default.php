<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

//dd($this);

// I assume that we get the title from the controller name.
if ($this->getRequest()->getParam('controller') === 'Cats') {
    $this->assign('title', 'PHP Cats');
}

?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'fonts', 'cake', 'styles']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body>
<main class="main">
    <a href="/" class="position-fixed top-0 left-0 p-2 z-3">
        <?= $this->Html->image('php-cats-logo-1.svg', ['alt' => 'Logo', 'class' => 'img-fluid layout-default__image']) ?>
    </a>
    <div class="container">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </div>
</main>
<footer>
</footer>
</body>
</html>

<!--'defer' makes it load when the whole DOM is ready -->
<?= $this->Html->script('script', ['defer' => true, 'type' => 'module']) ?>


<?php
$this->append('script') ?>
<script>
    let audioUnlocked = false;

    document.addEventListener('DOMContentLoaded', () => {
        const audio = document.getElementById('hover-audio');

        document.addEventListener('click', () => {
            audioUnlocked = true;
        });

        document.querySelectorAll('.hover-sound').forEach(el => {
            el.addEventListener('mouseenter', () => {
                if (!audioUnlocked) return;

                audio.play().catch(e => {
                    console.warn("Audio play failed:", e);
                });
            });
        });
    });
</script>
<?php
$this->end() ?>
