<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pelanggan $pelangganEntity
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Pelanggan'), ['action' => 'edit', $pelangganEntity->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Pelanggan'), ['action' => 'delete', $pelangganEntity->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pelangganEntity->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Pelanggan'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Pelanggan'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="pelanggan view content">
            <h3><?= h($pelangganEntity->nama) ?></h3>
            <table>
                <tr>
                    <th><?= __('Nama') ?></th>
                    <td><?= h($pelangganEntity->nama) ?></td>
                </tr>
                <tr>
                    <th><?= __('No Hp') ?></th>
                    <td><?= h($pelangganEntity->no_hp) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($pelangganEntity->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($pelangganEntity->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($pelangganEntity->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Alamat') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($pelangganEntity->alamat)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Transaksi') ?></h4>
                <?php if (!empty($pelangganEntity->transaksi)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Nomor Nota') ?></th>
                            <th><?= __('Layanan Id') ?></th>
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
                        <?php foreach ($pelangganEntity->transaksi as $transaksi) : ?>
                        <tr>
                            <td><?= h($transaksi->id) ?></td>
                            <td><?= h($transaksi->nomor_nota) ?></td>
                            <td><?= h($transaksi->layanan_id) ?></td>
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