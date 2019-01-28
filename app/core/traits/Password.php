<?php
namespace core\traits;
use PDO;

trait Password {
	private $password;
	public function getPassword() {

	}

	public function setPassword($password,$passwordRepeat,$passwordOld = null) {
		$password = $this->defenseStr($password);
		$passwordRepeat = $this->defenseStr($passwordRepeat);
		$passwordOld = $this->defenseStr($passwordOld);
		if($passwordOld != null) {
			if($password == $passwordRepeat) {
				$password = password_hash($password,PASSWORD_DEFAULT);
			}
			$cond = password_verify($passwordOld,$this->db->query("SELECT password FROM user WHERE login = '{$this->user['login']}'")->fetchColumn());
			$result;
			if($cond) {
				$result = $this->db->exec("UPDATE user SET password = '{$password}' WHERE login = '{$this->user['login']}'");
			}
			
		} else {
			
		}
	}
}

?>