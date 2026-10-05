<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Layanan Entity
 *
 * @property int $id
 * @property string $nama_layanan
 * @property int $harga_per_kg
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Transaksi[] $transaksi
 */
class Layanan extends Entity
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
        'nama_layanan' => true,
        'harga_per_kg' => true,
        'created' => true,
        'modified' => true,
        'transaksi' => true,
    ];
}
