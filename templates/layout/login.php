<?php
/**
 * @var \App\View\AppView $this
 */
$namaAplikasi = 'Sistem Laundry';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($namaAplikasi) ?>: Masuk</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('freshwash') ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body>
<div class="fw-auth">
    <div class="fw-auth-card">
        <div class="fw-auth-brand">
            <div class="fw-brand">
                <span class="fw-logo"><i data-lucide="sparkles"></i></span>
                <span><?= h($namaAplikasi) ?></span>
            </div>
            <div>
                <h2>Kelola usaha laundry lebih rapi</h2>
                <p>Catat transaksi, pantau status cucian, dan cek pembayaran dalam satu tempat.</p>
            </div>
        </div>
        <div class="fw-auth-form">
            <h2>Selamat datang kembali</h2>
            <p>Masuk untuk mengelola operasional laundry.</p>
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </div>
</div>
<script src="https://unpkg.com/lucide@latest"></script>
<script>lucide.createIcons();</script>
</body>
</html>
