<?php

namespace core\traits;
use PDO;

trait Role {
	
	private $role;
	
	public function getRole() {
		$r = $this->db->query("SELECT * FROM role");
		while ($row = $r->fetch(PDO::FETCH_ASSOC)) {
			$this->role[] = $row;
		}
		return $this->role;
	}

}

?>