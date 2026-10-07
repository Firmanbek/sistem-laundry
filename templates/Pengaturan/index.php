<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pengaturan $outlet
 * @var iterable<\App\Model\Entity\User> $users
 * @var int $idSaya
 */
?>
<div class="dash" style="max-width:760px">
    <div class="panel">
        <div class="panel-head">
            <div>
                <h3>Pengaturan outlet</h3>
                <p>Identitas laundry. Nama outlet tampil di sidebar dan halaman login.</p>
            </div>
        </div>
        <div style="padding:20px">
            <?= $this->Form->create($outlet) ?>
            <?= $this->Form->control('nama_outlet', ['label' => 'Nama outlet']) ?>
            <?= $this->Form->control('alamat', ['label' => 'Alamat', 'type' => 'textarea', 'rows' => 3]) ?>
            <?= $this->Form->control('no_telepon', ['label' => 'No. telepon']) ?>
            <?= $this->Form->control('catatan_nota', ['label' => 'Catatan di nota', 'type' => 'textarea', 'rows' => 2]) ?>
            <?= $this->Form->button('Simpan pengaturan') ?>
            <?= $this->Form->end() ?>
        </div>
    </div>

    <div class="panel">
        <div class="panel-head">
            <div>
                <h3>Akun pengguna</h3>
                <p>Ubah nama, username, dan kata sandi admin atau pemilik.</p>
            </div>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr><th>Nama</th><th>Username</th><th>Role</th><th style="text-align:right">Aksi</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                    <tr>
                        <td class="nama"><?= h($u->nama) ?><?= $u->id === $idSaya ? ' (kamu)' : '' ?></td>
                        <td><?= h($u->username) ?></td>
                        <td><span class="badge <?= $u->role === 'pemilik' ? 'emerald' : 'sky' ?>"><i></i><span><?= h(ucfirst((string)$u->role)) ?></span></span></td>
                        <td style="text-align:right"><?= $this->Html->link('Edit', ['action' => 'editAkun', $u->id]) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
