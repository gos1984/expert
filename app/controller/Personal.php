<?php
namespace app\controller;
use core\Controller;
use app\model\Personal as Model;
use app\view\Personal as View;

class Personal extends Controller{
	private $model;
	private $view;
	public function __construct() {
		$this->model = new Model();
		$this->view = new View();
	}

	public function index() {
		$data = $this->model->getInfo();
		$this->view->output("info",$data);
	}

	function docs() {
		$data = $this->model->getDocs();
		$this->view->output("docs",$data);
	}

	function password() {
		$data = $this->model->getPassword();
		$this->view->output("password",$data);
	}

	function sertification() {
		$data = $this->model->getSertification();
		$this->view->output("sertification",$data);
	}

	function edit() {
		$this->model->setEdit($_GET['action']);
	}

	function show() {
		$this->model->getShow();
	}
}
?>