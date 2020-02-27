<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Cache\Cache;
use Cake\Utility\Inflector;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */

    public $userData = [];
    public $userId = "";
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Datatables');
        $this->loadComponent('Utilities');
        $this->loadComponent('Redis');
        $this->loadComponent('Cookie');
        $this->loadModel('AppSettings');
        $defaultAppSettings = $this->Redis->readCacheAppSettings();
        $this->set(compact('defaultAppSettings'));
        $this->loadComponent('Acl',[
            'className' => 'Acl.Acl'
        ]);
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => ['username' => 'username', 'password' => 'password'],
                    'finder' => 'auth'
                ]
                ],
            'authorize' => [
                'App.Custom' => ['actionPath'=>'controllers/']
            ],
            'loginAction' => [
                'controller' => 'Pages',
                'action' => 'index'
            ],
            'loginRedirect' => [
                'controller' => 'Pages',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Pages',
                'action' => 'index'
            ],
            'unauthorizedRedirect' => [
                'controller' => 'Errors',
                'action' => 'unauthorized',
            ],
            'authError' => 'You are not authorized to access that location.',
            'flash' => [
                'element' => 'error'
            ]
        ]);
        if($this->Auth->user()){
            $this->loadModel('Users');
            $userData = $this->Auth->user();
            if(empty($userData)){
                $userData = [];
                $userId = "";
                $this->userData = [];
                $this->userId = "";
            }else{
                $userData = $this->Redis->readCacheUserAuth($userData);
                $userId = $userData->id;
                $this->userData = $userData;
                $this->userId = $userId;
                $sidebarList = $this->Redis->readCacheSideNav($userData);
            }
            
            $this->set(compact('userData','userId','sidebarList'));
        }
        
        

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        $this->loadComponent('Security');
        // $this->loadComponent('Csrf');
    }
    

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->loadModel('Users');
        $cokie = $this->Cookie->read('remember_me_cookie');
        if(!empty($cokie) && empty($this->Auth->user())){
            $username = $cokie['username'];
            $password = $cokie['password'];
            $remember = $cokie['remember'];
            $checkUser  = $this->Users->find('all',[
                'contain' => [
                    'UserGroups','UserGroups.Aros'
                ],
                'conditions' => [
                    'username' => $username,
                    'Users.status' => 1
                ]
            ])->first();
            $hasher = new DefaultPasswordHasher;
            if($hasher->check($password,$checkUser->password)){
                $user = $checkUser;
                $code       = 200;
                $message    = "Selamat datang kmebali". $username; 
                $this->Auth->setUser($user);
                $this->Redis->createCacheUserAuth($user);
                if($remember){
                    $this->Cookie->write('remember_me_cookie', ['username'=>$username,'password'=>$password,'remember'=>$remember], true, '3 weeks');
                }
                $userData = $this->Redis->readCacheUserAuth($user);
                $userId = $userData->id;
                $this->userData = $userData;
                $this->userId = $userId;
                $sidebarList = $this->Redis->readCacheSideNav($userData);
                $home_url = $this->Redis->readCacheUrlHome($checkUser);
                $this->set(compact('userData','userId','sidebarList'));
            }
        }


    }
}
