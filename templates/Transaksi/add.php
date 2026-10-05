<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Transaksi $transaksi
 * @var iterable $daftarPelanggan
 * @var iterable $daftarLayanan
 */
?>
<div class="transaksi form content">
    <?= $this->Html->link(__('Kembali'), ['action' => 'index'], ['class' => 'button float-right']) ?>
    <h3><?= __('Transaksi Baru') ?></h3>
    <?= $this->Form->create($transaksi) ?>
    <fieldset>
        <?= $this->Form->control('pelanggan_id', [
            'label' => 'Pelanggan',
            'options' => $daftarPelanggan,
            'empty' => '-- Pilih pelanggan --',
        ]) ?>
        <?= $this->Form->control('layanan_id', [
            'label' => 'Layanan',
            'options' => $daftarLayanan,
            'empty' => '-- Pilih layanan --',
        ]) ?>
        <?= $this->Form->control('berat', ['label' => 'Berat (kg)', 'type' => 'number', 'step' => '0.1', 'min' => '0.1']) ?>
        <?= $this->Form->control('diskon', ['label' => 'Diskon (Rp)', 'type' => 'number', 'min' => '0', 'value' => 0]) ?>
    </fieldset>
    <?= $this->Form->button(__('Simpan')) ?>
    <?= $this->Form->end() ?>
</div>