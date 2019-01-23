<?php
namespace app\model;
use core\Model;
use core\traits\{Defense,Page};
use PDO;

class Setting extends Model{
	use Defense, Page;
	
	public function __construct() {
		parent::__construct();
	}

	function getSetting() {
		$setting = $this->db->query("SELECT 
			percent_vcc,
			salary_level1,
			salary_level2,
			days_wait_until_puplic,
			hours_for_checking
		FROM setup")->fetch(PDO::FETCH_ASSOC);
		$data = array(
			'page' => $this->getPage(),
			'setting' => $setting,
			'title' => array(
				'percent_vcc' => 'Процент вероятности отправки теста на перепроверку',
				'salary_level1' => 'Размер оплаты за проверку теста 1-го уровня',
				'salary_level2' => 'Размер оплаты за проверку теста 2-го уровня',
				'days_wait_until_puplic' => 'Количество дней до публикации результата с момента сдачи теста',
				'hours_for_checking' => 'Количество часов для проверки теста.',
			),
		);
		return $data;
	}

	function setSetting($action) {
		switch($action) {
			case 'update' :
				$key = $this->defenseStr(key($_POST));
				$val = $this->defenseStr($_POST[$key]);
				$this->db->exec("UPDATE setup SET $key = $val");
		}
	}
}
?>