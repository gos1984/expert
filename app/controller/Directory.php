<?php
namespace app\controller;
use core\Controller;
use app\model\Directory as Model;
use app\view\Directory as View;

class Directory extends Controller{
	private $model;
	private $view;
	public function __construct() {
		$this->model = new Model();
		$this->view = new View();
	}

	public function index() {
		$data = $this->model->getDirectory();
		$this->view->output("index",$data);
	}

	public function edit() {
		$this->model->setDirectory();
	}
}
?>