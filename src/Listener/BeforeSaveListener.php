<?php
namespace App\Listener;
use Cake\Event\EventListenerInterface;
use Cake\Event\Event;
use Cake\Http\ServerRequest as Request;

class BeforeSaveListener  implements EventListenerInterface
{
    

    public function implementedEvents()
    {
        return [
            'Model.beforeSave' => 'beforeSave',
        ];
    }

    public function beforeSave(\Cake\Event\Event $event, \Cake\ORM\Entity $entity, 
    \ArrayObject $options)
    {
        $session = new Request();
        $authId = $session->getSession()->read('Auth.User.id');
        $table = $event->getSubject();
        $columns = $table->getSchema()->columns();
        if(in_array('modified_by',$columns) && $entity->isNew() == false){
            // /pr($auth->user('id'));
            if(!empty($authId)){
                $entity->modified_by = $authId;
            }
        }
        if(in_array('created_by',$columns) && $entity->isNew() == true){
            // /pr($auth->user('id'));
            if(!empty($authId)){
                $entity->created_by = $authId;
            }
        }
        return true;
    }
}