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
        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $contributor->id], ['class' => 'btn btn-primary']) ?>
        <?= $this->Html->link(__('Delete'), ['action' => 'delete', $contributor->id], ['class' => 'btn btn-danger', 'confirm' => __('Are you sure?')]) ?>
        <?= $this->Html->link(__('View'), ['action' => 'view', $contributor->id], ['class' => 'btn btn-warning']) ?>
    </td>
</tr>
