<?php
namespace app\controller;
use core\Controller;
use app\model\Users as Model;
use app\view\Users as View;

class Users extends Controller{
	private $model;
	private $view;
	public function __construct() {
		$this->model = new Model();
		$this->view = new View();
	}
	function index() {
		$data = $this->model->getUsersAll();
		$this->view->output("index",$data);
	}

	function experts() {
		$data = $this->model->getExperts();
		$this->view->output("experts",$data);
	}

	function show() {
		$data = $this->model->getShow();
	}

	function edit() {
		$this->model->setEdit($_GET['action']);
	}
}
?>