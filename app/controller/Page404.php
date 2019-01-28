<?php
namespace app\controller;
use core\Controller;
use app\model\Page404 as Model;
use app\view\Page404 as View;

class Page404 extends Controller {
	private $model;
	private $view;
	public function __construct() {
		parent::__construct();
		$this->model = new Model();
		$this->view = new View();
	}

	public function index() {
		$data = $this->model->getIndex();
		$this->view->output("404",$data);
	}
}
?>