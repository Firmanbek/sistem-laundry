<?php
/**
 * @var \App\View\AppView $this
 * @var string $status
 */
$kelas = match ($status) {
    'Diterima' => 'amber',
    'Dicuci/Disetrika' => 'sky',
    'Siap Diambil' => 'teal',
    'Selesai' => 'emerald',
    default => 'sky',
};
?>
<span class="badge <?= $kelas ?>"><i></i><span><?= h($status) ?></span></span>
