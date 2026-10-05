<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LayananFixture
 */
class LayananFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'layanan';
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
                'nama_layanan' => 'Lorem ipsum dolor sit amet',
                'harga_per_kg' => 1,
                'created' => '2026-10-05 08:46:57',
                'modified' => '2026-10-05 08:46:57',
            ],
        ];
        parent::init();
    }
}
