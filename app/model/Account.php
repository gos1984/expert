<?php
namespace app\model;
use core\Model;
use PDO;

class Account extends Model{
	private $user;
	public function __construct() {
		parent::__construct();
	}

	public function getAuth() {
		if(!empty($_POST)) {
			$this->user = $this->db->query("SELECT
				u.login, u.password, u.name_f, u.name_i, u.name_o, a.role_name,u.medic
				FROM user u
				INNER JOIN access a ON
				a.user_login = u.login WHERE login = '{$_POST['login']}'")->fetch(PDO::FETCH_ASSOC);

			if(!empty($this->user)) {
				if(password_verify($_POST['password'],$this->user['password'])) {
					$_SESSION = [
						'login' => $this->user['login'],
						'role' => $this->user['role_name'],
						'medic' => $this->user['medic'],
					];
					if($this->user['role_name'] == 'Администратор') {
						header("Location: /events", true, 301);
					} else {
						//header("Location: /attestation/attests", true, 301);
					}
					
					//exit();
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
}
?>