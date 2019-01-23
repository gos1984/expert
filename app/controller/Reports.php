<?php
namespace app\controller;
use core\Controller;
use app\model\Reports as Model;
use app\view\Reports as View;

class Reports extends Controller{
	private $model;
	private $view;
	public function __construct() {
		$this->model = new Model();
		$this->view = new View();
	}

	public function index() {
		$data = $this->model->getReportsAll();
		$this->view->output("index",$data);
	}
	

	function getQuantity() {
		$data = array(
			'page' => $this->model->get_page(),
			'data' => $this->model->get_quantity(),
			'title'=> array(
				'login' => 'Логин',
				'role_name' => 'Статус',
				'name' => 'ФИО',
				'count' => 'Общее кол-во',
				'level1' => 'Кол-во ур-нь эксперт',
				'level2' => 'Кол-во ур-нь эксперт-конс.',
			),
		);
		return $data;
	}

	function getVkk() {
		$data = array(
			'page' => $this->model->get_page(),
			'data' => $this->model->get_all(),
			'title' => array(
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
			),
		);
		return $data;
	}

	function getExperts() {
		$data = array(
			'page' => $this->model->get_page(),
			'data' => $this->model->get_experts(),
			'title' => array(
				'name' => 'ФИО',
				'exam_id' => '№ теста',
				'attest_id' => '№ случая',
				'level' => 'Уровень теста',
				'dt_check' => 'Дата проверки',
				'dt_public' => 'Дата публикации',
				'summ' => 'Сумма(в руб.)',
			),
		);
		return $data;
	}

	function getStudents() {
		$data = array(
			'page' => $this->model->get_page(),
			'data' => $this->model->get_all(),
			'title' => array(
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
			),
		);
		return $data;
	}

	function getDetail() {
		$data = array(
			'page' => $this->model->get_page(),
			'data' => $this->model->get_detail(),
			'title' => array(
				'dt_check' => 'Дата проверки',
				'attest_id' => '№ случая',
				'exam_id' => '№ теста',
				'modality' => 'Модальность',
				'ssapm' => 'Системы стратификации и параметры измерения',
				'summ' => 'Сумма(в руб.)',
			),
		);
		return $data;
	}

	function getFile() {
		if(isset($_GET['file'])) {
			$method = "get_{$_GET['file']}";
			$data = $this->$method();
			$this->model->get_file($data['title'],$data['data']);
		}
	}
}
?>