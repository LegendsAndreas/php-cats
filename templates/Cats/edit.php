<?php
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
echo $this->Form->control('function_example', ['type' => 'textarea', 'required' => true]);
echo $this->Form->control('base64_image', [
    'type' => 'text',
    'required' => true,
    'class' => 'js-clear',
    // The image string can cause immense lag, because of its size, so we limit it to be hidden when overflow happens.
    'style' => 'max-width: 100%; overflow: hidden; text-overflow: ellipsis;',
]);
echo $this->Form->button('Edit Cat', ['class' => 'mt-3']);
echo $this->Form->end();
?>

<button class="js-clear-image my-4">
    Clear image field
</button>

<a href="/">
    <button>
        Back to index
    </button>
</a>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelector('.js-clear-image').addEventListener('click', function () {
            document.querySelector('.js-clear').value = '';
        });
    });
</script>
