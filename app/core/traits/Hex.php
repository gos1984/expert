<?php
namespace core\traits;

trait Hex {
	private $hex;
	public function getHex() {
		$length = rand(1,5);
		for($i=0; $i<$length; $i++) {
			$this->hex .= md5(chr(rand(33,126)));
		}
		return $this->hex;
	}
}

?>