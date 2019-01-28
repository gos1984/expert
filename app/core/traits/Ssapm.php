<?php

namespace core\traits;
use PDO;

trait Ssapm {

	private $ssapm;

	function getSsapm() {
		$s = $this->db->query("SELECT * FROM ssapm");
		while ($row = $s->fetch(PDO::FETCH_ASSOC)) {
			$this->ssapm[] = $row;
		}
		return $this->ssapm;
	}
}

?>