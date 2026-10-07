<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Pengaturan Entity
 *
 * @property int $id
 * @property string $nama_outlet
 * @property string|null $alamat
 * @property string|null $no_telepon
 * @property string|null $catatan_nota
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 */
class Pengaturan extends Entity
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
        'nama_outlet' => true,
        'alamat' => true,
        'no_telepon' => true,
        'catatan_nota' => true,
        'created' => true,
        'modified' => true,
    ];
}
