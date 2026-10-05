<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Pembayaran Model
 *
 * @property \App\Model\Table\TransaksiTable&\Cake\ORM\Association\BelongsTo $Transaksis
 *
 * @method \App\Model\Entity\Pembayaran newEmptyEntity()
 * @method \App\Model\Entity\Pembayaran newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Pembayaran> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Pembayaran get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Pembayaran findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Pembayaran patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Pembayaran> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Pembayaran|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Pembayaran saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Pembayaran>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Pembayaran>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Pembayaran>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Pembayaran> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Pembayaran>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Pembayaran>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Pembayaran>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Pembayaran> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PembayaranTable extends Table
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

        $this->setTable('pembayaran');
        $this->setDisplayField('metode_pembayaran');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Transaksis', [
            'foreignKey' => 'transaksi_id',
            'className' => 'Transaksi',
            'joinType' => 'INNER',
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
            ->integer('transaksi_id')
            ->notEmptyString('transaksi_id');

        $validator
            ->dateTime('tanggal_pembayaran')
            ->requirePresence('tanggal_pembayaran', 'create')
            ->notEmptyDateTime('tanggal_pembayaran');

        $validator
            ->integer('jumlah_bayar')
            ->requirePresence('jumlah_bayar', 'create')
            ->notEmptyString('jumlah_bayar');

        $validator
            ->scalar('metode_pembayaran')
            ->maxLength('metode_pembayaran', 30)
            ->requirePresence('metode_pembayaran', 'create')
            ->notEmptyString('metode_pembayaran');

        $validator
            ->scalar('status_pembayaran')
            ->maxLength('status_pembayaran', 20)
            ->requirePresence('status_pembayaran', 'create')
            ->notEmptyString('status_pembayaran');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['transaksi_id'], 'Transaksis'), ['errorField' => 'transaksi_id']);

        return $rules;
    }
}
