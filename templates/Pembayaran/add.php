<h3>Pembayaran Nota <?= h($transaksi->nomor_nota) ?></h3>
<p>
    Total: <?= $this->Number->format($transaksi->total_harga) ?> |
    Sudah dibayar: <?= $this->Number->format($sudahBayar) ?> |
    Sisa: <?= $this->Number->format($sisa) ?>
</p>

<?= $this->Form->create($pembayaran, ['type' => 'file']) ?>
<?= $this->Form->control('jumlah_bayar', ['type' => 'number', 'value' => $sisa]) ?>
<?= $this->Form->control('metode_pembayaran', ['options' => ['Tunai' => 'Tunai', 'Transfer' => 'Transfer', 'QRIS' => 'QRIS']]) ?>

<div id="kotak-bukti">
    <?= $this->Form->control('bukti_file', [
        'type' => 'file',
        'label' => 'Foto bukti pembayaran (wajib untuk QRIS / Transfer)',
        'accept' => 'image/*',
        'required' => false,
    ]) ?>
</div>

<?= $this->Form->button('Simpan Pembayaran') ?>
<?= $this->Form->end() ?>

<script>
(function () {
    var metode = document.getElementById('metode-pembayaran');
    var kotak = document.getElementById('kotak-bukti');
    if (!metode || !kotak) return;
    function atur() {
        var v = metode.value.toLowerCase();
        kotak.style.display = (v === 'qris' || v === 'transfer') ? '' : 'none';
    }
    metode.addEventListener('change', atur);
    atur();
})();
</script>