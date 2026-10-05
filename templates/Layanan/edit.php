<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Layanan $layananEntity
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $layananEntity->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $layananEntity->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Layanan'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="layanan form content">
            <?= $this->Form->create($layananEntity) ?>
            <fieldset>
                <legend><?= __('Edit Layanan') ?></legend>
                <?php
                    echo $this->Form->control('nama_layanan');
                    echo $this->Form->control('harga_per_kg');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
