<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PembayaranTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PembayaranTable Test Case
 */
class PembayaranTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PembayaranTable
     */
    protected $Pembayaran;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Pembayaran',
        'app.Transaksis',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Pembayaran') ? [] : ['className' => PembayaranTable::class];
        $this->Pembayaran = $this->getTableLocator()->get('Pembayaran', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Pembayaran);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\PembayaranTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\PembayaranTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
