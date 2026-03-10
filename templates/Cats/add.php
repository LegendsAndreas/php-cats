<?php
// phpcs:ignoreFile

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cat $cat
 */
?>

<div class="cats-add">
    <h1>Add Cat</h1>
    <div class="cats-add level-1">

        <?php
        echo $this->Form->create($cat);
        echo $this->Form->control('function_name', [
            'type' => 'text',
            'required' => true,
            'templates' => [
                'inputContainer' => '<div class="cats-add level-2">{{content}}</div>',
            ],
        ]);
        echo $this->Form->control('function_description', [
            'type' => 'textarea',
            'required' => true,
            'templates' => [
                'inputContainer' => '<div class="cats-add level-2">{{content}}</div>',
            ],
        ]);
        echo $this->Form->control('Image', [
            'type' => 'file',
            'required' => true,
            'class' => 'js-add-image',
            'templates' => [
                'inputContainer' => '<div class="cats-add level-2 cats-add__image-input">{{content}}</div>',
            ],
        ]);
        echo $this->Form->control('base64_image', ['type' => 'hidden', 'id' => 'base64_image']);
        ?>

        <div class="cats-add level-2">
            <?= $this->element('Cats/html-blocks-editor') ?>
        </div>

        <div class="cats-edit level-2">
            <button class="js-add-contributor" type="button">
                Add contributor
            </button>

            <div class="contributors">
                <div class="contributor">
                    <fieldset>
                        <legend class="contributor-legend">Contributor 1</legend>
                        <?= $this->Form->control('contributors.0.name', ['label' => 'Contributor name']) ?>
                        <?= $this->Form->control('contributors.0.email', ['label' => 'Contributor email']) ?>
                        <?= $this->Form->control('contributors.0.social', ['label' => 'Contributor social']) ?>
                    </fieldset>
                </div>
            </div>
        </div>

        <?php
        echo $this->Form->button('Add new cat', ['class' => 'mt-3', 'type' => 'submit']);
        echo $this->Form->end();
        ?>
    </div>

</div>

<?php
$this->append('css') ?>
<style>
    .contributor-legend {
        position: relative;
        bottom: 30px;
        font-size: 25px;
        background-color: white;
        padding-left: 5px;
    }

    .contributor {
        border: 1px solid #ccc;
        padding: 10px;
        margin-top: 20px;
    }
</style>
<?php
$this->end() ?>

<?php
$this->append('script') ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let currentContributorIndex = 0;
        document.querySelector('.js-add-contributor').addEventListener('click', function () {
            currentContributorIndex++;
            let newContributor = document.querySelector('.contributor').cloneNode(true);
            newContributor = resetData(newContributor);
            document.querySelector('.contributors').appendChild(newContributor);
        })

        function resetData(el) {
            el.querySelectorAll("input").forEach(input => {
                input.value = '';
                input.name = input.name.replace(/\d+/g, currentContributorIndex);
            })
            el.querySelector('legend').textContent = `Contributor ${currentContributorIndex + 1}`;
            return el;
        }
    })
</script>
<?php
$this->end() ?>

<?= $this->Html->script('Cats/catImage', ['defer' => true]); ?>
