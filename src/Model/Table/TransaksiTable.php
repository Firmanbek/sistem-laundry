<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Transaksi Model
 *
 * @property \App\Model\Table\PelangganTable&\Cake\ORM\Association\BelongsTo $Pelanggans
 * @property \App\Model\Table\LayananTable&\Cake\ORM\Association\BelongsTo $Layanans
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\PembayaranTable&\Cake\ORM\Association\HasMany $Pembayaran
 *
 * @method \App\Model\Entity\Transaksi newEmptyEntity()
 * @method \App\Model\Entity\Transaksi newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Transaksi> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Transaksi get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Transaksi findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Transaksi patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Transaksi> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Transaksi|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Transaksi saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Transaksi>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Transaksi>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Transaksi>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Transaksi> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Transaksi>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Transaksi>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Transaksi>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Transaksi> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TransaksiTable extends Table
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

        $this->setTable('transaksi');
        $this->setDisplayField('nomor_nota');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Pelanggans', [
            'foreignKey' => 'pelanggan_id',
            'className' => 'Pelanggan',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Layanans', [
            'foreignKey' => 'layanan_id',
            'className' => 'Layanan',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Pembayaran', [
            'foreignKey' => 'transaksi_id',
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
            ->scalar('nomor_nota')
            ->maxLength('nomor_nota', 20)
            ->requirePresence('nomor_nota', 'create')
            ->notEmptyString('nomor_nota')
            ->add('nomor_nota', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->integer('pelanggan_id')
            ->notEmptyString('pelanggan_id');

        $validator
            ->integer('layanan_id')
            ->notEmptyString('layanan_id');

        $validator
            ->integer('user_id')
            ->allowEmptyString('user_id');

        $validator
            ->dateTime('tanggal_masuk')
            ->requirePresence('tanggal_masuk', 'create')
            ->notEmptyDateTime('tanggal_masuk');

        $validator
            ->dateTime('tanggal_selesai')
            ->allowEmptyDateTime('tanggal_selesai');

        $validator
            ->decimal('berat')
            ->requirePresence('berat', 'create')
            ->notEmptyString('berat');

        $validator
            ->integer('subtotal')
            ->requirePresence('subtotal', 'create')
            ->notEmptyString('subtotal');

        $validator
            ->integer('diskon')
            ->notEmptyString('diskon');

        $validator
            ->integer('total_harga')
            ->requirePresence('total_harga', 'create')
            ->notEmptyString('total_harga');

        $validator
            ->scalar('status_laundry')
            ->maxLength('status_laundry', 20)
            ->notEmptyString('status_laundry');

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
        $rules->add($rules->isUnique(['nomor_nota']), ['errorField' => 'nomor_nota']);
        $rules->add($rules->existsIn(['pelanggan_id'], 'Pelanggans'), ['errorField' => 'pelanggan_id']);
        $rules->add($rules->existsIn(['layanan_id'], 'Layanans'), ['errorField' => 'layanan_id']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
