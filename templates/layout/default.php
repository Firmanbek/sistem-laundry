
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand" href="<?= $this->Url->build('/') ?>">Sistem Laundry</a>
            <?php $identity = $this->request->getAttribute('identity'); ?>
<?php if ($identity) : ?>
    <div class="ms-auto d-flex align-items-center text-white">
        <span class="me-3"><?= h($identity->get('nama')) ?> (<?= h($identity->get('role')) ?>)</span>
        <?= $this->Html->link('Keluar', ['controller' => 'Users', 'action' => 'logout'], ['class' => 'btn btn-sm btn-light']) ?>
    </div>
<?php endif; ?>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>