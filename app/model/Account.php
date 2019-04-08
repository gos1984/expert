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
			$login = $this->defenseStr($_POST['login']);
			$user = $this->db->query("SELECT
				u.login, u.password, u.name_f, u.name_i, u.name_o, a.role_name,u.medic
				FROM user u
				INNER JOIN access a ON
				a.user_login = u.login WHERE login = '{$login}'")->fetch(PDO::FETCH_ASSOC);

			if(!empty($user)) {
				if(password_verify($_POST['password'],$user['password'])) {
					$_SESSION = Array(
						'login' => $user['login'],
						'role' => $user['role_name'],
						'medic' => $user['medic'],
					);
					$this->user  = Array(
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


    public function getShow() {
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

	public function register() {
		$data = null;
		if(!empty($_POST)) {
			$name = $this->defenseStr($_POST['name']);
			$name = preg_split('/(\s)/',$name); // Разделение по пробелам
			switch(count($name)) {
				case 1:
				array_unshift($name, '');
				array_push($name, '');
				break;
				case 2:
				array_push($name, '');
				break;
			} // Подгон под ФИО
			
			$login = $this->defenseStr($_POST['login']);
			$email = $this->defenseStr($_POST['email']);
			$phone = $this->defenseStr($_POST['phone']);
			$password = $this->defenseStr($_POST['password']);
			$password_repeat = $this->defenseStr($_POST['password_repeat']);

			$password = password_hash($this->defenseStr($_POST['password']),PASSWORD_DEFAULT);

			$add_user = $this->db->exec("INSERT INTO user(login, password, name_f, name_i, name_o, dt_reg, email, phone_private) VALUES (
				'$login', '$password', '$name[0]', '$name[1]', '$name[2]', NOW(),'$email', '$phone')");
			$add_access = $this->db->exec("INSERT INTO access(user_login, role_name) VALUES ('$login','Аттестуемый')");
			if($add_user) {
				header("refresh:5;url=/");
				$data = "<span class=\"result ok\">Регистрация прошла успешно!</span>";
				return $data;
			}
		}
	}

	public function test() {
	    $x = 2;

	    $y = $x;
    }
}
?>