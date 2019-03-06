<?php

namespace core\traits;

trait Defense {

	function defenseStr($str) {
		return trim(stripcslashes(strip_tags($str)));
	} // защита строки (удаление строк, слэшей и пробелов с краев)

	function defenseSQL($str,$null = null) {
		return !empty($str) ? '\''.addslashes($this->defenseStr($str)).'\'' : $null;
	}//app\template\img\404.jpg
	function defenseDescr($str,$null = null) {
		return !empty($str) ? '\''.trim(str_replace("\\","/",$str)).'\'' : $null;
	}
	
}

?>