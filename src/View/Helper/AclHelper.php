<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Acl\Controller\Component\AclComponent;
use App\Controller\Component\RedisComponent;
use Cake\Controller\ComponentRegistry;
use Cake\Utility\Inflector;
use Cake\View\View;
use Cake\Routing\Router;

class AclHelper extends Helper
{
    public $Acl;
    public function __construct(View $view, $config = []) {
		parent::__construct($view, $config);

		$component = new ComponentRegistry();
		$this->Acl = new AclComponent($component);
		$this->UtilitiesCom = new RedisComponent($component);
	}
    public function check(array $params = [])
    {
        $params += ['_base' => false];

		$url = Router::url($params);
        $params = Router::parse($url);
		$user = ['Users' => $this->request->session()->read('Auth.User')];
		return $this->UtilitiesCom->readCacheAcos($user, $this->_getPath($params),$url);
	}
	protected function _getPath(array $params, $path = '/:plugin/:prefix/:controller/:action') {
		$plugin = empty($params['plugin']) ? null : Inflector::camelize($params['plugin']) . '/';
		$prefix = empty($params['prefix']) ? null : $params['prefix'] . '/';
		$path = str_replace(
			[':controller', ':action', ':plugin/', ':prefix/'],
			[Inflector::camelize($params['controller']), $params['action'], $plugin, $prefix],
			'controllers/' . $path
		);
		$path = str_replace('//', '/', $path);
		return trim($path, '/');
	}
}