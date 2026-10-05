<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TransaksiFixture
 */
class TransaksiFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'transaksi';
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
                'nomor_nota' => 'Lorem ipsum dolor ',
                'pelanggan_id' => 1,
                'layanan_id' => 1,
                'user_id' => 1,
                'tanggal_masuk' => '2026-10-05 09:02:58',
                'tanggal_selesai' => '2026-10-05 09:02:58',
                'berat' => 1.5,
                'subtotal' => 1,
                'diskon' => 1,
                'total_harga' => 1,
                'status_laundry' => 'Lorem ipsum dolor ',
                'created' => '2026-10-05 09:02:58',
                'modified' => '2026-10-05 09:02:58',
            ],
        ];
        parent::init();
    }
}
