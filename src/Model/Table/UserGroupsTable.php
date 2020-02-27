<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UserGroups Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\HasMany $Users
 *
 * @method \App\Model\Entity\UserGroup get($primaryKey, $options = [])
 * @method \App\Model\Entity\UserGroup newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\UserGroup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UserGroup|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UserGroup[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\UserGroup findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UserGroupsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('user_groups');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Users', [
            'foreignKey' => 'user_group_id'
        ]);
        $this->hasOne('Aros', [
            'foreignKey' => 'foreign_key',
            'joinType' => 'INNER',
            'conditions' => [
                'Aros.model' => 'UserGroups'
            ]
        ]);
        $this->belongsTo('CreatedUsers', [
            'foreignKey' => 'created_by',
            'className'=>'Users'
        ]);
        $this->belongsTo('ModifiedUsers', [
            'foreignKey' => 'modified_by',
            'className'=>'Users'
        ]);
        $this->addBehavior('Acl.Acl', ['requester']);
        $this->addBehavior('AuditStash.AuditLog');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        $validator
            ->integer('created_by')
            ->allowEmpty('created_by');

        $validator
            ->integer('modified_by')
            ->allowEmpty('modified_by');

        return $validator;
    }
}
