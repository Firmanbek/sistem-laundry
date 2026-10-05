<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Layanan Model
 *
 * @property \App\Model\Table\TransaksiTable&\Cake\ORM\Association\HasMany $Transaksi
 *
 * @method \App\Model\Entity\Layanan newEmptyEntity()
 * @method \App\Model\Entity\Layanan newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Layanan> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Layanan get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Layanan findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Layanan patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Layanan> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Layanan|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Layanan saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Layanan>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Layanan>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Layanan>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Layanan> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Layanan>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Layanan>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Layanan>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Layanan> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LayananTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('layanan');
        $this->setDisplayField('nama_layanan');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Transaksi', [
            'foreignKey' => 'layanan_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('nama_layanan')
            ->maxLength('nama_layanan', 100)
            ->requirePresence('nama_layanan', 'create')
            ->notEmptyString('nama_layanan');

        $validator
            ->integer('harga_per_kg')
            ->requirePresence('harga_per_kg', 'create')
            ->notEmptyString('harga_per_kg');

        return $validator;
    }
}
