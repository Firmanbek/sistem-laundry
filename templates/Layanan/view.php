<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Layanan $layananEntity
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Layanan'), ['action' => 'edit', $layananEntity->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Layanan'), ['action' => 'delete', $layananEntity->id], ['confirm' => __('Are you sure you want to delete # {0}?', $layananEntity->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Layanan'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Layanan'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="layanan view content">
            <h3><?= h($layananEntity->nama_layanan) ?></h3>
            <table>
                <tr>
                    <th><?= __('Nama Layanan') ?></th>
                    <td><?= h($layananEntity->nama_layanan) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($layananEntity->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Harga Per Kg') ?></th>
                    <td><?= $this->Number->format($layananEntity->harga_per_kg) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($layananEntity->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($layananEntity->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Transaksi') ?></h4>
                <?php if (!empty($layananEntity->transaksi)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Nomor Nota') ?></th>
                            <th><?= __('Pelanggan Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Tanggal Masuk') ?></th>
                            <th><?= __('Tanggal Selesai') ?></th>
                            <th><?= __('Berat') ?></th>
                            <th><?= __('Subtotal') ?></th>
                            <th><?= __('Diskon') ?></th>
                            <th><?= __('Total Harga') ?></th>
                            <th><?= __('Status Laundry') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($layananEntity->transaksi as $transaksi) : ?>
                        <tr>
                            <td><?= h($transaksi->id) ?></td>
                            <td><?= h($transaksi->nomor_nota) ?></td>
                            <td><?= h($transaksi->pelanggan_id) ?></td>
                            <td><?= h($transaksi->user_id) ?></td>
                            <td><?= h($transaksi->tanggal_masuk) ?></td>
                            <td><?= h($transaksi->tanggal_selesai) ?></td>
                            <td><?= h($transaksi->berat) ?></td>
                            <td><?= h($transaksi->subtotal) ?></td>
                            <td><?= h($transaksi->diskon) ?></td>
                            <td><?= h($transaksi->total_harga) ?></td>
                            <td><?= h($transaksi->status_laundry) ?></td>
                            <td><?= h($transaksi->created) ?></td>
                            <td><?= h($transaksi->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Transaksi', 'action' => 'view', $transaksi->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Transaksi', 'action' => 'edit', $transaksi->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Transaksi', 'action' => 'delete', $transaksi->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $transaksi->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>