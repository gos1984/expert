<?php
namespace app\model;
use core\Model;
use core\traits\{Defense,Role,Page,Sort};
use PDO;

class Users extends Model{
	use Defense, Page, Role, Sort;
	private $selectUsers = "SELECT
	u.login,
	a.role_name,
	u.name_f,
	u.name_i,
	u.name_o,
	DATE_FORMAT(u.dt_reg,'%d.%m.%Y') AS dt_reg,
	u.email,
	u.phone_private,
	u.phone_work,
	DATE_FORMAT(u.birthday,'%d.%m.%Y') AS birthday,
	u.birthplace,
	u.position,
	u.education,
	u.education_add,
	u.medic,
	DATE_FORMAT(bl.dt_insert,'%d.%m.%Y') AS dt_insert
	FROM user u
	INNER JOIN access a ON a.user_login = u.login
	LEFT JOIN black_list bl ON bl.login = u.login";

	public function __construct() {
		parent::__construct();
	}

	public function getUsersAll() {
		$u = $this->db->query($this->selectUsers.$this->getSort('login'));
		while ($row = $u->fetch(PDO::FETCH_ASSOC)) {
			$user['user'][] = $row;
		}
		$user['page'] = $this->getPage();
		$user['role'] = $this->getRole();
		$user['title'] =  array(
				'login' 		=> 'Логин',
				'name_f'		=> 'ФИО',
				'role_name'		=> 'Статус',
				'email'			=> 'E-mail',
				'position' 		=> 'Должность',
				'education' 	=> 'Образование',
				'medic' 		=> 'Наличие мед. образования',
				'dt_insert' 	=> 'Черный список'
		);
		return $user;
	}

	public function getExperts() {
		$u = $this->db->query("SELECT 
			e.attest_id,
			e.login,
			CONCAT(u.name_f,' ',u.name_i,' ',u.name_o) as fio,
			u.email,
			u.phone_private,
			u.phone_work,
			e.enable 
			FROM expert_work e
			INNER JOIN user u ON e.login = u.login".$this->getSort('name_f'));
		
		while ($row = $u->fetch(PDO::FETCH_ASSOC)) {
			$user['experts'][] = $row;
		}
		$user['page'] = $this->getPage();
		$user['role'] = $this->getRole();
		$user['title'] = array(
				'name_f'		=> '№ случая',
				'login' 		=> 'Логин',
				'fio' 			=> 'ФИО',
				'email' 		=> 'E-mail',
				'phone_private' => 'Телефон личный',
				'phone_work' 	=> 'Телефон рабочий',
				'role_name'		=> 'Разрешение проверять случай',
			);
		return $user;
	}

	public function getDocuments() {
		$d = $this->db->query("SELECT
			id, 
			login_user, 
			doc_name,
			doc_file,
			DATE_FORMAT(dt_insert,'%d.%m.%Y') AS dt_insert,
			login_check,
			DATE_FORMAT(dt_check,'%d.%m.%Y') AS dt_check,
			result_check AS result,
			IF(result_check IS NOT NULL,(IF(result_check = 0,'Отклоненно','Принято')), NULL) AS result_check,
			comment_check
			FROM user_docs WHERE login_user = '{$this->defenseStr($_GET['login_user'])}'");
		$docs = null;
		while ($row = $d->fetch(PDO::FETCH_ASSOC)) {
			if(!empty($row)) {
				$docs[] = $row;
			} else {
				break;
			}
		}
		return $docs;
	}

	public function setEdit($action) {
		switch($action) {
			case 'update' :
			$login = $this->defenseSQL($_POST['login']);
			$email = $this->defenseSQL($_POST['email']);
			$medic = isset($_POST['medic']) ? 1 : 0;
			$role_name = $this->defenseSQL($_POST['role_name']);
			$this->db->exec("UPDATE user SET 
				medic = $medic, 
				email = $email
				WHERE login = $login");

			$this->db->exec("UPDATE access SET
				role_name = $role_name
				WHERE user_login = $login");
			if(!empty($_POST['result'])) {
				$login_check = $this->defenseStr($_SESSION['login']);

				foreach($_POST['result'] as $key => $val) {
					$result = $this->defenseStr($val);
					$comment = $this->defenseSQL($_POST['comment'][$key], 'NULL');

					$upd = $this->db->exec("UPDATE user_docs SET login_check = '$login_check',
						dt_check = NOW(),
						result_check = $result,
						comment_check = $comment
						WHERE id = $key");
				}
			}

			if(!empty($_POST['dt_insert'])) {
				$ins = $this->db->exec("INSERT INTO black_list (login,dt_insert) VALUES($login,NOW())");
			} else {
				$del = $this->db->exec("DELETE FROM black_list WHERE login = $login");

			}
			break;
			case 'create_expert':
				$login = $this->defenseSQL($_POST['login']);
				$attest_id = $this->defenseStr($_POST['attest_id']);
				$medic = isset($_POST['enable']) ? 1 : 0;
				$this->db->exec("UPDATE expert_work SET enable = $medic WHERE login = $login AND attest_id = $attest_id");
			break;
		}
	}

	public function getShow() {
		if(!empty($_GET)) {
			switch($_GET['type']) {
				case 'json' :
				$user['descr'] = $this->db->query($this->selectUsers." WHERE u.login = '{$this->defenseStr($_GET['login_user'])}'")->fetch(PDO::FETCH_ASSOC);
				$user['title'] = array(
					'login' => 'Логин',
					'name_f' => 'Фамилия',
					'name_i' => 'Имя',
					'name_o' => 'Отчество',
					'role_name' => 'Статус',
					'email' => 'E-mail',
					'dt_reg' => 'Дата регистрации',
					'phone_private' => 'Телефон личный',
					'phone_work' => 'Телефон рабочий',
					'birthday' => 'Дата рождения',
					'birthplace' => 'Место рождения',
					'position' => 'Должность',
					'education' => 'Образование',
					'education_add' => 'Дополнительное образование',
					'medic' => 'Наличие мед. образования',
					'dt_insert' => 'Черный список'
				);
				$user['role'] = $this->getRole();
				$user['docs'] = array(
					'title' => array(
						'doc_name'		=> 'Наименование',
						'dt_insert'		=> 'Дата добавления',
						'dt_check'		=> 'Дата проверки',
						'login_check'	=> 'Проверяющий',
						'result_check'	=> 'Результат',
						'comment_check'	=> 'Комментарий',
						'doc_file'		=> 'Документ',
					),
					'doc' => $this->getDocuments(),
				);
				echo json_encode($user, true);
				break;
			}
			
		}
	}
}
?>