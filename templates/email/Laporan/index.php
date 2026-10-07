<?php
/**
 * @var \App\View\AppView $this
 * @var string $dari
 * @var string $sampai
 * @var float $totalMasuk
 * @var int $jumlahBayar
 * @var array<string, float> $perMetode
 * @var array<string, float> $perHari
 * @var iterable<\App\Model\Entity\Transaksi> $notaPeriode
 * @var float $totalTagihan
 * @var float $piutang
 */
$rp = fn ($angka) => 'Rp ' . number_format((float)$angka, 0, ',', '.');
$url = fn ($d, $s) => $this->Url->build(['action' => 'index', '?' => ['dari' => $d, 'sampai' => $s]]);
$hariIni = date('Y-m-d');
?>
<div class="dash">
    <div class="panel">
        <?= $this->Form->create(null, ['type' => 'get', 'class' => 'lap-filter']) ?>
            <div class="input"><label for="dari">Dari tanggal</label><input type="date" id="dari" name="dari" value="<?= h($dari) ?>"></div>
            <div class="input"><label for="sampai">Sampai tanggal</label><input type="date" id="sampai" name="sampai" value="<?= h($sampai) ?>"></div>
            <button type="submit">Terapkan</button>
            <div class="lap-quick">
                <a class="btn-ghost" href="<?= $url($hariIni, $hariIni) ?>">Hari ini</a>
                <a class="btn-ghost" href="<?= $url(date('Y-m-d', strtotime('-6 days')), $hariIni) ?>">7 hari</a>
                <a class="btn-ghost" href="<?= $url(date('Y-m-01'), $hariIni) ?>">Bulan ini</a>
            </div>
        <?= $this->Form->end() ?>
    </div>

    <div class="stat-grid">
        <div class="stat">
            <div class="stat-top"><span>Pemasukan</span><div class="stat-ico emerald"><i data-lucide="wallet"></i></div></div>
            <div class="stat-val"><b><?= $rp($totalMasuk) ?></b><small class="t-green"><?= $jumlahBayar ?> pembayaran</small></div>
        </div>
        <div class="stat">
            <div class="stat-top"><span>Nota masuk</span><div class="stat-ico sky"><i data-lucide="shopping-bag"></i></div></div>
            <div class="stat-val"><b><?= count($notaPeriode->toArray()) ?></b><small class="t-teal">pada periode ini</small></div>
        </div>
        <div class="stat">
            <div class="stat-top"><span>Total tagihan</span><div class="stat-ico teal"><i data-lucide="receipt"></i></div></div>
            <div class="stat-val"><b><?= $rp($totalTagihan) ?></b></div>
        </div>
        <div class="stat">
            <div class="stat-top"><span>Piutang</span><div class="stat-ico amber"><i data-lucide="clock"></i></div></div>
            <div class="stat-val"><b><?= $rp($piutang) ?></b><small class="t-amber">belum dibayar</small></div>
        </div>
    </div>

    <div class="lap-grid">
        <div class="panel">
            <div class="panel-head"><div><h3>Pemasukan per metode</h3></div></div>
            <table>
                <tbody>
                    <?php foreach ($perMetode as $metode => $jumlah): ?>
                    <tr><td><?= h($metode) ?></td><td class="angka"><?= $rp($jumlah) ?></td></tr>
                    <?php endforeach; ?>
                    <?php if (!$perMetode): ?><tr><td style="color:var(--mute)">Belum ada pembayaran.</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="panel">
            <div class="panel-head"><div><h3>Pemasukan per hari</h3></div></div>
            <table>
                <tbody>
                    <?php foreach ($perHari as $hari => $jumlah): ?>
                    <tr><td><?= h(date('d/m/Y', strtotime($hari))) ?></td><td class="angka"><?= $rp($jumlah) ?></td></tr>
                    <?php endforeach; ?>
                    <?php if (!$perHari): ?><tr><td style="color:var(--mute)">Belum ada pembayaran.</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="panel">
        <div class="panel-head"><div><h3>Rincian nota</h3><p>Nota yang masuk pada periode terpilih</p></div></div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr><th>No. Nota</th><th>Pelanggan</th><th>Tgl masuk</th><th style="text-align:right">Total</th><th style="text-align:right">Dibayar</th><th style="text-align:right">Kekurangan</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($notaPeriode as $n): ?>
                    <tr>
                        <td class="nota"><?= $this->Html->link($n->nomor_nota, ['controller' => 'Transaksi', 'action' => 'view', $n->id]) ?></td>
                        <td><?= $n->hasValue('pelanggan') ? h($n->pelanggan->nama) : '' ?></td>
                        <td><?= $n->tanggal_masuk?->format('d/m/Y H:i') ?></td>
                        <td class="angka"><?= $rp($n->total_harga) ?></td>
                        <td class="angka"><?= $rp($n->total_dibayar) ?></td>
                        <td class="angka <?= $n->kekurangan > 0 ? 'kurang' : 'lunas' ?>"><?= $n->kekurangan > 0 ? $rp($n->kekurangan) : 'Lunas' ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (!count($notaPeriode->toArray())): ?>
                    <tr><td colspan="6" style="text-align:center;color:var(--mute)">Tidak ada nota pada periode ini.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
