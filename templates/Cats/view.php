<?php
// phpcs:ignoreFile
/**
 * @var \App\View\AppView     $this
 * @var \App\Model\Entity\Cat $cat
 */
?>

<div class="text-center cats-view p-3 my-3">
    <h1 class="cats-view__function-name mt-4"><strong><?= h($cat->function_name) ?></strong></h1>
    <div>
        <img src="data:image/png;base64,<?= h($cat->base64_image) ?>" alt="ops..." class="img-fluid cats-view__image"/>
    </div>

    <div class="text-start">
        <h2 class="fw-bold fs-1 mb-4 text-white">Description</h2>
        <p class="cats-view__function-description fs-2"><?= $cat->function_description ?></p>
        <p class="cats-view__function-examples p-3 js-color-comments"><strong>Usage:</strong> <?= h($cat->function_example) ?>
        </p>
    </div>

    <?= $this->Html->link('<button>Edit Cat</button>', ['action' => 'edit', $cat->id], ['escape' => false]) ?>
</div>

<?php $this->append('css') ?>
<style>
    .comment {
        color: green;
    }
</style>
<?php $this->end() ?>

<?php $this->append('script') ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        colorComment();
    });

    function colorComment() {
        const description = document.querySelector('.js-color-comments');
        if (!description) {
            console.warn('js-color-comments element not found.');
            return;
        }
        description.innerHTML = description.innerHTML.replace(/CC(.*)CC/g, (match, matchContent) => {
            return `<span class="comment">${matchContent}</span>`;
        });
    }
</script>
<?php $this->end() ?>
