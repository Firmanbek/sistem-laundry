<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TransaksiTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TransaksiTable Test Case
 */
class TransaksiTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TransaksiTable
     */
    protected $Transaksi;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Transaksi',
        'app.Pelanggans',
        'app.Layanans',
        'app.Users',
        'app.Pembayaran',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Transaksi') ? [] : ['className' => TransaksiTable::class];
        $this->Transaksi = $this->getTableLocator()->get('Transaksi', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Transaksi);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\TransaksiTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\TransaksiTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
