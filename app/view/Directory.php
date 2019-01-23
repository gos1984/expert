<?php
namespace app\view;
use core\View;

class Directory extends View{
	public function output($action, $data = null) {
		require_once ROOT."/app/template/head.php";
		
		if(file_exists(ROOT."/app/view/directory/$action.php")) {
			require_once ROOT."/app/view/directory/$action.php";
		}
		require_once ROOT."/app/template/footer.php";
	}

}
?>