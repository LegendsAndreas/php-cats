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

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'fonts', 'cake', 'script']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
<main class="main">
    <div class="container">
<!--        <a href="#" class="hover-sound">Hover me!</a>

        <audio id="hover-audio" preload="auto">
            <source src="<?php /*= $this->Url->build('/sound/fart-83471.mp3') */?>" type="audio/mpeg">
        </audio>-->
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </div>
</main>
<footer>
</footer>
</body>
</html>

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
