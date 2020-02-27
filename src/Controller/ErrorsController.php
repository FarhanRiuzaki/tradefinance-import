<?php
    namespace App\Controller;

    use App\Controller\AppController;

    class ErrorsController extends AppController
    {
        public function initialize()
        {
            parent::initialize();
            $this->loadComponent('RequestHandler');
            if(php_sapi_name() !== 'cli'){
                $this->Auth->allow(['unauthorized']);
            }
        }
        public function unauthorized()
        {
            $this->viewBuilder()->layout('unauthorized');
        }
    }