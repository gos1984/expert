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
		$data = $this->model->forgot();
		$this->view->output("forgot", $data);
	}

	public function confirm() {
		$this->model->confirm();
	}

	public function entry() {
		$data = $this->model->entry();
		$this->view->output("entry",$data);
	}

	public function password() {
		$data = $this->model->password();
		$this->view->output("password",$data);
	}

	public function show() {
		$this->model->getShow();
	}
}
?>