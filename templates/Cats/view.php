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
        <div style="color: white;">
            Thanks to:
            <?php
            if (!empty($cat['contributors'])) {
                foreach ($cat['contributors'] as $contributor) {
                    echo $contributor->name . ', ';
                }
            } else {
                echo 'No one :(';
            }
            ?>
        </div>
        <h2 class="fw-bold fs-1 mb-4 text-white">Description</h2>
        <p class="cats-view__function-description fs-2"><?= $cat->function_description ?></p>
        <?php if (!empty($cat['html_blocks'])) { ?>
            <div class="cats-view__function-examples p-3">
                <?php foreach ($cat['html_blocks'] as $block) { ?>
                    <?php if (isset($block->escape) && $block->escape) { ?>
                        <div class="cats-view__function-examples__<?= $block->type ?>-segment">
                            <?= empty($block->content) ? '<div>&nbsp;</div>' : "<pre>" . h($block->content) . "</pre>" ?>
                        </div>
                    <?php } else { ?>
                        <div class="cats-view__function-examples__<?= $block->type ?>-segment">
                            <?= empty($block->content) ? '<div>&nbsp;</div>' : "<pre>" . $block->content . "</pre>" ?>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        <?php } else { ?>
            <p class="cats-view__function-examples p-3 js-color-segments" style="white-space: pre-wrap"><strong>Usage:</strong> <?= h($cat->function_example) ?></p>
        <?php } ?>
    </div>

    <?= $this->Html->link('<button class="mt-3">Edit Cat</button>', ['action' => 'edit', $cat->id], ['escape' => false]) ?>
</div>

<?= $this->Html->script('/js/Cats/view.js', ['defer' => true]) ?>
