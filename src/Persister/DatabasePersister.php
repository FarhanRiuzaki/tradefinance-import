<?php
namespace App\Persister;
use AuditStash\PersisterInterface;
use Cake\ORM\TableRegistry;
use Cake\ORM\Entity;
use Cake\I18n\Time;
use Cake\Network\Request;
use Cake\Utility\Inflector;
class DatabasePersister implements PersisterInterface
{
    public function logEvents(array $auditLogs)
    {
        foreach ($auditLogs as $log) {
            $request = new Request;
            $here = $request->here;
            $explodeHere = explode("/",$here);
            $authId = $request->session()->read('Auth.User.id');
            $eventType = $log->getEventType();
            $data = [
                'timestamp' => Time::now(),
                'user_id' => $authId,
                'controller' => empty($explodeHere[2]) ? null : $explodeHere[2],
                '_action' => empty($explodeHere[3]) ? null : $explodeHere[3],
                'transaction' => $log->getTransactionId(),
                'type' => $log->getEventType(),
                'primary_key' => $log->getId(),
                'source' => $log->getSourceName(),
                'parent_source' => $log->getParentSourceName(),
                'original' => $eventType === 'delete' ? null : json_encode($log->getOriginal()),
                'changed' => $eventType === 'delete' ? null : json_encode($log->getChanged()),
                'meta' => json_encode($log->getMetaInfo())
            ];
            TableRegistry::get('audit_logs')->save(new Entity($data));
        }
    }
}