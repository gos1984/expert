<?php
namespace core;
use app\controller;

class Router{
	static $routes;

	private static function getURL() {
		self::$routes = include(ROOT."/routes.php");
		$url = trim(URL,"/");
		return $url;
	}

	public static function start() {
		$url = self::getURL();
		foreach (self::$routes as $pattern => $path) {
			$route = preg_match("~$pattern~", $url);
			if($route != 0) {
				$urlStructure = explode("/",$path);
				$className = "app\controller\\".ucfirst(array_shift($urlStructure));
				$classController = new $className();
				$action = array_shift($urlStructure);
				$result = call_user_func_array(array($classController, $action), $urlStructure);
				
				if($result != null) {
					break;
				}
			}
		}
	}
}

?>