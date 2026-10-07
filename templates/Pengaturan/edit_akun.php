<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $akun
 * @var bool $diriSendiri
 */
?>
<div class="panel" style="max-width:640px">
    <div class="panel-head">
        <div>
            <h3>Edit akun <?= h($akun->role) ?></h3>
            <p><?= $diriSendiri ? 'Ini akunmu sendiri. Setelah disimpan kamu perlu masuk kembali.' : 'Kosongkan kata sandi baru kalau tidak ingin mengubahnya.' ?></p>
        </div>
    </div>
    <div style="padding:20px">
        <?= $this->Form->create($akun) ?>
        <?= $this->Form->control('nama', ['label' => 'Nama']) ?>
        <?= $this->Form->control('username', ['label' => 'Username']) ?>
        <?= $this->Form->control('password_baru', ['type' => 'password', 'label' => 'Kata sandi baru (minimal 6 karakter)', 'value' => '', 'required' => false, 'autocomplete' => 'new-password']) ?>
        <?= $this->Form->control('konfirmasi', ['type' => 'password', 'label' => 'Ulangi kata sandi baru', 'value' => '', 'required' => false, 'autocomplete' => 'new-password']) ?>
        <?php if ($diriSendiri): ?>
            <?= $this->Form->control('password_lama', ['type' => 'password', 'label' => 'Kata sandi lama (wajib untuk akunmu sendiri)', 'value' => '', 'required' => true, 'autocomplete' => 'current-password']) ?>
        <?php endif; ?>
        <?= $this->Form->button('Simpan akun') ?>
        <?= $this->Html->link('Batal', ['action' => 'index'], ['class' => 'btn-ghost', 'style' => 'margin-left:8px']) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
