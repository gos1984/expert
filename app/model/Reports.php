<?php
namespace app\model;
use core\Model;
use core\traits\{Defense,Modality,Ssapm,Page, Sort};
use app\other\XLS;
use PDO;

class Reports extends Model{

	use Page, Defense, Sort;

	public function __construct() {
		parent::__construct();
	}

	public function getAll() {
		$sort = !empty($_GET['sort']) && !empty($_GET['order']) ? " ORDER BY {$_GET['sort']} {$_GET['order']}" : " ORDER BY login ASC";
		$u = $this->db->query("SELECT
			u.login,
			a.role_name,
			CONCAT(u.name_f,' ',u.name_i,' ',u.name_o) AS name,
			u.email,
			u.phone_private,
			u.phone_work,
			es.name AS state,
			DATE_FORMAT(e.dt_create,'%d.%m.%Y') AS dt_create,
			DATE_FORMAT(e.dt_public,'%d.%m.%Y') AS dt_public,
			(SELECT COUNT(ec.exam_id) FROM exam_check ec WHERE ec.exam_id = e.id) AS quantity,
			e.result
			FROM exam e
			INNER JOIN exam_state es ON es.id = e.state_id
			INNER JOIN access a ON a.user_login = e.login
			INNER JOIN user u ON u.login = e.login".$sort);
		while ($row = $u->fetch(PDO::FETCH_ASSOC)) {
			$reports['data'][] = $row;
		}
		$reports['page'] = $this->getPage();
		$reports['title'] = array(
				'login' => 'Логин',
				'role_name' => 'Статус',
				'name' => 'ФИО',
				'email' => 'E-mail',
				'phone_private' => 'Тел. личный',
				'phone_work' => 'Тел. рабочий',
				'state' => 'Статус теста',
				'dt_create' => 'Дата тестирования',
				'dt_public' => 'Дата публикации',
				'quantity' => 'Кол-во проверяющих',
				'result' => 'Результат',
			);
		return $reports;
	}

	public function getQuantity() {
		$r = $this->db->query("SELECT
			ec.login,
			CONCAT(u.name_f,' ',u.name_i,' ',u.name_o) AS name,
			a.role_name,
			COUNT(ec.login) AS count,
			COUNT(IF(e.level = 1, 1, NULL)) AS level1,
			COUNT(IF(e.level = 2, 2, NULL)) AS level2
			FROM exam e
			INNER JOIN exam_check ec ON ec.exam_id = e.id
			INNER JOIN access a ON a.user_login = ec.login
			INNER JOIN user u ON u.login = ec.login
			GROUP BY ec.login".$this->getSort('login'));
		while ($row = $r->fetch(PDO::FETCH_ASSOC)) {
			$reports['data'][] = $row;
		}
		$reports['page'] = $this->getPage();
		$reports['title'] = array(
				'login' => 'Логин',
				'role_name' => 'Статус',
				'name' => 'ФИО',
				'count' => 'Общее кол-во',
				'level1' => 'Кол-во ур-нь эксперт',
				'level2' => 'Кол-во ур-нь эксперт-конс.',
			);
		return $reports;
	}

	public function getVkk() {
		$reports['page'] = $this->getPage();
		$reports['title'] = array(
				'login' => 'Логин',
				'role_name' => 'Статус',
				'name' => 'ФИО',
				'email' => 'E-mail',
				'phone_private' => 'Тел. личный',
				'phone_work' => 'Тел. рабочий',
				'state' => 'Статус теста',
				'dt_create' => 'Дата тестирования',
				'dt_public' => 'Дата публикации',
				'quantity' => 'Кол-во проверяющих',
				'result' => 'Результат',
			);
		return $reports;
	}

	public function getExperts() {
		$r = $this->db->query("SELECT
			CONCAT(u.name_f,' ',u.name_i,' ',u.name_o) AS name,
			(SELECT IF(e.level = 2,salary_level2,salary_level1) FROM setup) AS summ,
			ec.exam_id,
			e.attest_id,
			e.level,
			DATE_FORMAT(ec.dt_check,'%d.%m.%Y') AS dt_check,
			DATE_FORMAT(e.dt_public,'%d.%m.%Y') AS dt_public
			FROM exam_check ec
			INNER JOIN exam e ON e.id = ec.exam_id
			INNER JOIN user u ON u.login = ec.login".$this->getSort('name_f'));
		while ($row = $r->fetch(PDO::FETCH_ASSOC)) {
			$reports['data'][] = $row;
		}
		$reports['page'] = $this->getPage();
		$reports['title'] = array(
				'name' => 'ФИО',
				'exam_id' => '№ теста',
				'attest_id' => '№ случая',
				'level' => 'Уровень теста',
				'dt_check' => 'Дата проверки',
				'dt_public' => 'Дата публикации',
				'summ' => 'Сумма(в руб.)',
			);
		return $reports;
	}

	public function getStudents() {
		$sort = !empty($_GET['sort']) && !empty($_GET['order']) ? " ORDER BY {$_GET['sort']} {$_GET['order']}" : " ORDER BY login ASC";
		$r = $this->db->query("SELECT
			ec.login,
			CONCAT(u.name_f,' ',u.name_i,' ',u.name_o) AS name,
			a.role_name,
			COUNT(ec.login) AS count,
			COUNT(IF(e.level = 1, 1, NULL)) AS level1,
			COUNT(IF(e.level = 2, 2, NULL)) AS level2
			FROM exam e
			INNER JOIN exam_check ec ON ec.exam_id = e.id
			INNER JOIN access a ON a.user_login = ec.login
			INNER JOIN user u ON u.login = ec.login
			GROUP BY ec.login".$sort);
		while ($row = $r->fetch(PDO::FETCH_ASSOC)) {
			$reports['data'][] = $row;
		}
		$reports['page'] = $this->getPage();
		$reports['title'] = array(
				'login' => 'Логин',
				'role_name' => 'Статус',
				'name' => 'ФИО',
				'email' => 'E-mail',
				'phone_private' => 'Тел. личный',
				'phone_work' => 'Тел. рабочий',
				'state' => 'Статус теста',
				'dt_create' => 'Дата тестирования',
				'dt_public' => 'Дата публикации',
				'quantity' => 'Кол-во проверяющих',
				'result' => 'Результат',
			);
		return $reports;
	}

	public function getDetail() {
		$r = $this->db->query("SELECT
			ec.login,
			CONCAT(u.name_f,' ',u.name_i,' ',u.name_o) AS name,
			DATE_FORMAT(ec.dt_check,'%d.%m.%Y') AS dt_check,
			ec.exam_id,
			e.attest_id,
			m.name AS modality,
			s.name AS ssapm,
			(SELECT IF(e.level = 2,salary_level2,salary_level1) FROM setup) AS summ
			FROM exam_check ec
			INNER JOIN exam e ON e.id = ec.exam_id
			INNER JOIN user u ON u.login = ec.login
			INNER JOIN attest a ON a.id = e.attest_id
			INNER JOIN modality m ON m.id = a.modality_id
			INNER JOIN ssapm s ON s.id = a.ssapm_id
			".$this->getSort('login'));
		while ($row = $r->fetch(PDO::FETCH_ASSOC)) {
			$reports['data'][] = $row;
		}
		$reports['page'] = $this->getPage();
		$reports['title'] = array(
				'dt_check' => 'Дата проверки',
				'attest_id' => '№ случая',
				'exam_id' => '№ теста',
				'modality' => 'Модальность',
				'ssapm' => 'Системы стратификации и параметры измерения',
				'summ' => 'Сумма(в руб.)'
			);
		return $reports;
	}

	public function getFile($title, $data) {
		$xls = new XLS($title, $data);
		$xls->getFile();
	}
}
?>