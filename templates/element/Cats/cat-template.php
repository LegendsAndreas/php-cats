<?php
/**
 * @var \App\View\AppView     $this
 * @var \App\Model\Entity\Cat $cat
 * @var array                 $buttons
 */
?>

<div class="cat-index__wrapper">
    <div class="position-relative cat-index__wrapper">
        <?= $this->Html->link($this->Html->image('data:image/png;base64,' . h($cat->base64_image), [
            'style' => 'width: 100%; height: 100%; object-fit: cover;',
            'alt'   => "$cat->function_name cat image",
            'class' => 'cat-index__image img-fluid',
            'title' => 'Go to cat ' . $cat->id,
        ]), ['controller' => 'Cats', 'action' => 'view', $cat->id], ['escape' => false, 'class' => 'position-relative'],) ?>
    </div>

    <div class="cat-index__image__footer">
        <h2><?= $cat->function_name ?></h2>
        <?php foreach ($buttons as $button) { ?>
          <div class="cat-index__image__footer__button-a d-inline">
              <?= $button ?>
          </div>
        <?php } ?>
    </div>
</div>
