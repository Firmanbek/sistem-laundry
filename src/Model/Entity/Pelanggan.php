<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Pelanggan Entity
 *
 * @property int $id
 * @property string $nama
 * @property string $no_hp
 * @property string|null $alamat
 * @property string|null $nomor_wa
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 *
 * @property \App\Model\Entity\Transaksi[] $transaksi
 */
class Pelanggan extends Entity
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
        'nama' => true,
        'no_hp' => true,
        'alamat' => true,
        'created' => true,
        'modified' => true,
        'transaksi' => true,
    ];

    /**
     * Nomor WhatsApp dalam format internasional tanpa tanda "+" (contoh: 6281234567890),
     * dibuat dari isian no_hp. Null jika nomornya tidak bisa dipakai.
     *
     * @return string|null
     */
    protected function _getNomorWa(): ?string
    {
        $angka = preg_replace('/\D+/', '', (string)$this->no_hp) ?? '';
        if (str_starts_with($angka, '00')) {
            $angka = substr($angka, 2);
        }
        if (str_starts_with($angka, '0')) {
            $angka = '62' . substr($angka, 1);
        } elseif (str_starts_with($angka, '8')) {
            $angka = '62' . $angka;
        }

        return strlen($angka) >= 10 && strlen($angka) <= 15 ? $angka : null;
    }
}
