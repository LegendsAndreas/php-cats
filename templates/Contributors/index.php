<?php
/**
 * @var \App\View\AppView               $this
 * @var \App\Model\Entity\Contributor   $newContributor
 * @var \App\Model\Entity\Contributor[] $contributors
 */
?>

<h1>
    Contributors
</h1>
<div class="new-contributor">
    <h3>Add a new contributor</h3>
    <?= $this->Form->create($newContributor) ?>
    <div class="row">
        <div class="col">
            <?= $this->Form->control('name', ['required' => true]) ?>
        </div>
        <div class="col">
            <?= $this->Form->control('email', ['required' => true]) ?>
        </div>
        <div class="col">
            <?= $this->Form->control('social', ['required' => true]) ?>
        </div>
    </div>
    <?= $this->Form->button('Add contributor') ?>
    <?= $this->Form->end() ?>
</div>


<?php if (count($contributors) === 0) {
    echo '<h4>No contributors yet.</h4>';
} else { ?>
    <?= $this->element('paginator', [
        'modulus' => 2
    ]) ?>
    <div class="contributors">
        <h3>Contributors list</h3>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Social</th>
                <th>Created</th>
                <th>Contributions</th>
                <th>Options</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($contributors as $contributor) {
                echo $this->element('Contributors/contributor', ['contributor' => $contributor]);
            }
            ?>
            </tbody>
        </table>
    </div>
<?php } ?>

<style>
    .new-contributor {
        padding: 1rem;
        margin-bottom: 2rem;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }
</style>
