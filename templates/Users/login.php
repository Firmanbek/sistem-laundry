<?php $this->setLayout('login'); ?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h4 class="text-center mb-4">Masuk</h4>
                <?= $this->Form->create(null) ?>
                <div class="mb-3">
                    <label class="form-label" for="username">Username</label>
                    <?= $this->Form->text('username', ['class' => 'form-control', 'id' => 'username', 'required' => true, 'autofocus' => true]) ?>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Password</label>
                    <?= $this->Form->password('password', ['class' => 'form-control', 'id' => 'password', 'required' => true]) ?>
                </div>
                <?= $this->Form->button('Masuk', ['class' => 'btn btn-primary w-100']) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>