<?php
// phpcs:ignoreFile
/**
 * @var \App\View\AppView               $this
 * @var \App\Model\Entity\Cat           $cat
 * @var \App\Model\Entity\Contributor[] $contributors
 */
?>

<h1>Add Cat</h1>
<?php
echo $this->Form->create($cat);
echo $this->Form->control('function_name', ['type' => 'text', 'required' => true]);
echo $this->Form->control('function_description', ['type' => 'textarea', 'required' => true]);
echo $this->Form->control('function_example', ['type' => 'textarea', 'required' => true, 'class' => 'cats-edit__textarea']);
echo $this->Form->control('Image', ['type' => 'file', 'class' => 'js-add-image']);
echo $this->Form->control('base64_image', ['type' => 'hidden', 'id' => 'base64_image']); ?>

<button class="btn btn-primary js-add-contributor" type="button">
    Add contributor
</button>
<div class="contributors">
    <legend class="contributor-legend">Contributors</legend>
    <?php foreach ($contributors as $index => $contributor) { ?>
        <div class="contributor">
            <?= $this->Form->control("contributors.$index.name", ['label' => 'Contributor name', 'value' => $contributor->name ?? '']) ?>
            <button class="btn btn-danger js-remove-contributor" type="button" value="<?= $index ?>">
                Remove
            </button>
        </div>
    <?php } ?>
</div>
<?php echo $this->Form->button('Edit Cat', ['class' => 'mt-3']);
echo $this->Form->end();
?>

<?= $this->Html->link('<button class="my-4">Go to Cat</button>', ['action' => 'view', $cat->id], ['escape' => false]) ?>

<?php $this->append('css') ?>
<style>
    .contributor-legend {
        position: relative;
        bottom: 30px;
        font-size: 25px;
        background-color: white;
        padding-left: 5px;
    }
    .contributors {
        border: 1px solid #ccc;
        padding: 10px;
        margin-top: 20px;
    }
</style>
<?php $this->end() ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let currentContributorIndex = <?= count($contributors) - 1; ?>;
        document.querySelector('.js-add-contributor').addEventListener('click', function () {
            currentContributorIndex++;
            document.querySelector('.contributors').appendChild(createContributorBlock());
        })

        function createContributorBlock() {
            let newContributor = document.createElement('div');
            newContributor.classList.add('contributor');

            let inputText = document.createElement('div');
            inputText.classList.add('input');
            inputText.classList.add('text');

            let label         = document.createElement('label');
            label.textContent = 'Contributor name';
            label.setAttribute('for', 'contributors-' + currentContributorIndex + '-name');

            let input       = document.createElement('input');
            input.type      = 'text';
            input.name      = 'contributors[' + currentContributorIndex + '][name]';
            input.id        = 'contributors-' + currentContributorIndex + '-name';
            input.maxLength = 255;

            inputText.appendChild(label);
            inputText.appendChild(input);
            newContributor.appendChild(inputText);

            let removeButton = document.createElement('button');
            removeButton.classList.add('btn');
            removeButton.classList.add('btn-danger');
            removeButton.classList.add('js-remove-contributor');
            removeButton.textContent = 'Remove';
            removeButton.type        = 'button';
            removeButton.value       = currentContributorIndex;
            addDeleteListener(removeButton);

            newContributor.appendChild(removeButton);

            return newContributor;
        }

        function reindexFromIndex(index) {
            console.log('Reindexing from index:', index);
            console.log('current index: ', currentContributorIndex);
            let startingIndex = index;
            let contributors  = document.querySelectorAll('.contributor');
            for (let i = startingIndex; i <= currentContributorIndex; i++) {
                let contributor = contributors[i];
                contributor.querySelector('button').value = i;
                contributor.querySelector('label').setAttribute('for', 'contributors-' + i + '-name');
                let input = contributor.querySelector('input');
                input.setAttribute('name', 'contributors[' + i + '][name]');
                input.setAttribute('id', 'contributors-' + i + '-name');
            }
        }

        function addDeleteListener(button) {
            button.addEventListener('click', function () {
                let buttonValue = parseInt(button.value);
                button.closest('.contributor').remove();
                currentContributorIndex--;
                reindexFromIndex(buttonValue);
            })
        }

        document.querySelectorAll('.js-remove-contributor').forEach(function (button) {
            addDeleteListener(button);
        })
    })
</script>
