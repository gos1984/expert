<?php
namespace app\view;
use core\View;

class Page404 extends View{
	public function output($action, $data = null) {
		header("refresh:5;url=/");
		require_once ROOT."/app/template/$action.php";
	}

}
?>