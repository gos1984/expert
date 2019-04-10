<?php
namespace app\model;
use core\{Model, Mailer};
use core\traits\{Defense, Hex};
use PDO;

class Account extends Model{
	use Defense, Hex;
	private $mail;
	public function __construct() {
		parent::__construct();
		$this->mail = new Mailer();
	}

	public function getAuth() {
		if(!empty($_POST)) {

			$login = $this->defenseStr($_POST['login']);
			$user = $this->db->query("SELECT
				u.login, u.password, u.name_f, u.name_i, u.name_o, r.name AS role, u.active_hex, u.medic
				FROM user u
				INNER JOIN access a ON a.user_login = u.login
				INNER JOIN role r ON a.role_id = r.id
				WHERE login = '{$login}'")->fetch(PDO::FETCH_ASSOC);

			if(!empty($user)) {
				if(isset($user['active_hex'])) {
					$data = "Аккаунт не активирован, активируйте аккаунт и попробуйте снова!";
					return $data;
				}
				if(password_verify($_POST['password'],$user['password'])) {
					$_SESSION = Array(
						'login' => $user['login'],
						'role' => $user['role'],
						'medic' => $user['medic'],
					);
					$this->user  = Array(
						'login' =>  $user['login'],
						'role'  => $user['role']
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

			$hex = $this->getHex();

			$add_user = $this->db->exec("INSERT INTO user(login, password, name_f, name_i, name_o, dt_reg, email, phone_private, active_hex) VALUES (
				'$login', '$password', '$name[0]', '$name[1]', '$name[2]', NOW(),'$email', '$phone', '$hex')");
			$add_access = $this->db->exec("INSERT INTO access(user_login, role_id) VALUES ('$login',2)");
			
			$this->mail->sendConfirm($login, $email, $hex);
			header( "refresh:3;url=/auth" ); 
			return "Регистрация прошла успешно!<br/> К вам на почту отправлена ссылка активации аккаунта";
		}
	}

	public function confirm() {
		$login = $this->defenseStr($_GET['login']);
		$email = $this->defenseStr($_GET['email']);
		$hex = $this->defenseStr($_GET['hex']);
		$user = $this->db->query("SELECT email FROM user WHERE login = '$login' AND active_hex = '$hex'")->fetchColumn();

		if(is_bool($user)) {
			header("Location: /auth", true, 301);
			exit();
		}
		if($user == $email) {
			header("Location: /entry", true, 301);
			$this->db->exec("UPDATE user SET active_hex = NULL WHERE login = '$login'");
			$_SESSION['confirm'] = true;
			exit();
		}
	}

	public function entry() {
		if(isset($_SESSION['confirm'])) {
			return "Активация прошла успешна. Для доступа к анкете войдите в свою учётную запись.";
		}
		header("Location: /auth", true, 301);
		exit();
	}

	public function forgot() {
		if(!empty($_POST)) {
			$email = $this->defenseStr($_POST['email']);
			$user = $this->db->query("SELECT login FROM user WHERE email = '$email'")->fetchColumn();
			if(is_bool($user)) {
				return "Пользователя с таким email не существует, пройдите регистрацию.";
			} else {
				$this->mail->sendForgot($user,$email);
				header( "refresh:3;url=/auth");
				return "Ссылка на восстановление пароля отправлена вам на электронную почту.";
			}
		}
	}

	public function password() {
		if(!empty($_GET['login']) && !empty($_GET['login'])) {
			header("Location: /password", true, 301);
			$_SESSION = [
				'login' => $this->defenseStr($_GET['login']),
				'email' => $this->defenseStr($_GET['email']),
			];
		}
		
		if(!empty($_POST)) {
			$password = $this->defenseStr($_POST['password']);
			$password_repeat = $this->defenseStr($_POST['password_repeat']);
			if($password != $password_repeat) {
				return "Пароли не совпадают";
			} else {
				$password = password_hash($password, PASSWORD_DEFAULT);
				$this->db->exec("UPDATE user SET password = '$password' WHERE login = '{$_SESSION['login']}'");
				header( "refresh:3;url=/auth" ); 
				return "Пароль изменён!";
			}
		}
	}
}
?>