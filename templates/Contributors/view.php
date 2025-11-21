<?php
/**
 * @var \App\View\AppView             $this
 * @var \App\Model\Entity\Contributor $contributor
 */
?>

<div class="contributor">
    <h1><?= h($contributor->name) ?></h1>
    <h2><?= h($contributor->email) ?></h2>
    <a href="<?= $contributor->social ?>" target="_blank" title="Go to <?= h($contributor->name) ?>'s social profile">
        <h2><?= $contributor->social ?></h2>
    </a>
</div>
