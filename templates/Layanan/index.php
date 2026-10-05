<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Layanan> $layanan
 */
?>
<div class="layanan index content">
    <?= $this->Html->link(__('New Layanan'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Layanan') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('nama_layanan') ?></th>
                    <th><?= $this->Paginator->sort('harga_per_kg') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($layanan as $layananEntity): ?>
                <tr>
                    <td><?= $this->Number->format($layananEntity->id) ?></td>
                    <td><?= h($layananEntity->nama_layanan) ?></td>
                    <td><?= $this->Number->format($layananEntity->harga_per_kg) ?></td>
                    <td><?= h($layananEntity->created) ?></td>
                    <td><?= h($layananEntity->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $layananEntity->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $layananEntity->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $layananEntity->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $layananEntity->id),
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