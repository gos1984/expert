<?php
namespace core\traits;
use PDO;

trait Modality {

	private $modality;

	public function getModality() {
		$m = $this->db->query("SELECT * FROM modality");
		while ($row = $m->fetch(PDO::FETCH_ASSOC)) {
			$this->modality[] = $row;
		}
		return $this->modality;
	}
}

?>