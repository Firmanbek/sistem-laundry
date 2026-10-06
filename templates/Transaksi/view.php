<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Transaksi $transaksiEntity
 */
?>

<?php
$totalDibayar = 0;
foreach ($transaksiEntity->pembayaran as $p) {
    $totalDibayar += (float)$p->jumlah_bayar;
}
$kekurangan = max((float)$transaksiEntity->total_harga - $totalDibayar, 0);
if ($kekurangan <= 0) {
    $statusBayar = 'Lunas';
} elseif ($totalDibayar > 0) {
    $statusBayar = 'DP';
} else {
    $statusBayar = 'Belum Bayar';
}
?>

<div class="row">
    <aside class="column">
        <div class="side-nav">
    <h4 class="heading"><?= __('Actions') ?></h4>
    <?= $this->Html->link(__('Edit Transaksi'), ['action' => 'edit', $transaksiEntity->id], ['class' => 'side-nav-item']) ?>
    <?= $this->Form->postLink(__('Delete Transaksi'), ['action' => 'delete', $transaksiEntity->id], ['confirm' => __('Are you sure you want to delete # {0}?', $transaksiEntity->id), 'class' => 'side-nav-item']) ?>
    <?= $this->Html->link(__('List Transaksi'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
    <?= $this->Html->link(__('New Transaksi'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
    <?php if ($transaksiEntity->status_laundry !== 'Selesai'): ?>
        <?= $this->Form->postLink(
            __('Lanjutkan Status'),
            ['action' => 'ubahStatus', $transaksiEntity->id],
            ['confirm' => __('Ubah status pesanan ini?'), 'class' => 'side-nav-item']
        ) ?>
    <?php endif; ?>
    <?= $this->Html->link(__('Bayar'), ['controller' => 'Pembayaran', 'action' => 'add', $transaksiEntity->id], ['class' => 'side-nav-item']) ?>
</div>
    </aside>
    <div class="column column-80">
        <div class="transaksi view content">
            <h3><?= h($transaksiEntity->nomor_nota) ?></h3>
            <table>
                <tr>
                    <th><?= __('Nomor Nota') ?></th>
                    <td><?= h($transaksiEntity->nomor_nota) ?></td>
                </tr>
                <tr>
                    <th><?= __('Pelanggan') ?></th>
                    <td><?= $transaksiEntity->hasValue('pelanggan') ? $this->Html->link($transaksiEntity->pelanggan->nama, ['controller' => 'Pelanggan', 'action' => 'view', $transaksiEntity->pelanggan->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Layanan') ?></th>
                    <td><?= $transaksiEntity->hasValue('layanan') ? $this->Html->link($transaksiEntity->layanan->nama_layanan, ['controller' => 'Layanan', 'action' => 'view', $transaksiEntity->layanan->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $transaksiEntity->hasValue('user') ? $this->Html->link($transaksiEntity->user->nama, ['controller' => 'Users', 'action' => 'view', $transaksiEntity->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Status Laundry') ?></th>
                    <td><?= h($transaksiEntity->status_laundry) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($transaksiEntity->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Berat') ?></th>
                    <td><?= $this->Number->format($transaksiEntity->berat) ?></td>
                </tr>
                <tr>
                    <th><?= __('Subtotal') ?></th>
                    <td><?= $this->Number->format($transaksiEntity->subtotal) ?></td>
                </tr>
                <tr>
                    <th><?= __('Diskon') ?></th>
                    <td><?= $this->Number->format($transaksiEntity->diskon) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total Harga') ?></th>
                    <td><?= $this->Number->format($transaksiEntity->total_harga) ?></td>
                </tr>
                <tr>
                <th><?= __('Total Dibayar') ?></th>
                <td><?= $this->Number->format($totalDibayar) ?></td>
                </tr>
                <tr>
                    <th><?= __('Kekurangan') ?></th>
                    <td><?= $this->Number->format($kekurangan) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status Pembayaran') ?></th>
                    <td><?= h($statusBayar) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tanggal Masuk') ?></th>
                    <td><?= $transaksiEntity->tanggal_masuk?->format('d/m/Y H:i') ?></td>
                </tr>
                <tr>
                    <th><?= __('Tanggal Selesai') ?></th>
                    <td><?= $transaksiEntity->tanggal_selesai?->format('d/m/Y H:i') ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= $transaksiEntity->created?->format('d/m/Y H:i') ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= $transaksiEntity->modified?->format('d/m/Y H:i') ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Pembayaran') ?></h4>
                <?php if (!empty($transaksiEntity->pembayaran)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Tanggal Pembayaran') ?></th>
                            <th><?= __('Jumlah Bayar') ?></th>
                            <th><?= __('Metode Pembayaran') ?></th>
                            <th><?= __('Status Pembayaran') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($transaksiEntity->pembayaran as $pembayaran) : ?>
                        <tr>
                            <td><?= h($pembayaran->id) ?></td>
                            <td><?= $pembayaran->tanggal_pembayaran?->format('d/m/Y H:i') ?></td>
                            <td><?= h($pembayaran->jumlah_bayar) ?></td>
                            <td><?= h($pembayaran->metode_pembayaran) ?></td>
                            <td><?= h($pembayaran->status_pembayaran) ?></td>
                            <td><?= $pembayaran->created?->format('d/m/Y H:i') ?></td>
                            <td><?= $pembayaran->modified?->format('d/m/Y H:i') ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Pembayaran', 'action' => 'view', $pembayaran->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Pembayaran', 'action' => 'edit', $pembayaran->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Pembayaran', 'action' => 'delete', $pembayaran->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $pembayaran->id),
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