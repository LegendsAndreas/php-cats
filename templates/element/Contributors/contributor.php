<?php
/**
 * @var \App\View\AppView             $this
 * @var \App\Model\Entity\Contributor $contributor
 */
?>

<tr>
    <td><?= $contributor->id ?></td>
    <td><?= $contributor->name ?></td>
    <td><?= $contributor->email ?></td>
    <td>
        <a href="<?= $contributor->social ?>" target="_blank" title="Go to <?= h($contributor->name) ?>'s social profile">
            <?= $contributor->social ?>
        </a>
    </td>
    <td><?= $contributor->created ?></td>
    <td>
        <div class="dropdown">
            <button class="btn btn-danger dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <?php if (!empty($contributor->cats)) { ?>
                    <?php foreach ($contributor->cats as $cat) { ?>
                        <li><a class="dropdown-item" href="<?= $this->Url->build(['controller' => 'Cats', 'action' => 'view', $cat->id]) ?>"><?= $cat->function_name ?></a>
                        </li>
                    <?php } ?>
                <?php } else {
                    echo '<li><a class="dropdown-item" href="#">No cats yet</a></li>';
                } ?>
            </ul>
        </div>
    </td>
    <td>
        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $contributor->id], ['class' => 'btn btn-primary']) ?>
        <?= $this->Html->link(__('Delete'), ['action' => 'delete', $contributor->id], ['class' => 'btn btn-danger', 'confirm' => __('Are you sure?')]) ?>
        <?= $this->Html->link(__('View'), ['action' => 'view', $contributor->id], ['class' => 'btn btn-warning']) ?>
    </td>
</tr>

<?php $this->append('css') ?>
<style>
    .dropdown-toggle::after {
        display: inline-block;
        content: "";
        border-top: 1.3em solid;
        border-right: 1.3em solid transparent;
        border-bottom: 0;
        border-left: 1.3em solid transparent;
    }
</style>
<?php $this->end() ?>
