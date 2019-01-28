<?php
namespace app\model;
use core\Model;
use core\traits\Defense;
use PDO;

class Account extends Model{
	use Defense;
	public function __construct() {
		parent::__construct();
	}

	public function getAuth() {
		if(!empty($_POST)) {
			$user = $this->db->query("SELECT
				u.login, u.password, u.name_f, u.name_i, u.name_o, a.role_name,u.medic
				FROM user u
				INNER JOIN access a ON
				a.user_login = u.login WHERE login = '{$_POST['login']}'")->fetch(PDO::FETCH_ASSOC);

			if(!empty($user)) {
				if(password_verify($_POST['password'],$user['password'])) {
					$_SESSION = [
						'login' => $user['login'],
						'role' => $user['role_name'],
						'medic' => $user['medic'],
					];
					$this->user  = array(
						'login' =>  $user['login'],
						'role'  => $user['role_name']
					);
					$this->getUser();
				} else {
					$data = "Неправильный логин или пароль!";
					return $data;
				}
			} else {
				$data = "Неправильный логин или пароль!";
				return $data;
			}
		}
	}

	public function getUser() {
		if(!empty($this->user)) {
			if($this->user['role'] == 'Администратор') {
				header("Location: /events", true, 301);
			} else {
				header("Location: /attestation", true, 301);
			}
			exit();
		}
	}

	function getShow() {
		if(!empty($_GET)) {
			switch($_GET['validation']) {
				case 'login' :
				if(isset($_GET['login'])) {
					$login = $this->defenseStr($_GET['login']);
					$user = $this->db->query("SELECT login FROM user WHERE login = '{$login}'")->fetch(PDO::FETCH_BOUND);
					if($user) {
						echo 'Логин уже существует';
					}
				}
				break;
				case 'email' :
				if(isset($_GET['email'])) {
					$email = $this->defenseStr($_GET['email']);
					$user = $this->db->query("SELECT email FROM user WHERE email = '{$email}'")->fetch(PDO::FETCH_BOUND);
					if($user) {
						echo 'E-mail уже используется';
					}
				}
				break;
			}
		}
	}
}
?>