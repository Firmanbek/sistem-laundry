<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Pelanggan> $pelanggan
 */
?>
<div class="pelanggan index content">
    <?= $this->Html->link(__('New Pelanggan'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Pelanggan') ?></h3>
    <?= $this->Form->create(null, ['type' => 'get', 'class' => 'mb-3']) ?>
<div class="input-group">
    <?= $this->Form->control('cari', [
        'label' => false,
        'placeholder' => 'Cari nama atau telepon',
        'value' => $this->request->getQuery('cari'),
        'class' => 'form-control',
        'templates' => ['inputContainer' => '{{content}}'],
    ]) ?>
    <button class="btn btn-primary" type="submit">Cari</button>
</div>
<?= $this->Form->end() ?>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('nama') ?></th>
                    <th><?= $this->Paginator->sort('no_hp') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pelanggan as $pelangganEntity): ?>
                <tr>
                    <td><?= $this->Number->format($pelangganEntity->id) ?></td>
                    <td><?= h($pelangganEntity->nama) ?></td>
                    <td><?= h($pelangganEntity->no_hp) ?></td>
                    <td><?= h($pelangganEntity->created) ?></td>
                    <td><?= h($pelangganEntity->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $pelangganEntity->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $pelangganEntity->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $pelangganEntity->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $pelangganEntity->id),
                            ]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>