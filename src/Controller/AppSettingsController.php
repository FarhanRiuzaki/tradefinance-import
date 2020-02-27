<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;

/**
 * AppSettings Controller
 *
 * @property \App\Model\Table\AppSettingsTable $AppSettings
 *
 * @method \App\Model\Entity\AppSetting[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AppSettingsController extends AppController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Imagine');
    }
    function beforeFilter(\Cake\Event\Event $event){
        parent::beforeFilter($event);
    
        if(isset($this->Security)  && ($this->action = 'index' || $this->action = 'delete')){
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
        $appSettings = $this->AppSettings->find('all',[
            'conditions' => [
                'status' => 0
            ]
        ]);
        $settings = [];
        foreach($appSettings as $key => $r){
            $settings += [str_replace(".","_",$r->keyField) => $r];
        }

        $appSettings = $settings;
        $dataSave = $this->AppSettings->newEntity();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->data;
            $dataSave = $this->AppSettings->patchEntity($dataSave,$data);
            if(empty($dataSave->errors())){
                foreach($data as $w => $d){
                    $id = $appSettings[$w]['id'];
                    $dataOriginal = $this->AppSettings->get($id);
                    $valueSave = "";
                    if($w == 'App_Logo'){
                        $source = $d['tmp_name'];
                        if(!empty($source)){
                            $uploadFolder = WWW_ROOT.DS.'img'.DS.'logo';
                            $saveDir = '/webroot/img/logo';
                            $extension  = pathinfo($d['name'], PATHINFO_EXTENSION);
                            $tmp        = $uploadFolder.'.'. $extension;
                            $saveDir    = $saveDir.'.'.$extension;
                            $width  = 100;
                            $height = 80;
                            $this->Imagine->gdImageSave($source, $tmp,['width'=>$width,'height'=>$height]);
                            $valueSave = $saveDir;
                        }
                    }elseif($w == 'App_Logo_Login'){
                        $source = $d['tmp_name'];
                        if(!empty($source)){
                            $uploadFolder = WWW_ROOT.DS.'img'.DS.'logo_login';
                            $saveDir = '/webroot/img/logo_login';
                            $extension  = pathinfo($d['name'], PATHINFO_EXTENSION);
                            $tmp        = $uploadFolder.'.'. $extension;
                            $saveDir    = $saveDir.'.'.$extension;
                            $width  = 180;
                            $height = 180;
                            $this->Imagine->gdImageSave($source, $tmp,['width'=>$width,'height'=>$height]);
                            $valueSave = $saveDir;
                        }
                    }elseif($w == 'App_Favico'){
                        $source = $d['tmp_name'];
                        if(!empty($source)){
                            $uploadFolder = WWW_ROOT.DS.'img'.DS.'favico';
                            $saveDir = '/webroot/img/favico';
                            $extension  = pathinfo($d['name'], PATHINFO_EXTENSION);
                            $tmp        = $uploadFolder.'.'. $extension;
                            $saveDir    = $saveDir.'.'.$extension;
                            $width  = 30;
                            $height = 30;
                            $this->Imagine->gdImageCropAndSave($source, $tmp,['width'=>$width,'height'=>$height]);
                            $valueSave = $saveDir;
                        }
                    }else{
                        $valueSave = $d;
                    }
                    if(!empty($valueSave)){
                        $dataUpdate['id'] = $id;
                        $dataUpdate['valueField'] = $valueSave;
                        $this->AppSettings->save($this->AppSettings->patchEntity($dataOriginal,$dataUpdate,['validate'=>false]));
                    }
                }
                $this->Redis->destroyCacheAppSettings();
                $this->Flash->success(__('The app setting has be saved.'));
                $this->redirect(['action'=>'index']);
            }else{
                $this->Flash->error(__('The app setting could not be saved. Please, try again.'));
            }
            
        }
        $titleModule = "App Settings";
        $titlesubModule = "Edit ".$titleModule;
        $breadCrumbs = [
            Router::url(['action' => 'index']) => "Edit ".$titleModule,
        ];
        $this->set(compact('titleModule','breadCrumbs','titlesubModule','appSettings','dataSave'));
    }

}
