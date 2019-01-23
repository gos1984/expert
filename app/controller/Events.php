<?php
namespace app\controller;
use core\Controller;
use app\model\Events as Model;
use app\view\Events as View;

class Events extends Controller{
	private $model;
	private $view;
	public function __construct() {
		$this->model = new Model();
		$this->view = new View();
	}

	public function index() {
		$data = $this->model->getEventsAll();
		$this->view->output("index",$data);
	}

	public function show() {
		$this->model->getShow();
	}

	public function edit() {
		$this->model->setEdit($_GET['action']);
	}
}
?>