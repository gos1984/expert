<?php
namespace core;
use PDO;

class DB {

	private static $instance;

	private function __construct() {
		self::$instance = new PDO('mysql:host='.HOST.';dbname='.DB, USER, PASSWORD, array(
			PDO::ATTR_PERSISTENT => true
		));
		self::$instance->query("SET wait_timeout=9999;");
		self::$instance->exec("SET CHARACTER SET utf8");
	}

	public static function getInstance() {
		if(self::$instance === null) {
			new self();
		}

		return self::$instance;
	}
}

?>