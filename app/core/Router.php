<?php
namespace core;
use app\controller;

class Router{
	private static $routes;

	private static function getURL() {
		self::$routes = include(ROOT."/routes.php");
		$url = trim(URL,"/");
		return $url;
	}

	public static function start() {
		$url = self::getURL();
		$quan = 0;
		foreach (self::$routes as $pattern => $path) {
			$route = preg_match("~$pattern~", $url);
			if($route != 0) {
				$urlStructure = explode("/",$path);
				$className = "app\controller\\".ucfirst(array_shift($urlStructure));
				$classController = new $className();
				$action = array_shift($urlStructure);
				
				try{
					$result = call_user_func_array(array($classController, $action), $urlStructure);

				} catch(Exception $e) {
					echo $e;
					
				}
				if($result != null) {
					break;
				}
				$quan++;
			}
		}

		if($quan === 0) {
			$classController = new controller\Page404();
			$classController->index();
		}
	}
}

?>