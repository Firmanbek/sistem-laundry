<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Pembayaran Entity
 *
 * @property int $id
 * @property int $transaksi_id
 * @property \Cake\I18n\DateTime $tanggal_pembayaran
 * @property int $jumlah_bayar
 * @property string $metode_pembayaran
 * @property string $status_pembayaran
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Transaksi $transaksi
 */
class Pembayaran extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'transaksi_id' => true,
        'tanggal_pembayaran' => true,
        'jumlah_bayar' => true,
        'metode_pembayaran' => true,
        'status_pembayaran' => true,
        'created' => true,
        'modified' => true,
        'transaksi' => true,
    ];
}
