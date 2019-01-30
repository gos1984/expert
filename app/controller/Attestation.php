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
		$this->model->getShow();
	}

	function edit() {
		$this->model->setAttests($_GET['action']);
	}
}


/*
Событие
UPDATE exam e
SET e.state_id = 4,
    e.result = (SELECT
        ROUND(AVG(result))
      FROM exam_check
      WHERE exam_id = e.id),
    dt_public = NOW()
WHERE DATEDIFF(NOW(), e.dt_create) > (SELECT
    days_wait_until_puplic
  FROM setup)
AND e.result IS NULL
AND e.state_id = 3
AND e.id = e.id

Триггер после события
IF OLD.level = 2 AND NOT EXISTS (SELECT login FROM expert_work WHERE login = OLD.login AND attest_id = OLD.attest_id)
    THEN INSERT INTO expert_work(login,attest_id) VALUES(OLD.login,OLD.attest_id);
  END IF;
  IF NEW.result = 1
  	THEN INSERT INTO sertif(exam_id, modality_id,ssapm_id, date_start, date_end, public_link)
	SELECT
	e.id,
	a.modality_id, 
	a.ssapm_id,
	e.dt_public,
	ADDDATE(e.dt_public,IF(e.level = 1, a.active_days_level1, a.active_days_level2)),
	u.medic
	FROM exam e
	INNER JOIN attest a ON a.id = e.attest_id
	INNER JOIN user u ON u.login = e.login
	WHERE e.id = OLD.id;
  END IF;
*/
?>