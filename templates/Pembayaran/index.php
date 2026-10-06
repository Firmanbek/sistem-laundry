<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Pembayaran> $pembayaran
 */
?>
<div class="pembayaran index content">
    <?= $this->Html->link(__('New Pembayaran'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Pembayaran') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('transaksi_id') ?></th>
                    <th><?= $this->Paginator->sort('tanggal_pembayaran') ?></th>
                    <th><?= $this->Paginator->sort('jumlah_bayar') ?></th>
                    <th><?= $this->Paginator->sort('metode_pembayaran') ?></th>
                    <th><?= $this->Paginator->sort('status_pembayaran') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pembayaran as $pembayaranEntity): ?>
                <tr>
                    <td><?= $this->Number->format($pembayaranEntity->id) ?></td>
                    <td><?= $pembayaranEntity->hasValue('transaksi') ? $this->Html->link($pembayaranEntity->transaksi->nomor_nota, ['controller' => 'Transaksi', 'action' => 'view', $pembayaranEntity->transaksi->id]) : '' ?></td>
                    <td><?= h($pembayaranEntity->tanggal_pembayaran) ?></td>
                    <td><?= $this->Number->format($pembayaranEntity->jumlah_bayar) ?></td>
                    <td><?= h($pembayaranEntity->metode_pembayaran) ?></td>
                    <td><?= h($pembayaranEntity->status_pembayaran) ?></td>
                    <td><?= h($pembayaranEntity->created) ?></td>
                    <td><?= h($pembayaranEntity->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $pembayaranEntity->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $pembayaranEntity->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $pembayaranEntity->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $pembayaranEntity->id),
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