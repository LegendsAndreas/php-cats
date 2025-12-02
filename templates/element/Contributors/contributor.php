<?php
/**
 * @var \App\View\AppView             $this
 * @var \App\Model\Entity\Contributor $contributor
 */
?>
<tr>
    <td><?= $contributor->id ?></td>
    <td><?= !empty($contributor->name) ? $contributor->name : '&nbsp;' ?></td>
    <td><?= !empty($contributor->email) ? $contributor->email : '&nbsp;' ?></td>
    <td>
        <?php if (!empty($contributor->social)) { ?>
            <a href="<?= $contributor->social ?>" target="_blank" title="Go to <?= h($contributor->name) ?>'s social profile"><?= $contributor->social ?></a>
        <?php } else {?>
            &nbsp;
        <?php } ?>
    </td>
    <td><?= $contributor->created ?></td>
    <td>
        <div class="dropdown">
            <button class="btn btn-danger dropdown-toggle contributor-button" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
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
<!--        --><?php //= $this->Html->link(__('View'), ['action' => 'view', $contributor->id], ['class' => 'btn btn-warning']) ?>
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
    .contributor-button {
        padding-bottom: 0;
        height: fit-content;
    }
    .contributor-button::after {
        margin-left: 0;
    }
</style>
<?php $this->end() ?>
