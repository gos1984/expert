<?php
require_once __DIR__."/config_exp.php";
require_once __DIR__."/vendor/autoload.php";

use core\Router;
use app\controller\Home;
try {
	Router::start();
} catch(Exception $e) {
	var_dump(111);
}

?>