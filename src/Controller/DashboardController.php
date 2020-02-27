<?php
namespace App\Controller;

use App\Controller\AppController;

class DashboardController extends AppController
{
    public function index()
    {
        $titleModule = "Dashboard";
        $this->set(compact('titleModule'));
    }
}