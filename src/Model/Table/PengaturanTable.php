<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Pengaturan Model
 *
 * @method \App\Model\Entity\Pengaturan newEmptyEntity()
 * @method \App\Model\Entity\Pengaturan newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Pengaturan> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Pengaturan get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Pengaturan findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Pengaturan patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Pengaturan> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Pengaturan|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Pengaturan saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Pengaturan>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Pengaturan>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Pengaturan>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Pengaturan> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Pengaturan>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Pengaturan>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Pengaturan>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Pengaturan> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PengaturanTable extends Table
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

        $this->setTable('pengaturan');
        $this->setDisplayField('nama_outlet');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->scalar('nama_outlet')
            ->maxLength('nama_outlet', 100)
            ->requirePresence('nama_outlet', 'create')
            ->notEmptyString('nama_outlet');

        $validator
            ->scalar('alamat')
            ->maxLength('alamat', 255)
            ->allowEmptyString('alamat');

        $validator
            ->scalar('no_telepon')
            ->maxLength('no_telepon', 30)
            ->allowEmptyString('no_telepon');

        $validator
            ->scalar('catatan_nota')
            ->maxLength('catatan_nota', 255)
            ->allowEmptyString('catatan_nota');

        return $validator;
    }
}
