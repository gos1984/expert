<?php
namespace app\model;
use core\Model;
use core\traits\{Defense,Modality,Ssapm,Page};
use PDO;

class Events extends Model{
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

	public function getEvent($id = null) {
		$eventDB = "SELECT
			a.id,
			a.modality_id AS modality,
			a.ssapm_id AS ssapm,
			a.name,
			a.descr,
			a.image_max_count_level1,
			a.image_max_count_level2,
			a.public,
			a.price_level1_first,
			a.price_level1_next,
			a.price_level2_first,
			a.price_level2_next,
			a.active_days_level1,
			a.active_days_level2,
			av.video,
			GROUP_CONCAT(ab.attest_id_before ORDER BY ab.attest_id_before ASC) AS attest_before
			FROM attest a
			LEFT JOIN attest_before ab ON ab.attest_id = a.id
			LEFT JOIN attest_video av ON av.attest_id = a.id";
		
		if($id == null) {
			$sort = !empty($_GET['sort']) && !empty($_GET['order']) ? " ORDER BY {$_GET['sort']} {$_GET['order']}" : " ORDER BY id ASC";

			$e = $this->db->query($eventDB." GROUP BY a.id".$sort);

			while ($row = $e->fetch(PDO::FETCH_ASSOC)) {
				$event[] = $row;
			}
		} else {
			$event = $this->db->query($eventDB." WHERE a.id = $id")->fetch(PDO::FETCH_ASSOC);
		}
		return $event;
	}

	public function getEventsAll() {
		
		$data = array(
			'modality' => $this->getModality(),
			'ssapm' => $this->getSsapm(),
			'page' => $this->getPage($this->user['login'], $this->user['role']),
			'events' => $this->getEvent(),
			'title' => array(
				'id' 				=> '№ случая',
				'name' 				=> 'Наименование',
				'modality' 			=> 'Модальность',
				'ssapm' 			=> 'Системы стратификации и параметры измерения',
				'descr' 			=> 'Описание задания - что именно нужно померить',
				'attest_before' 	=> 'Список предварительных аттестаций<br/>(следует ввести ID случаев через запятую)',
				'image_max_count_level1' 	=> 'Количество картинок ур.1',
				'image_max_count_level2' 	=> 'Количество картинок ур.2'
			)
		);
		return $data;
	}
}
?>