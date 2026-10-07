<?php
/**
 * @var \App\View\AppView $this
 */
$namaAplikasi = $namaOutlet ?? 'Sistem Laundry';
$identity = $this->request->getAttribute('identity');
$nama = $identity ? (string)$identity->get('nama') : '';
$inisial = strtoupper(mb_substr($nama !== '' ? $nama : 'U', 0, 2));
$aktif = $this->request->getParam('controller');
$role = $identity ? (string)$identity->get('role') : '';
$menu = [
    ['Dashboard', 'layout-dashboard', 'Dashboard', ['admin', 'pemilik']],
    ['Transaksi', 'shopping-bag', 'Transaksi', ['admin', 'pemilik']],
    ['Data Pelanggan', 'users', 'Pelanggan', ['admin']],
    ['Layanan & Paket', 'layers', 'Layanan', ['admin']],
    ['Laporan Keuangan', 'bar-chart-3', 'Laporan', ['pemilik']],
    ['Pengaturan Outlet', 'settings', 'Pengaturan', ['pemilik']],
];
$menu = array_filter($menu, fn ($m) => in_array($role, $m[3], true));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= h($namaAplikasi) ?>: <?= h($this->fetch('title')) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css(['freshwash', 'dashboard']) ?>
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
<div class="fw-app">
    <aside class="fw-side">
        <div>
            <div class="fw-brand">
                <span class="fw-logo"><i data-lucide="sparkles"></i></span>
                <span><?= h($namaAplikasi) ?></span>
            </div>
            <nav class="fw-nav">
                <?php foreach ($menu as [$label, $ikon, $controller]): ?>
                    <a href="<?= $this->Url->build(['controller' => $controller, 'action' => 'index']) ?>" class="<?= $aktif === $controller ? 'on' : '' ?>">
                        <i data-lucide="<?= $ikon ?>"></i><span><?= h($label) ?></span>
                    </a>
                <?php endforeach; ?>
            </nav>
        </div>
        <div class="fw-user">
            <div class="fw-me">
                <span class="fw-ava"><?= h($inisial) ?></span>
                <div><b><?= h($nama !== '' ? $nama : 'Pengguna') ?></b><small>Sistem Laundry</small></div>
            </div>
            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>" class="fw-out">
                <i data-lucide="log-out"></i><span>Keluar akun</span>
            </a>
        </div>
    </aside>
    <div class="fw-body">
        <header class="fw-top">
            <form method="get" action="<?= $this->Url->build(['controller' => 'Transaksi', 'action' => 'index']) ?>" class="fw-search">
                <i data-lucide="search"></i>
                <input type="text" name="q" value="<?= h($this->request->getQuery('q')) ?>" placeholder="Cari nota, pelanggan, atau HP...">
            </form>
            <?php if ($role === 'admin'): ?>
            <a href="<?= $this->Url->build(['controller' => 'Transaksi', 'action' => 'add']) ?>" class="button">
                <i data-lucide="plus"></i><span>Transaksi baru</span>
            </a>
            <?php endif; ?>
        </header>
        <main class="fw-main">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </main>
    </div>
</div>
<script src="https://unpkg.com/lucide@latest"></script>
<script>lucide.createIcons();</script>
<?= $this->Html->script('confirm-modal') ?>
</body>
</html>
