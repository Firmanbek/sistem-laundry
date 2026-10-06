<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pembayaran $pembayaranEntity
 * @var string[]|\Cake\Collection\CollectionInterface $transaksis
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $pembayaranEntity->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $pembayaranEntity->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Pembayaran'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="pembayaran form content">
            <?= $this->Form->create($pembayaranEntity) ?>
            <fieldset>
                <legend><?= __('Edit Pembayaran') ?></legend>
                <?php
                    echo $this->Form->control('transaksi_id', ['options' => $transaksis]);
                    echo $this->Form->control('tanggal_pembayaran');
                    echo $this->Form->control('jumlah_bayar');
                    echo $this->Form->control('metode_pembayaran');
                    echo $this->Form->control('status_pembayaran');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
