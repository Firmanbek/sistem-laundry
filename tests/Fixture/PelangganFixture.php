<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PelangganFixture
 */
class PelangganFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'pelanggan';
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
                'nama' => 'Lorem ipsum dolor sit amet',
                'no_hp' => 'Lorem ipsum dolor ',
                'alamat' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created' => '2026-10-05 08:46:09',
                'modified' => '2026-10-05 08:46:09',
            ],
        ];
        parent::init();
    }
}
