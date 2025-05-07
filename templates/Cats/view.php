<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cat $cat
 */
$test = 1;
?>

<div class="text-center js-">
    <p class="cats-view__function-name mt-4"><strong><?= h($cat->function_name) ?></strong></p>
    <div>
        <img src="data:image/png;base64,<?= h($cat->base64_image) ?>" alt="ops..." class="img-fluid"/>
    </div>

    <div class="text-start">
        <h1 class="fw-bold mb-4">Description</h1>
        <p class="cats-view__function-description"><?= h($cat->function_description) ?></p>
        <p class="cats-view__function-description"><strong>Usage: </strong><?= h($cat->function_example) ?></p>
    </div>
    <?= $this->element('terminal-window', [
        'text' => 'Tester',
        'functionName' => $cat->function_name,
    ]) ?>
</div>
