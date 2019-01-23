<?php
namespace core\traits;

trait Sort {
	public function getSort($idx = 'id') {
		return !empty($_GET['sort']) && !empty($_GET['order']) ? " ORDER BY {$_GET['sort']} {$_GET['order']}" : " ORDER BY $idx ASC";
	}
}
?>