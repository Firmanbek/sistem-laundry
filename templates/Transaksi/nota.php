<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Transaksi $transaksiEntity
 */
$t = $transaksiEntity;
$totalDibayar = 0;
foreach ($t->pembayaran as $p) {
    $totalDibayar += (float)$p->jumlah_bayar;
}
$kekurangan = max((float)$t->total_harga - $totalDibayar, 0);
$rp = fn ($n) => 'Rp ' . number_format((float)$n, 0, ',', '.');
$outlet = $namaOutlet ?? 'Sistem Laundry';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nota <?= h($t->nomor_nota) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; padding: 20px; background: #f1f5f9; font-family: 'Plus Jakarta Sans', Arial, sans-serif; font-size: 13px; color: #0f172a; }
        .toolbar { max-width: 340px; margin: 0 auto 14px; display: flex; gap: 8px; }
        .toolbar button, .toolbar a { flex: 1; padding: 10px; border: 0; border-radius: 10px; font: inherit; font-weight: 700; text-align: center; text-decoration: none; cursor: pointer; }
        .toolbar button { background: #0284c7; color: #fff; }
        .toolbar a { background: #e2e8f0; color: #334155; }
        .nota { max-width: 340px; margin: 0 auto; background: #fff; padding: 20px 18px; border-radius: 12px; box-shadow: 0 6px 20px rgba(15,23,42,.1); }
        .c { text-align: center; }
        h1 { margin: 0; font-size: 18px; font-weight: 800; }
        .muted { color: #64748b; font-size: 12px; }
        hr { border: 0; border-top: 1px dashed #94a3b8; margin: 12px 0; }
        table { width: 100%; border-collapse: collapse; }
        td { padding: 3px 0; vertical-align: top; }
        td:last-child { text-align: right; }
        .tot td { font-weight: 800; font-size: 14px; }
        .lunas { display: inline-block; padding: 3px 12px; border-radius: 99px; font-weight: 800; font-size: 12px; }
        .lunas.ya { background: #dcfce7; color: #15803d; }
        .lunas.belum { background: #fee2e2; color: #b91c1c; }
        @page { size: 80mm auto; margin: 4mm; }
        @media print {
            body { background: #fff; padding: 0; }
            .toolbar { display: none; }
            .nota { max-width: 72mm; margin: 0; box-shadow: none; border-radius: 0; padding: 0; }
        }
    </style>
</head>
<body>
<div class="toolbar">
    <button type="button" onclick="window.print()">Cetak / Simpan PDF</button>
    <a href="<?= $this->Url->build(['action' => 'view', $t->id]) ?>">Kembali</a>
</div>

<div class="nota">
    <div class="c">
        <h1><?= h($outlet) ?></h1>
        <div class="muted">Nota Laundry</div>
    </div>
    <hr>
    <table>
        <tr><td>No. Nota</td><td><b><?= h($t->nomor_nota) ?></b></td></tr>
        <tr><td>Pelanggan</td><td><?= h($t->pelanggan->nama ?? '-') ?></td></tr>
        <tr><td>Masuk</td><td><?= h($t->tanggal_masuk ? $t->tanggal_masuk->format('d/m/Y H:i') : '-') ?></td></tr>
        <?php if ($t->tanggal_selesai): ?>
        <tr><td>Selesai</td><td><?= h($t->tanggal_selesai->format('d/m/Y H:i')) ?></td></tr>
        <?php endif; ?>
        <tr><td>Status</td><td><?= h($t->status_laundry) ?></td></tr>
    </table>
    <hr>
    <table>
        <tr><td colspan="2"><b><?= h($t->layanan->nama_layanan ?? 'Layanan') ?></b></td></tr>
        <tr><td><?= h($t->berat) ?> kg</td><td><?= $rp($t->subtotal) ?></td></tr>
        <?php if ((float)$t->diskon > 0): ?>
        <tr><td>Diskon</td><td>- <?= $rp($t->diskon) ?></td></tr>
        <?php endif; ?>
    </table>
    <hr>
    <table>
        <tr class="tot"><td>Total</td><td><?= $rp($t->total_harga) ?></td></tr>
        <?php foreach ($t->pembayaran as $p): ?>
        <tr>
            <td class="muted"><?= h($p->tanggal_pembayaran ? $p->tanggal_pembayaran->format('d/m H:i') : '') ?> · <?= h($p->metode_pembayaran) ?></td>
            <td><?= $rp($p->jumlah_bayar) ?></td>
        </tr>
        <?php endforeach; ?>
        <tr><td>Dibayar</td><td><?= $rp($totalDibayar) ?></td></tr>
        <tr class="tot"><td>Kekurangan</td><td><?= $rp($kekurangan) ?></td></tr>
    </table>
    <div class="c" style="margin-top:12px">
        <span class="lunas <?= $kekurangan > 0 ? 'belum' : 'ya' ?>">
            <?= $kekurangan > 0 ? 'BELUM LUNAS' : 'LUNAS' ?>
        </span>
    </div>
    <hr>
<?php
$penutup = trim((string)($teksNota ?? ''));
if ($penutup === '') {
    $penutup = "Cek status cucian di halaman Lacak dengan nomor nota ini.\nTerima kasih sudah mencuci di {outlet}.";
}
$penutup = str_replace('{outlet}', $outlet, $penutup);
?>
<div class="c muted"><?= nl2br(h($penutup)) ?></div>
</div>
</body>
</html>