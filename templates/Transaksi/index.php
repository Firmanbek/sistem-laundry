<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Transaksi> $transaksi
 * @var array $daftarStatus
 */
?>
<div class="transaksi index content">
    <?= $this->Html->link(__('Transaksi Baru'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Transaksi') ?></h3>

    <?= $this->Form->create(null, ['type' => 'get', 'class' => 'mb-3']) ?>
    <div class="input-group">
        <?= $this->Form->control('status', [
            'label' => false,
            'type' => 'select',
            'options' => array_combine($daftarStatus, $daftarStatus),
            'empty' => 'Semua status',
            'value' => $this->request->getQuery('status'),
            'class' => 'form-select',
            'templates' => ['inputContainer' => '{{content}}'],
        ]) ?>
        <button class="btn btn-primary" type="submit">Filter</button>
    </div>
    <?= $this->Form->end() ?>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('nomor_nota', 'No. Nota') ?></th>
                    <th><?= $this->Paginator->sort('pelanggan_id', 'Pelanggan') ?></th>
                    <th><?= $this->Paginator->sort('layanan_id', 'Layanan') ?></th>
                    <th><?= $this->Paginator->sort('tanggal_masuk', 'Tgl Masuk') ?></th>
                    <th><?= $this->Paginator->sort('berat', 'Berat (kg)') ?></th>
                    <th><?= $this->Paginator->sort('total_harga', 'Total') ?></th>
                    <th><?= $this->Paginator->sort('status_laundry', 'Status') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transaksi as $transaksiEntity): ?>
                <tr>
                    <td><?= h($transaksiEntity->nomor_nota) ?></td>
                    <td><?= $transaksiEntity->hasValue('pelanggan') ? h($transaksiEntity->pelanggan->nama) : '' ?></td>
                    <td><?= $transaksiEntity->hasValue('layanan') ? h($transaksiEntity->layanan->nama_layanan) : '' ?></td>
                    <td><?= h($transaksiEntity->tanggal_masuk) ?></td>
                    <td><?= $this->Number->format($transaksiEntity->berat) ?></td>
                    <td>Rp <?= number_format((float)$transaksiEntity->total_harga, 0, ',', '.') ?></td>
                    <td><?= h($transaksiEntity->status_laundry) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $transaksiEntity->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $transaksiEntity->id]) ?>
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