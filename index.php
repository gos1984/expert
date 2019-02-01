<?php
require_once __DIR__."/config_exp.php";
require_once __DIR__."/vendor/autoload.php";

use core\Router;
use app\controller\Home;

try {
	Router::start();
} catch (Exception $e) {
	file_put_contents("logs.html", date("d.m.Y H:i:s")."<br/>{$e->getMessage()}<br/> file: {$e->getFile()}<br/>line: {$e->getLine()} <hr/><br/>", FILE_APPEND);
	echo '<div style="text-align: center; padding-top: 10%"><h1>Ну вооот... Ты меня сломал! :-(</h1><br/>'.$e->getMessage().'</div>';
}

?>