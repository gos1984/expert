<?php
namespace core;


abstract class Model {
	protected $db;
	protected $user;
	public function __construct() {
		$this->db = DB::getInstance();
		if(!empty($_SESSION['login']) && !empty($_SESSION['role'])) {
			$this->user = array(
				'login' => 	$_SESSION['login'],
				'role' 	=>	$_SESSION['role']
			);
		}
	}
}

?>