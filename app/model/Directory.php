<?php
namespace app\model;
use core\Model;
use core\traits\{Defense,Modality,Ssapm,Page};
use PDO;

class Directory extends Model{
	use Defense, Modality, Ssapm, Page;

	public function __construct() {
		parent::__construct();
	} 
	function getDirectory() {
		$directory = [
			'page'		=> $this->getPage(),
			'modality'	=> $this->getModality(),
			'ssapm'		=>$this->getSsapm()
		];
		return $directory;
	}

	function setDirectory() {
		$direct = $this->defenseStr(key($_POST));
		foreach ($_POST as $dir) {

			if(!empty($dir['edit'])) {
				foreach ($dir['edit'] as $k => $val) {
					$name = $this->defenseSQL($val,'NUll');
					$upd = $this->db->exec("UPDATE $direct SET name = $name WHERE id = $k");
				}
			}

			if(!empty($dir['new'])) {
				foreach ($dir['new'] as $k => $val) {
					$name = $this->defenseSQL($val,'NUll');
					$ins = $this->db->exec("INSERT INTO $direct(name) VALUES ($name)");
				}
			}

			if(!empty($dir['del'])) {
				foreach ($dir['del'] as $k => $val) {
					$name = $this->defenseSQL($val,'NUll');
					$del = $this->db->exec("DELETE FROM $direct WHERE id = $k");
				}
			}
		}
	}
}

?>