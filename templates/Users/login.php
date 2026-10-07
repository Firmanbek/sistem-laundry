<?php $this->setLayout('login'); ?>

<?= $this->Form->create(null, ['class' => 'fw-login-form']) ?>
<div class="fw-field">
    <label for="username">Username</label>
    <div class="fw-input">
        <i data-lucide="user"></i>
        <?= $this->Form->text('username', ['id' => 'username', 'required' => true, 'autofocus' => true, 'autocomplete' => 'username', 'placeholder' => 'Masukkan username']) ?>
    </div>
</div>
<div class="fw-field">
    <label for="password">Password</label>
    <div class="fw-input">
        <i data-lucide="lock"></i>
        <?= $this->Form->password('password', ['id' => 'password', 'required' => true, 'autocomplete' => 'current-password', 'placeholder' => 'Masukkan password']) ?>
        <button type="button" class="fw-eye" id="togglePassword" aria-label="Tampilkan password" aria-pressed="false">
            <i data-lucide="eye" class="eye-on"></i>
            <i data-lucide="eye-off" class="eye-off"></i>
        </button>
    </div>
</div>
<?= $this->Form->button('Masuk', ['type' => 'submit', 'class' => 'fw-submit']) ?>
<?= $this->Form->end() ?>

<script>
(function () {
    var btn = document.getElementById('togglePassword');
    var input = document.getElementById('password');
    btn.addEventListener('click', function () {
        var show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        btn.setAttribute('aria-pressed', show ? 'true' : 'false');
        btn.setAttribute('aria-label', show ? 'Sembunyikan password' : 'Tampilkan password');
    });
})();
</script>
