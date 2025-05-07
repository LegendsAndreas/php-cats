<?php
/**
 * @var \Cake\View\View $this
 * @var \App\Model\Entity\Cat $cat
 */


?>
<div class="card">
    test
    <img src="data:image/png;base64,<?= $cat->base64_image ?>" alt="ops..." class="img-fluid"/>
</div>

<h1><?= h($cat->function_name) ?></h1>
<p><?= h($cat->function_description) ?></p>
