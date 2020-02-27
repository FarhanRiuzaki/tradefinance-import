<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserGroup Entity
 *
 * @property int $id
 * @property string $name
 * @property bool $status
 * @property int|null $created_by
 * @property \Cake\I18n\FrozenTime|null $created
 * @property int|null $modified_by
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\User[] $users
 */
class UserGroup extends Entity
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
        'name' => true,
        'status' => true,
        'created_by' => true,
        'created' => true,
        'modified_by' => true,
        'modified' => true,
        'users' => true
    ];

    public function parentNode() {
        return null;
    }
}
