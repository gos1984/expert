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
		$this->view->output("all",$data);
	}
	

	function quantity() {
		$data = $this->model->getQuantity();
		$this->view->output("quantity",$data);
	}

	function vkk() {
		$data = $this->model->getVkk();
		$this->view->output("vkk",$data);
	}

	function experts() {
		$data = $this->model->getExperts();
		$this->view->output("experts",$data);
	}

	function students() {
		$data = $this->model->getStudents();
		$this->view->output("students",$data);
	}

	function detail() {
		$data = $this->model->getDetail();
		$this->view->output("detail",$data);
	}

	function file() {
		if(isset($_GET['file'])) {
			$method = "get_{$_GET['file']}";
			$data = $this->$method();
			$this->model->get_file($data['title'],$data['data']);
		}
	}
}
?>