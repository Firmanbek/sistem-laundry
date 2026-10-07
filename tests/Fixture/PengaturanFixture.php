<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PengaturanFixture
 */
class PengaturanFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'pengaturan';
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
                'nama_outlet' => 'Lorem ipsum dolor sit amet',
                'alamat' => 'Lorem ipsum dolor sit amet',
                'no_telepon' => 'Lorem ipsum dolor sit amet',
                'catatan_nota' => 'Lorem ipsum dolor sit amet',
                'created' => '2026-10-07 12:33:53',
                'modified' => '2026-10-07 12:33:53',
            ],
        ];
        parent::init();
    }
}
