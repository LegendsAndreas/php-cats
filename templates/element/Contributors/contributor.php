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
    <td><?= $contributor->social ?></td>
    <td><?= $contributor->created ?></td>
    <td>
        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $contributor->id], ['class' => 'btn btn-primary']) ?>
        <?= $this->Html->link(__('Delete'), ['action' => 'delete', $contributor->id], ['class' => 'btn btn-danger', 'confirm' => __('Are you sure?')]) ?>
    </td>
</tr>
