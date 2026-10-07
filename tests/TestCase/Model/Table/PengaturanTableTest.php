<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PengaturanTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PengaturanTable Test Case
 */
class PengaturanTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PengaturanTable
     */
    protected $Pengaturan;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Pengaturan',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Pengaturan') ? [] : ['className' => PengaturanTable::class];
        $this->Pengaturan = $this->getTableLocator()->get('Pengaturan', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Pengaturan);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\PengaturanTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
