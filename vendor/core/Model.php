<?php
namespace core;


abstract class Model {
	protected $db;
	public function __construct() {
		$this->db = DB::getInstance();
	}
}

?>