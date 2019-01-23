<?php

namespace core\traits;
use PDO;

trait Level {

	private $level;

	public function getLevel() {
		$l = $this->db->query("SELECT * FROM level");
		while ($row = $l->fetch(PDO::FETCH_ASSOC)) {
			$level[$row['id']] = $row['name'];
		}
		return $this->level;
	}
}

?>