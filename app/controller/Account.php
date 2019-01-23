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
		$this->view->output("index");
	}

	public function auth() {
		$this->model->getAuth();
		$this->view->output("auth");
	}

	public function registr() {
		$this->view->output("registr");
	}

	public function logout() {
		header("Location: /auth", true, 301);
		session_destroy();
		exit();
	}

	public function forgot() {
		$this->view->output("forgot");
	}

	public function show() {
		$this->view->output("show");
	}
}
?>