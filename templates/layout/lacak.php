<?php
/**
 * @var \App\View\AppView $this
 */
$namaAplikasi = $namaOutlet ?? 'Sistem Laundry';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title><?= h($namaAplikasi) ?>: Cek Status Cucian</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('freshwash') ?>
    <?= $this->Html->css('lacak') ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body>
<div class="lc-page">
    <div class="lc-wrap">
        <div class="fw-brand lc-brand">
            <span class="fw-logo"><i data-lucide="sparkles"></i></span>
            <span><?= h($namaAplikasi) ?></span>
        </div>
        <?= $this->fetch('content') ?>
    </div>
</div>
<script src="https://unpkg.com/lucide@latest"></script>
<script>lucide.createIcons();</script>
</body>
</html>
