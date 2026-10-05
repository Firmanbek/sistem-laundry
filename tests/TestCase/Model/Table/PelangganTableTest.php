<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PelangganTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PelangganTable Test Case
 */
class PelangganTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PelangganTable
     */
    protected $Pelanggan;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Pelanggan',
        'app.Transaksi',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Pelanggan') ? [] : ['className' => PelangganTable::class];
        $this->Pelanggan = $this->getTableLocator()->get('Pelanggan', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Pelanggan);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\PelangganTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
