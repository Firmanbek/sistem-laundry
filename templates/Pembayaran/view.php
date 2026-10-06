<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pembayaran $pembayaranEntity
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Pembayaran'), ['action' => 'edit', $pembayaranEntity->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Pembayaran'), ['action' => 'delete', $pembayaranEntity->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pembayaranEntity->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Pembayaran'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Pembayaran'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="pembayaran view content">
            <h3><?= h($pembayaranEntity->metode_pembayaran) ?></h3>
            <table>
                <tr>
                    <th><?= __('Transaksi') ?></th>
                    <td><?= $pembayaranEntity->hasValue('transaksi') ? $this->Html->link($pembayaranEntity->transaksi->nomor_nota, ['controller' => 'Transaksi', 'action' => 'view', $pembayaranEntity->transaksi->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Metode Pembayaran') ?></th>
                    <td><?= h($pembayaranEntity->metode_pembayaran) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status Pembayaran') ?></th>
                    <td><?= h($pembayaranEntity->status_pembayaran) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($pembayaranEntity->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Jumlah Bayar') ?></th>
                    <td><?= $this->Number->format($pembayaranEntity->jumlah_bayar) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tanggal Pembayaran') ?></th>
                    <td><?= h($pembayaranEntity->tanggal_pembayaran) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($pembayaranEntity->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($pembayaranEntity->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>