<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Transaksi $transaksiEntity
 * @var string[]|\Cake\Collection\CollectionInterface $pelanggans
 * @var string[]|\Cake\Collection\CollectionInterface $layanans
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $transaksiEntity->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $transaksiEntity->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Transaksi'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="transaksi form content">
            <?= $this->Form->create($transaksiEntity) ?>
            <fieldset>
                <legend><?= __('Edit Transaksi') ?></legend>
                <?php
                    echo $this->Form->control('nomor_nota');
                    echo $this->Form->control('pelanggan_id', ['options' => $pelanggans]);
                    echo $this->Form->control('layanan_id', ['options' => $layanans]);
                    echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
                    echo $this->Form->control('tanggal_masuk');
                    echo $this->Form->control('tanggal_selesai', ['empty' => true]);
                    echo $this->Form->control('berat');
                    echo $this->Form->control('diskon');
                    echo $this->Form->control('status_laundry');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
