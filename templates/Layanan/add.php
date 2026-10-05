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
            <?= $this->Html->link(__('List Layanan'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="layanan form content">
            <?= $this->Form->create($layananEntity) ?>
            <fieldset>
                <legend><?= __('Add Layanan') ?></legend>
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
