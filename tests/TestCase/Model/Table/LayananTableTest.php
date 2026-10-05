<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LayananTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LayananTable Test Case
 */
class LayananTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LayananTable
     */
    protected $Layanan;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Layanan',
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
        $config = $this->getTableLocator()->exists('Layanan') ? [] : ['className' => LayananTable::class];
        $this->Layanan = $this->getTableLocator()->get('Layanan', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Layanan);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\LayananTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
