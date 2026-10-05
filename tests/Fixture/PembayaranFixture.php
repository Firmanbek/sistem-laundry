<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PembayaranFixture
 */
class PembayaranFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'pembayaran';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'transaksi_id' => 1,
                'tanggal_pembayaran' => '2026-10-05 09:02:59',
                'jumlah_bayar' => 1,
                'metode_pembayaran' => 'Lorem ipsum dolor sit amet',
                'status_pembayaran' => 'Lorem ipsum dolor ',
                'created' => '2026-10-05 09:02:59',
                'modified' => '2026-10-05 09:02:59',
            ],
        ];
        parent::init();
    }
}
