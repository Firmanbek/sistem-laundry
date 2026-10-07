<?php
/**
 * @var \App\View\AppView $this
 * @var array $stat
 * @var iterable<\App\Model\Entity\Transaksi> $terakhir
 * @var string $nama
 * @var string $sapaan
 * @var string $tanggal
 */
$rp = fn ($angka) => 'Rp ' . number_format((float)$angka, 0, ',', '.');
$role = (string)$this->request->getAttribute('identity')?->get('role');
$hariIni = date('Y-m-d');
$linkTotal = $this->Url->build(['controller' => 'Transaksi', 'action' => 'index']);
$linkProses = $this->Url->build(['controller' => 'Transaksi', 'action' => 'index', '?' => ['filter' => 'proses']]);
$linkSiap = $this->Url->build(['controller' => 'Transaksi', 'action' => 'index', '?' => ['status' => 'Siap Diambil']]);
if ($role === 'pemilik') {
    $linkUang = $this->Url->build(['controller' => 'Laporan', 'action' => 'index', '?' => ['dari' => $hariIni, 'sampai' => $hariIni]]);
} else {
    $linkUang = $this->Url->build(['controller' => 'Transaksi', 'action' => 'index', '?' => $stat['belumLunas'] > 0 ? ['filter' => 'belum-lunas'] : []]);
}
?>
<div class="dash">
    <div class="dash-hero">
        <div>
            <span class="tgl"><?= h($tanggal) ?></span>
            <h2><?= h($sapaan) ?><?= $nama !== '' ? ', ' . h($nama) : '' ?>! 👋</h2>
            <p>
                <?php if ($stat['menunggu'] > 0): ?>
                    Ada <strong><?= $stat['menunggu'] ?> pesanan baru</strong> yang menunggu diproses.
                <?php else: ?>
                    Semua pesanan sudah diproses.
                <?php endif; ?>
            </p>
        </div>
        <?php if ((string)$this->request->getAttribute('identity')?->get('role') === 'admin'): ?>
        <a href="<?= $this->Url->build(['controller' => 'Transaksi', 'action' => 'add']) ?>" class="button btn-putih">Buat pesanan baru →</a>
        <?php endif; ?>
    </div>

    <div class="stat-grid">
        <a class="stat stat-link" href="<?= $linkTotal ?>">
            <div class="stat-top"><span>Total pesanan</span><div class="stat-ico sky"><i data-lucide="shopping-bag"></i></div></div>
            <div class="stat-val"><b><?= $stat['total'] ?></b><small class="t-green">+<?= $stat['hariIni'] ?> hari ini</small></div>
        </a>
        <a class="stat stat-link" href="<?= $linkProses ?>">
            <div class="stat-top"><span>Sedang diproses</span><div class="stat-ico amber"><i data-lucide="washing-machine"></i></div></div>
            <div class="stat-val"><b><?= $stat['diproses'] ?></b><small class="t-amber"><?= $stat['menunggu'] ?> antrean cuci</small></div>
        </a>
        <a class="stat stat-link" href="<?= $linkSiap ?>">
            <div class="stat-top"><span>Siap diambil</span><div class="stat-ico teal"><i data-lucide="circle-check"></i></div></div>
            <div class="stat-val"><b><?= $stat['siap'] ?></b><small class="t-teal">Menunggu pelanggan</small></div>
        </a>
        <a class="stat stat-link" href="<?= $linkUang ?>">
            <div class="stat-top"><span>Pendapatan hari ini</span><div class="stat-ico emerald"><i data-lucide="wallet"></i></div></div>
            <div class="stat-val">
                <b><?= $rp($stat['pendapatan']) ?></b>
                <?php if ($stat['belumLunas'] > 0): ?>
                    <small class="t-amber"><?= $stat['belumLunas'] ?> nota belum lunas</small>
                <?php else: ?>
                    <small class="t-green">Lunas</small>
                <?php endif; ?>
            </div>
        </a>
    </div>

    <div class="panel">
        <div class="panel-head">
            <div>
                <h3>Status pesanan terakhir</h3>
                <p>Pantau progres laundry pelanggan secara langsung</p>
            </div>
            <a href="<?= $this->Url->build(['controller' => 'Transaksi', 'action' => 'index']) ?>" class="btn-ghost">Lihat semua</a>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No. Nota</th><th>Pelanggan</th><th>Layanan</th><th>Berat</th><th>Total harga</th><th>Status progres</th><th style="text-align:right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($terakhir as $t): ?>
                    <tr>
                        <td class="nota"><?= h($t->nomor_nota) ?></td>
                        <td>
                            <span class="nama"><?= $t->hasValue('pelanggan') ? h($t->pelanggan->nama) : '' ?></span>
                            <span class="sub"><?= $t->hasValue('pelanggan') ? h($t->pelanggan->no_hp) : '' ?></span>
                        </td>
                        <td><?= $t->hasValue('layanan') ? h($t->layanan->nama_layanan) : '' ?></td>
                        <td><?= $this->Number->format($t->berat) ?> Kg</td>
                        <td class="nama"><?= $rp($t->total_harga) ?></td>
                        <td><?= $this->element('status_badge', ['status' => $t->status_laundry]) ?></td>
                        <td style="text-align:right">
                            <a class="icon-btn" title="Lihat nota" href="<?= $this->Url->build(['controller' => 'Transaksi', 'action' => 'view', $t->id]) ?>"><i data-lucide="eye"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if ($terakhir->isEmpty()): ?>
                    <tr><td colspan="7" style="text-align:center;color:var(--mute)">Belum ada transaksi.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
