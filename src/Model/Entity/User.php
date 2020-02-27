<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string|null $name
 * @property string $email
 * @property int $user_group_id
 * @property bool $status
 * @property int|null $created_by
 * @property \Cake\I18n\FrozenTime|null $created
 * @property int|null $modified_by
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\UserGroup $user_group
 */
class User extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'username' => true,
        'password' => true,
        'name' => true,
        'email' => true,
        'user_group_id' => true,
        'status' => true,
        'created_by' => true,
        'created' => true,
        'modified_by' => true,
        'modified' => true,
        'user_group' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
}
