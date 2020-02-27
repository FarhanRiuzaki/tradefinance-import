<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\I18n\Time;
use Cake\Auth\DefaultPasswordHasher;

class PagesController extends AppController
{
    private $primaryModel = "Users";
    private $titleModule = "User";

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        if(php_sapi_name() !== 'cli'){
            $this->Auth->allow(['index','logout','editProfile','activitiesLog','uploadMedia','register']);
        }
        $this->set([
            'primaryModel' => $this->primaryModel,
            'titleModule' => $this->titleModule
        ]);
    }

    function beforeFilter(\Cake\Event\Event $event){
        parent::beforeFilter($event);
    
        if(isset($this->Security) && $this->action = 'index' ){
            // $this->Security->config('unlockedFields',['groups']);
        }
    }


    public function index()
    {
        if(empty($this->Auth->user())){
            $this->viewBuilder()->setLayout('login');
            if ($this->request->is('post')) {
                $this->loadModel('Users');
                $username = $this->request->getData('username');
                $password = $this->request->getData('password');
                $remember = $this->request->getData('remember');
                $checkUser  = $this->Users->find('all',[
                    'contain' => [
                        'UserGroups','UserGroups.Aros'
                    ],
                    'conditions' => [
                        'username' => $username,
                        'Users.status' => 1
                    ]
                ])->first();
                $url = "";
                if(!empty($checkUser)){
                    $hasher = new DefaultPasswordHasher;
                    if($hasher->check($password,$checkUser->password)){
                        $code       = 200;
                        $message    = "Selamat datang ". $username; 
                        $url = Router::url($this->Auth->redirectUrl(),true);
                    }else{
                        $code       = 50;
                        $message    = "Kombinasi username password salah, silahkan ulangi kembali."; 
                    }
                }else{
                    $code       = 50;
                    $message    = "Username tidak ditemukan ". $username; 
                }
                $user = $checkUser;
                if ($code == 200) {
                    $this->Auth->setUser($user);
                    $this->Redis->createCacheUserAuth($user);
                    if(!empty($remember)){
                        $this->Cookie->write('remember_me_cookie', ['username'=>$username,'password'=>$password,'remember'=>$remember], true, '3 weeks');
                    }else{
                        $this->Cookie->delete('remember_me_cookie');
                    }
                    
                    if(!$this->request->is('ajax')){
                        return $this->redirect([
                            'controller'=> 'Pages',
                            'action' => 'index'
                        ]);
                    }
                } else {
                    if(!$this->request->is('ajax')){
                        $this->Flash->error(__('Username tidak ditemukan'));
                        $this->render('login');
                    }
                }
                $this->set(compact('code','message','url','user'));
                $this->set('_serialize',['code','message','user','url']);
            }else{
               $this->render('login');
            }
            
            
        }else{
            $home_url = $this->Redis->readCacheUrlHome($this->userData);
            return $this->redirect([
                'controller'=> $home_url['controller'],
                'action' => $home_url['action']
            ]);
        }
    }
    public function logout()
    { 
        
        $this->Cookie->delete('remember_me_cookie');
        if(!empty($this->userData)){
            $this->Redis->destroyCacheUrlHome($this->userData);
            $this->Redis->destroyCacheSideNav($this->userData);
            $this->Redis->destroyCacheUserAuth($this->userData);
            $this->redirect($this->Auth->logout());
        }
        $this->redirect('/');
    }
 
    public function editProfile()
    {
        $id = $this->userId;
        $user = $this->Users->get($id, [
            'contain' => [
                'UserGroups',
                'UserGroups.Aros'
            ]
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cokie = $this->Cookie->read('remember_me_cookie');
            $data = $this->request->getData();
            $user = $this->Users->patchEntity($user,$data ,[
                'validate'=>'editProfile'
            ]);
            $password = $data['password'];
            if(empty($user->password)){
                unset($user->password);
                $password = $cokie['password'];
            }
            
            if ($this->Users->save($user)) {
                unset($data['password']);
                $this->Cookie->write('remember_me_cookie', ['username' => $data['username'], 'password' => $password], true, '3 weeks');
                $this->Redis->destroyCacheUserAuth($user);
                $this->Redis->createCacheUserAuth($user);
                $this->Flash->success(__('Profile berhasil di update.'));
                $this->autoRender = false;
                return $this->redirect(['action' => 'editProfile']);
            }
            $this->Flash->error(__('Profile gagal diupdate, silahkan ulangi kembali'));
        }
        // dd($user->user_group_id);
        $userGroups = $this->{$this->primaryModel}->UserGroups->find('list', ['limit' => 200,['conditions'=>[
            'status' => 1,
            'OR' => [
                'id' => $user->user_group_id
            ]
        ]]]);
        $this->set(compact('record', 'userGroups'));
        $this->set(compact('user'));
        $titleModule = "Profile";
        $titlesubModule = "Edit ".$titleModule;
        $breadCrumbs = [
            Router::url(['action' => 'editProfile']) => $titlesubModule
        ];
        $this->set(compact('titleModule','breadCrumbs','titlesubModule'));
    }

    public function activitiesLog()
    {
        $id = $this->userId;
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        $this->request->allowMethod(['get']);
        $this->loadModel('AuditLogs');
        $auditLogs = $this->AuditLogs->find('all',[
            'contain'=>[
                'Users' => [
                    'conditions' => [
                        'user_id' => $id
                    ]
                ]
            ],
            'order'=>['AuditLogs.timestamp' => 'DESC'],
            'conditions' => [
                
            ]
                    
        ]);
        if($this->request->is('ajax')){
            $auditLogs->where('DATE(timestamp) >= DATE_SUB(NOW(), INTERVAL 10 DAY)');
        }
        $logs = [];
        foreach($auditLogs as $key => $auditLog){
            $time =new Time($auditLog->timestamp);
            $time = $time->timeAgoInWords(['accuracy' => 'day','end'=>'+7 day']);
            $logs[$key] = [
                'time' => $time,
                'description' => 'Has been '.$auditLog->type. ' '. $auditLog->source,
                'id' => $auditLog->id
            ];
        }
        $code = 200;
        $message = __('Get data activity logs');
        $status = 'success';
        $this->set('code',$code);
        $this->set('message',$message);
        $this->set('auditLogs',$logs);
        $titleModule = "Activities Logs";
        $titlesubModule = "List ".$titleModule;
        $breadCrumbs = [
            Router::url(['action' => 'activitiesLogs']) => $titlesubModule
        ];
        $this->set(compact('titleModule','breadCrumbs','titlesubModule'));
        if($this->request->is('ajax')){
            $this->set('_serialize',['code','message','auditLogs']);
        }
    }

    public function uploadMedia()
    {
        $data = $this->request->data['file'];
        $uploadFolder = WWW_ROOT.'assets'.DS.'img'.DS.'media/'.$data['name'];
        $saveDir = '/assets/img/media/'.$data['name'];
        $extension  = pathinfo($data['name'], PATHINFO_EXTENSION);
        move_uploaded_file($data['tmp_name'],$uploadFolder);
        $url = Router::url($saveDir,true);
        $this->set('url',$url);
        $this->set('_serialize',['url']);
    }

}