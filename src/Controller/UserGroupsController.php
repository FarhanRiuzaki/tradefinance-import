<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;
/**
 * UserGroups Controller
 *
 * @property \App\Model\Table\UserGroupsTable $UserGroups
 *
 * @method \App\Model\Entity\Group[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UserGroupsController extends AppController
{

    private $titleModule = "User Grup";
    private $primaryModel = "UserGroups";


    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['configure']);
        $this->set([
            'titleModule' => $this->titleModule,
            'primaryModel' => $this->primaryModel,
        ]);
    }

    function beforeFilter(\Cake\Event\Event $event){
        parent::beforeFilter($event);
    
        if(isset($this->Security) && $this->request->isAjax() && ($this->action = 'index' || $this->action = 'delete')){
    
            $this->Security->config('validatePost',false);
            //$this->getEventManager()->off($this->Csrf);
    
        }
    
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        if($this->request->is('ajax')){
            $source = $this->{$this->primaryModel};
            $searchAble = [
                $this->primaryModel.'.id',
                $this->primaryModel.'.name'
            ];
            $data = [
                'source'=>$source,
                'searchAble' => $searchAble,
                'defaultField' => $this->primaryModel.'.id',
                'defaultSort' => 'desc',
                    
            ];
            $dataTable   = $this->Datatables->make($data);  
            $this->set('aaData',$dataTable['aaData']);
            $this->set('iTotalDisplayRecords',$dataTable['iTotalDisplayRecords']);
            $this->set('iTotalRecords',$dataTable['iTotalRecords']);
            $this->set('sColumns',$dataTable['sColumns']);
            $this->set('sEcho',$dataTable['sEcho']);
            $this->set('_serialize',['aaData','iTotalDisplayRecords','iTotalRecords','sColumns','sEcho']);
        }else{
            $titlesubModule = "List ".$this->titleModule;
            $breadCrumbs = [
                Router::url(['action' => 'index']) => $titlesubModule
            ];
            $this->set(compact('breadCrumbs','titlesubModule'));
        }
        
        
    }

    /**
     * View method
     *
     * @param string|null $id Group id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $record = $this->{$this->primaryModel}->get($id, [
            'contain' => ['Users','CreatedUsers']
        ]);

        $this->set('record', $record);
        $this->set('_serialize',['record']);
        $titlesubModule = "View ".$this->titleModule;
        $breadCrumbs = [
            Router::url(['action' => 'index']) => "List ".$this->titleModule,
            Router::url(['action' => 'view',$id]) => $titlesubModule
        ];
        $this->set(compact('breadCrumbs','titlesubModule'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $record = $this->{$this->primaryModel}->newEntity();
        if ($this->request->is('post')) {
            $record = $this->{$this->primaryModel}->patchEntity($record, $this->request->getData());
            if ($this->{$this->primaryModel}->save($record)) {
                $this->Flash->success(__($this->Utilities->message_alert($this->titleModule,1)));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__($this->Utilities->message_alert($this->titleModule,2)));
        }
        $this->set(compact('record'));
        $titlesubModule = "Tambah ".$this->titleModule;
        $breadCrumbs = [
            Router::url(['action' => 'index']) => "List ".$this->titleModule,
            Router::url(['action' => 'add']) => $titlesubModule
        ];
        $this->set(compact('breadCrumbs','titlesubModule'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Group id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $record = $this->{$this->primaryModel}->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $record = $this->{$this->primaryModel}->patchEntity($record, $this->request->getData());
            if ($this->{$this->primaryModel}->save($record)) {
                $this->Flash->success(__($this->Utilities->message_alert($this->titleModule,3)));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__($this->Utilities->message_alert($this->titleModule,4)));
        }
        $this->set(compact('record'));
        $titlesubModule = "Edit ".$this->titleModule;
        $breadCrumbs = [
            Router::url(['action' => 'index']) => "List ".$this->titleModule,
            Router::url(['action' => 'edit',$id]) => $titlesubModule
        ];
        $this->set(compact('breadCrumbs','titlesubModule'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Group id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $record = $this->{$this->primaryModel}->get($id);
        if ($this->{$this->primaryModel}->delete($record)) {
            $code = 200;
            $message = __($this->Utilities->message_alert($this->titleModule,5));
            $status = 'success';
        } else {
            $code = 99;
            $message = __($this->Utilities->message_alert($this->titleModule,6));
            $status = 'error';
        }
        if($this->request->is('ajax')){
            $this->set('code',$code);
            $this->set('message',$message);
            $this->set('_serialize',['code','message']);
        }else{
            $this->Flash->{$status}($message);
            return $this->redirect(['action' => 'index']);
        }
    }

    public function configure($id = null)
    {
        $record = $this->{$this->primaryModel}->get($id,['contain'=> ['Aros','Users']]);
        $users  = $record->users;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->data;
            foreach($data['aco_parent_id'] as $key => $r){
                //check parent child aco//
                $access = 'controllers/'.$key; 
                $this->Acl->deny($record,$access);
                $allow = false;
                if(!empty($data['aco_id'][$key])){
                    foreach($data['aco_id'][$key] as $skey => $rd){
                        $accesssub = $access."/".$skey;
                        if($rd == 0){
                            $this->Acl->deny($record,$accesssub);
                        }else{
                            $this->Acl->allow($record,$accesssub);
                            if($allow == false){
                                $allow = true;
                            }
                        }
                    }
                }
                
                if($allow){
                    $this->Acl->allow($record,$access);
                }
                
                $this->Redis->clearAcos(); 

            }
            $this->Flash->success(__('The group has been configured.'));
            return $this->redirect(['action' => 'index']);
        }
        $this->loadModel('Acos');
        $acoParent = $this->Acos->find('all',['conditions'=>['alias'=>'controllers']])->first();
        // dd($acoParent);
        $acos  = $this->Acos->find('all', ['conditions'=>[
            'status' => 0,
            'Acos.lft >' => $acoParent->lft,
            'Acos.rght <' => $acoParent->rght
        ]])
        ->select([
            'Acos__id' => 'Acos.id', 
            'Acos__parent_id' => 'Acos.parent_id', 
            'Acos__name' => 'Acos.name', 
            'Acos__model' => 'Acos.model', 
            'Acos__foreign_key' => 'Acos.foreign_key', 
            'Acos__alias' => 'Acos.alias', 
            'Acos__lft' => 'Acos.lft', 
            'Acos__rght' => 'Acos.rght', 
            'Acos__status' => 'Acos.status',
            'Acos__read' => 'IFNULL(`UserPermissions`.`_read`,-1)'
            ]
        )
        ->join([
            [
                'table' => 'aros_acos',
                'alias' => 'UserPermissions',
                'type' => 'LEFT',
                'conditions' => 'Acos.id = (UserPermissions.aco_id) AND UserPermissions.aro_id = '.$record->aro->id,
            ],[
                'table' => 'aros',
                'alias' => 'UserAros',
                'type' => 'LEFT',
                'conditions' => 'UserAros.id = (UserPermissions.aro_id) AND UserAros.model = "UserGroups" AND UserAros.foreign_key = '.$id,
            ]
        ])
        ->group('Acos__id')
        ->order('Acos.sort ASC')
        ->find('threaded');
        $this->set(compact('record','acos'));
        $titlesubModule = "Configure ".$this->titleModule;
        $breadCrumbs = [
            Router::url(['action' => 'index']) => "List ".$this->titleModule,
            Router::url(['action' => 'configure',$id]) => $titlesubModule
        ];
        $this->set(compact('breadCrumbs','titlesubModule'));
    }
}
