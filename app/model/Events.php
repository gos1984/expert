<?php
namespace app\model;
use core\Model;
use core\traits\{Defense,Modality,Ssapm,Page,Sort,LoadFile};
use PDO;

class Events extends Model{
	use Defense, Modality, Ssapm, Page, Sort, LoadFile;
	private $selectEvents = "SELECT
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
	
	public function __construct() {
		parent::__construct();
	}

	public function getEvent($id = null) {
		
		if($id == null) {

			$e = $this->db->query($this->selectEvents." GROUP BY a.id".$this->getSort('id'));

			while ($row = $e->fetch(PDO::FETCH_ASSOC)) {
				$event[] = $row;
			}
		} else {
			$event = $this->db->query($this->selectEvents." WHERE a.id = $id")->fetch(PDO::FETCH_ASSOC);
		}
		return $event;
	}

	public function getEventsAll() {
		
		$data = array(
			'modality' => $this->getModality(),
			'ssapm' => $this->getSsapm(),
			'page' => $this->getPage(),
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

	function getShow() {
		if(!empty($_GET)) {
			switch($_GET['type']) {
				case 'json' :
				if(isset($_GET['id_event'])) {
					$event['descr'] = $this->db->query($this->selectEvents." WHERE a.id = '{$this->defenseStr($_GET['id_event'])}'")->fetch(PDO::FETCH_ASSOC);
				}
				$event['title'] = array(
					'id' => '№ теста',
					'name' => 'Наименование случая',
					'modality' => 'Модальность',
					'ssapm' => 'Системы стратификации и параметры измерения',
					//'descr' => 'Описание задания',
					'image_max_count_level1' => 'Количество картинок (шт.) ур.1',
					'image_max_count_level2' => 'Количество картинок (шт.) ур.2',
					'public' => 'Опубликовать',
					'price_level1_first' => 'Цена первой сдачи уровень 1(руб.)',
					'price_level1_next' => 'Цена пересдачи уровень 1(руб.)',
					'price_level2_first' => 'Цена первой сдачи уровень 2(руб.)',
					'price_level2_next' => 'Цена пересдачи уровень 2(руб.)',
					'active_days_level1' => 'Срок действия сертификации уровень 1 (дни)',
					'active_days_level2' => 'Срок действия сертификации уровень 2 (дни)',
					'attest_before' => 'Список предварительных аттестаций'
				);
				$event['modality'] = $this->getModality();
				$event['ssapm'] = $this->getSsapm();
				echo json_encode($event, true);
				break;
				case 'test' :
				if(isset($_GET['direct'])) {
					$direct = $this->defenseStr($_GET['direct']);
					$test = $this->db->query("SELECT id FROM attest WHERE {$direct}_id = {$this->defenseStr($_GET['id'])} LIMIT 1")->fetch(PDO::FETCH_BOUND);
					echo json_encode($test, true);
				}
				break;
			}
			
		}
	}
	function setEdit($action) {
		if(!empty($_POST)) {
			$id 				= isset($_POST['id']) ? $this->defenseStr($_POST['id']) : NULL;
			$name 				= $this->defenseSQL($_POST['name'],'NULL');
			$modality 			= $this->defenseSQL($_POST['modality'],'NULL');
			$ssapm 				= $this->defenseSQL($_POST['ssapm'],'NULL');
			$descr 				= $this->defenseDescr($_POST['descr'],'NULL');
			$attest_before 		= $this->defenseStr($_POST['attest_before']);
			$image_max_count_level1 	= $this->defenseSQL($_POST['image_max_count_level1'],'NULL');
			$image_max_count_level2 	= $this->defenseSQL($_POST['image_max_count_level2'],'NULL');
			$files = null;
			if(!empty($_GET['full'])) {
				$public 			= !empty($_POST['public']) ? 1 : 0;
				$price_level1_first = $this->defenseSQL($_POST['price_level1_first'],'NULL');
				$price_level1_next 	= $this->defenseSQL($_POST['price_level1_next'],'NULL');
				$price_level2_first = $this->defenseSQL($_POST['price_level2_first'],'NULL');
				$price_level2_next 	= $this->defenseSQL($_POST['price_level2_next'],'NULL');
				$active_days_level1 = $this->defenseSQL($_POST['active_days_level1'],'NULL');
				$active_days_level2 = $this->defenseSQL($_POST['active_days_level2'],'NULL');
			}
		}

		switch($action) {
			case 'update':
			$upd = "UPDATE attest SET 
			modality_id 		= $modality,
			ssapm_id 			= $ssapm,
			name 				= IF($name IS NULL, CONCAT((SELECT name FROM modality WHERE id = $modality), ' / ', ((SELECT name FROM ssapm WHERE id = $ssapm))), $name),
			descr 				= $descr,
			image_max_count_level1 	= $image_max_count_level1,
			image_max_count_level2 	= $image_max_count_level2";
			if(!empty($_GET['full'])) {
				$upd .= ",
				public 				= $public,
				price_level1_first 	= $price_level1_first,
				price_level1_next 	= $price_level1_next,
				price_level2_first 	= $price_level2_first,
				price_level2_next 	= $price_level2_next,
				active_days_level1 	= $active_days_level1,
				active_days_level2 	= $active_days_level2";
			}

			$update = $this->db->exec($upd." WHERE id = $id");

			$files = $this->setVideoFile($id);

			if(!empty($files)) {
				if($this->db->query("SELECT attest_id FROM attest_video WHERE attest_id = $id")->fetch(PDO::FETCH_BOUND)) {
					$update = $this->db->exec("UPDATE attest_video SET video = '$files' WHERE attest_id = $id");
				} else {
					$ins = $this->db->exec("INSERT INTO attest_video (attest_id,video) VALUES($id,'$files')");
				}
			}

			if(!empty($attest_before)) {

				$this->db->query("DELETE FROM attest_before WHERE attest_id= $id");
				$request = "INSERT INTO attest_before(attest_id,attest_id_before)
				VALUES";
				$attest_before = explode(',',$attest_before);
				for($i = 0; $i < count($attest_before); $i++) {
					if($i < count($attest_before) - 1) {
						$request .= "($id,{$attest_before[$i]}),";
					} else {
						$request .= "($id,{$attest_before[$i]});";
					}
				}
				$this->db->query($request);
			} else {
				$this->db->query("DELETE FROM attest_before WHERE attest_id= $id");
			}
			break;
			case 'add' :
			$add = $this->db->exec("INSERT INTO attest(
				modality_id,
				ssapm_id,
				name,
				descr,
				image_max_count_level1,
				image_max_count_level2,
				public,
				price_level1_first,
				price_level1_next,
				price_level2_first,
				price_level2_next,
				active_days_level1,
				active_days_level2
				) VALUES(
				$modality,
				$ssapm,
				IF($name IS NULL, CONCAT((SELECT name FROM modality WHERE id = $modality), ' / ', ((SELECT name FROM ssapm WHERE id = $ssapm))), $name),
				$descr,
				$image_max_count_level1,
				$image_max_count_level2,
				$public,
				$price_level1_first,
				$price_level1_next,
				$price_level2_first,
				$price_level2_next,
				$active_days_level1,
				$active_days_level2)");
			$id = $this->db->lastInsertId();
			$files = $this->setVideoFile($id);
			if(!empty($files)) {
				$ins = $this->db->exec("INSERT INTO attest_video (attest_id,video) VALUES($id,'$files')");
			}

			if(!empty($attest_before)) {
				var_dump($attest_before);
				$this->db->query("INSERT INTO attest_before(attest_id,attest_id_before)
					SELECT '$id',a.id FROM attest a WHERE '$attest_before' LIKE CONCAT('%',a.id,'%')");
			}
			break;
			case 'del':
			$id = (int) $this->defenseStr($_GET['id_event']);

			$exam = $this->db->query("SELECT attest_id FROM exam WHERE attest_id = $id LIMIT 1")->fetch(PDO::FETCH_BOUND);
			if(!$exam) {
				$this->db->exec("DELETE FROM attest_video WHERE attest_id = $id");
				$this->db->exec("DELETE FROM attest_before WHERE attest_id = $id");
				$this->db->exec("DELETE FROM attest WHERE id = $id");
			} else {
				echo 'error';
			}
			break;
		}
	}
}
?>