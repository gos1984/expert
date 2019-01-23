<?php
namespace app\controller;
use core\Controller;
use app\model\Attestation as Model;
use app\view\Attestation as View;

class Attestation extends Controller{
	private $model;
	private $view;
	public function __construct() {
		$this->model = new Model();
		$this->view = new View();
	}

	public function index() {
		$data = $this->model->getAttestsAll();
		$this->view->output("index",$data);
	}
	

	function results() {
		$data = $this->model->getResultsAll();
		$this->view->output("results",$data);
	}

	function check() {
		$data = $this->model->getCheck();
		$this->view->output("check",$data);
	}

	function show() {
		$data = $this->model->get_show();
		return $data;
	}
}
?>