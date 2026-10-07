<?php
/**
 * @var \App\View\AppView $this
 * @var array<string, mixed>|null $hasil
 * @var string|null $pesanError
 * @var string $nomorNota
 * @var \App\Model\Entity\Pengaturan|null $outlet
 * @var array<string> $alurStatus
 */
$rp = fn($angka) => 'Rp ' . number_format((float)$angka, 0, ',', '.');
?>
<?php if ($hasil === null) : ?>
    <div class="lc-card">
        <h2>Cek status cucian</h2>
        <p class="lc-sub">Masukkan nomor nota dan 4 digit terakhir nomor HP yang terdaftar.</p>

        <?php if ($pesanError) : ?>
            <div class="lc-error"><?= h($pesanError) ?></div>
        <?php endif; ?>

        <?= $this->Form->create(null) ?>
        <div class="input">
            <label for="nomor-nota">Nomor nota</label>
            <?= $this->Form->text('nomor_nota', [
                'id' => 'nomor-nota',
                'value' => $nomorNota,
                'placeholder' => 'LDR-00001',
                'required' => true,
                'autocomplete' => 'off',
                'autocapitalize' => 'characters',
                'maxlength' => 20,
            ]) ?>
        </div>
        <div class="input">
            <label for="hp4">4 digit terakhir nomor HP</label>
            <?= $this->Form->text('hp4', [
                'id' => 'hp4',
                'inputmode' => 'numeric',
                'pattern' => '[0-9]{4}',
                'maxlength' => 4,
                'placeholder' => '1234',
                'required' => true,
                'autocomplete' => 'off',
            ]) ?>
            <span class="lc-hint">Nomor HP yang Anda berikan saat menyerahkan cucian.</span>
        </div>
        <?= $this->Form->button('Cek status') ?>
        <?= $this->Form->end() ?>
    </div>
<?php else : ?>
    <?php
    $status = (string)$hasil['status'];
    $posisi = array_search($status, $alurStatus, true);
    $kelas = match ($status) {
        'Diterima' => 'amber',
        'Dicuci/Disetrika' => 'sky',
        'Siap Diambil' => 'teal',
        'Selesai' => 'emerald',
        default => 'sky',
    };
    $pesanStatus = match ($status) {
        'Diterima' => 'Cucian Anda sudah kami terima dan akan segera diproses.',
        'Dicuci/Disetrika' => 'Cucian Anda sedang dicuci dan disetrika.',
        'Siap Diambil' => 'Cucian Anda sudah siap diambil.',
        'Selesai' => 'Cucian Anda sudah selesai dan diambil.',
        default => '',
    };
    ?>
    <div class="lc-card">
        <div class="lc-head">
            <span class="lc-nota"><?= h($hasil['nomor_nota']) ?></span>
            <span class="lc-badge <?= $kelas ?>"><?= h($status) ?></span>
        </div>
        <p class="lc-pesan">Halo, <?= h($hasil['nama_depan']) ?>. <?= h($pesanStatus) ?></p>

        <?php if ($posisi !== false) : ?>
            <ol class="lc-steps">
                <?php foreach ($alurStatus as $i => $langkah) : ?>
                    <li class="<?= $i < $posisi ? 'done' : ($i === $posisi ? 'now' : '') ?>"><?= h($langkah) ?></li>
                <?php endforeach; ?>
            </ol>
        <?php endif; ?>

        <dl class="lc-rincian">
            <?php if ($hasil['layanan']) : ?>
                <div><dt>Layanan</dt><dd><?= h($hasil['layanan']) ?></dd></div>
            <?php endif; ?>
            <div><dt>Berat</dt><dd><?= h(number_format($hasil['berat'], 1, ',', '.')) ?> kg</dd></div>
            <?php if ($hasil['tanggal_masuk']) : ?>
                <div><dt>Diterima</dt><dd><?= h($hasil['tanggal_masuk']->format('d-m-Y H:i')) ?></dd></div>
            <?php endif; ?>
            <?php if ($hasil['tanggal_selesai']) : ?>
                <div><dt>Selesai</dt><dd><?= h($hasil['tanggal_selesai']->format('d-m-Y H:i')) ?></dd></div>
            <?php endif; ?>
            <div><dt>Total tagihan</dt><dd><?= h($rp($hasil['total'])) ?></dd></div>
            <div><dt>Sudah dibayar</dt><dd><?= h($rp($hasil['dibayar'])) ?></dd></div>
        </dl>

        <?php if ($hasil['kekurangan'] > 0) : ?>
            <div class="lc-bayar sisa">
                Sisa pembayaran <?= h($rp($hasil['kekurangan'])) ?>
                <small>Mohon dilunasi saat mengambil cucian.</small>
            </div>
        <?php else : ?>
            <div class="lc-bayar lunas">Pembayaran lunas</div>
        <?php endif; ?>
    </div>

    <p style="text-align:center"><?= $this->Html->link('Cek nota lain', ['controller' => 'Lacak', 'action' => 'index']) ?></p>
<?php endif; ?>

<?php if ($outlet && ($outlet->alamat || $outlet->no_telepon)) : ?>
    <p class="lc-kontak">
        <?php if ($outlet->alamat) : ?><?= h($outlet->alamat) ?><br><?php endif; ?>
        <?php if ($outlet->no_telepon) : ?>Hubungi kami: <b><?= h($outlet->no_telepon) ?></b><?php endif; ?>
    </p>
<?php endif; ?>
