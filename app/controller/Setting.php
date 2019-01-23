<?php
namespace app\controller;
use core\Controller;
use app\model\Setting as Model;
use app\view\Setting as View;

class Setting extends Controller{
	private $model;
	private $view;
	public function __construct() {
		$this->model = new Model();
		$this->view = new View();
	}

	public function index() {
		$data = $this->model->getSetting();
		$this->view->output("index",$data);
	}

	public function edit() {
		$this->model->setSetting($_GET['action']);
	}
}
?>