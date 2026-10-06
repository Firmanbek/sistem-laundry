<h3>Pembayaran Nota <?= h($transaksi->nomor_nota) ?></h3>
<p>
    Total: <?= $this->Number->format($transaksi->total_harga) ?> |
    Sudah dibayar: <?= $this->Number->format($sudahBayar) ?> |
    Sisa: <?= $this->Number->format($sisa) ?>
</p>

<?= $this->Form->create($pembayaran) ?>
<?= $this->Form->control('jumlah_bayar', ['type' => 'number', 'value' => $sisa]) ?>
<?= $this->Form->control('metode_pembayaran', ['options' => ['Tunai' => 'Tunai', 'Transfer' => 'Transfer', 'QRIS' => 'QRIS']]) ?>
<?= $this->Form->button('Simpan Pembayaran') ?>
<?= $this->Form->end() ?>