<?php
/**
 * @var \App\View\AppView      $this
 * @var \App\Model\Entity\User $user
 */
?>

<?= $this->Form->create($user) ?>
<legend><?= __('Edit User') ?></legend>
<?php
echo $this->Form->control('email');
echo $this->Form->control('current password');
echo $this->Form->control('new password', ['type' => 'password']);
echo $this->Form->control('repeat password', ['type' => 'password']);
?>
<?= $this->Form->button(__('Submit')) ?>
<?php $this->Form->end() ?>
