<?php
namespace app\controller;
use core\Controller;
use app\model\Account as Model;
use app\view\Account as View;

class Account extends Controller{
	private $model;
	private $view;
	public function __construct() {
		$this->model = new Model();
		$this->view = new View();
	}

	public function index() {
		$this->model->getUser();
		$this->view->output("index");
	}

	public function auth() {
		$this->model->getUser();
		$data = $this->model->getAuth();
		$this->view->output("auth",$data);
	}

	public function registr() {
		$this->model->getUser();
		$data = $this->model->register();
		$this->view->output("registr",$data);
	}

	public function logout() {
		header("Location: /auth", true, 301);
		session_destroy();
		exit();
	}

	public function forgot() {
		$this->model->getUser();
		$this->view->output("forgot");
	}

	public function show() {
		$this->model->getShow();
	}
}
?>