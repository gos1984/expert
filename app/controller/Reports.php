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
		$data = $this->model->getAll();
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
		$method = "get".ucfirst($_GET['file']);
		if(method_exists($this->model, $method)) {
			
			$data = $this->model->$method();
			$this->model->getFile($data['title'],$data['data']);
		}
	}
}
?>