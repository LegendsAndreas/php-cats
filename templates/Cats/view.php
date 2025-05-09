<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cat $cat
 */
$test = 1;
?>

<div class="text-center cats-view p-3 my-3">
    <p class="cats-view__function-name mt-4"><strong><?= h($cat->function_name) ?></strong></p>
    <div>
        <img src="data:image/png;base64,<?= h($cat->base64_image) ?>" alt="ops..." class="img-fluid cats-view__image"/>
    </div>

    <div class="text-start">
        <h1 class="fw-bold mb-4 text-white">Description</h1>
        <p class="cats-view__function-description"><?= h($cat->function_description) ?></p>
        <p class="cats-view__function-examples p-3 js-function-example"><strong>Usage:</strong> <?= h($cat->function_example)
            ?></p>
    </div>

    <?= $this->Html->link(
        '<button>Edit Cat</button>',
        ['action' => 'edit', $cat->id],
        ['escape' => false]) ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        boldenOutput();
    });

    function boldenOutput() {
        const functionExample = document.querySelector('.js-function-example');
        console.log(functionExample.innerHTML);
        functionExample.innerHTML = functionExample.innerHTML.replace(/Output/g, '<strong>Output</strong>');
    }
</script>
