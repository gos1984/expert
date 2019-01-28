<?php

namespace core\traits;

trait Defense {

	private $state;
	
	public function getState() {
		$s = $this->dbh->query("SELECT * FROM exam_state");
		while ($row = $s->fetch(PDO::FETCH_ASSOC)) {
			$this->state[] = $row;
		}
		return $this->state;
	}
	
}

?>