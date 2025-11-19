<?php
// phpcs:ignoreFile
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cat $cat
 */
?>

<h1>Add Cat</h1>
<?php
echo $this->Form->create($cat);
echo $this->Form->control('function_name', ['type' => 'text', 'required' => true]);
echo $this->Form->control('function_description', ['type' => 'textarea', 'required' => true]);
echo $this->Form->control('function_example', ['type' => 'textarea', 'required' => true, 'class' => 'cats-add__textarea']);
echo $this->Form->control('Image', ['type' => 'file', 'required' => true, 'class' => 'js-add-image']);
echo $this->Form->control('base64_image', ['type' => 'hidden', 'id' => 'base64_image']);
echo $this->Form->button('Add new cat', ['class' => 'mt-3', 'type' => 'submit']);
echo $this->Form->end();
?>
