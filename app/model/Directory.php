<?php
namespace app\model;
use core\Model;
use core\traits\{Defense,Modality,Ssapm,Page};
use PDO;

class Directory extends Model{
	use Defense;
	use Modality;
	use Ssapm;
	use Page;
	private $user;

	public function __construct() {
		parent::__construct();
		$this->user = array(
			'login' => 	$this->defenseStr($_SESSION['login']),
			'role' 	=>	$this->defenseStr($_SESSION['role'])
		);
	} 
	function getDirectory() {
		$directory = [
			'page'		=> $this->getPage($this->user['login'], $this->user['role']),
			'modality'	=> $this->getModality(),
			'ssapm'		=>$this->getSsapm()
		];
		return $directory;
	}

	function setDirectory($action) {
		$direct = $this->defense(key($_POST));
		foreach ($_POST as $dir) {

			if(!empty($dir['edit'])) {
				foreach ($dir['edit'] as $k => $val) {
					$name = $this->add_sql($val,'NUll');
					$upd = $this->db->exec("UPDATE $direct SET name = $name WHERE id = $k");
				}
			}

			if(!empty($dir['new'])) {
				foreach ($dir['new'] as $k => $val) {
					$name = $this->add_sql($val,'NUll');
					$ins = $this->db->exec("INSERT INTO $direct(name) VALUES ($name)");
				}
			}

			if(!empty($dir['del'])) {
				foreach ($dir['del'] as $k => $val) {
					$name = $this->add_sql($val,'NUll');
					$del = $this->db->exec("DELETE FROM $direct WHERE id = $k");
				}
			}
		}
	}
}

?>