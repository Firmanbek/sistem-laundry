
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="<?= $this->Url->build('/') ?>">Sistem Laundry</a>
        <?php if ($this->request->getAttribute('identity')): ?>
        <ul class="navbar-nav me-auto">
            <li class="nav-item"><?= $this->Html->link('Pelanggan', ['controller' => 'Pelanggan', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
            <li class="nav-item"><?= $this->Html->link('Layanan', ['controller' => 'Layanan', 'action' => 'index'], ['class' => 'nav-link']) ?></li>
        </ul>
        <?= $this->Html->link('Logout', ['controller' => 'Users', 'action' => 'logout'], ['class' => 'btn btn-outline-light btn-sm']) ?>
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