<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Contributor $contributor
 */
?>

<h1>Edit Contributor</h1>
<?php
echo $this->Form->create($contributor);
echo $this->Form->control('name');
echo $this->Form->control('email');
echo $this->Form->control('social');
echo $this->Form->button('Save', ['class' => 'mt-3']);
echo $this->Form->end();
?>

