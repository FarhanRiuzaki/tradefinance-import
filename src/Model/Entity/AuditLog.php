<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AuditLog Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime $timestamp
 * @property int $user_id
 * @property string $controller
 * @property string $_action
 * @property string $type
 * @property int $primary_key
 * @property string $source
 * @property string $parent_source
 * @property $original
 * @property $changed
 * @property $meta
 *
 * @property \App\Model\Entity\User $user
 */
class AuditLog extends Entity
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
        'timestamp' => true,
        'user_id' => true,
        'controller' => true,
        '_action' => true,
        'type' => true,
        'primary_key' => true,
        'source' => true,
        'parent_source' => true,
        'original' => true,
        'changed' => true,
        'meta' => true,
        'user' => true
    ];
}
