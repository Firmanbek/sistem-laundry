<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pelanggan $pelangganEntity
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $pelangganEntity->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $pelangganEntity->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Pelanggan'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="pelanggan form content">
            <?= $this->Form->create($pelangganEntity) ?>
            <fieldset>
                <legend><?= __('Edit Pelanggan') ?></legend>
                <?php
                    echo $this->Form->control('nama');
                    echo $this->Form->control('no_hp');
                    echo $this->Form->control('alamat');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
