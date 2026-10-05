<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Transaksi Entity
 *
 * @property int $id
 * @property string $nomor_nota
 * @property int $pelanggan_id
 * @property int $layanan_id
 * @property int|null $user_id
 * @property \Cake\I18n\DateTime $tanggal_masuk
 * @property \Cake\I18n\DateTime|null $tanggal_selesai
 * @property string $berat
 * @property int $subtotal
 * @property int $diskon
 * @property int $total_harga
 * @property string $status_laundry
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Pelanggan $pelanggan
 * @property \App\Model\Entity\Layanan $layanan
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Pembayaran[] $pembayaran
 */
class Transaksi extends Entity
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
        'nomor_nota' => true,
        'pelanggan_id' => true,
        'layanan_id' => true,
        'user_id' => true,
        'tanggal_masuk' => true,
        'tanggal_selesai' => true,
        'berat' => true,
        'subtotal' => true,
        'diskon' => true,
        'total_harga' => true,
        'status_laundry' => true,
        'created' => true,
        'modified' => true,
        'pelanggan' => true,
        'layanan' => true,
        'user' => true,
        'pembayaran' => true,
    ];
}
