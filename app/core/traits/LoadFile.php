<?php
namespace core\traits;

trait LoadFile {
	public function setVideoFile($id) {
		if(!empty($_FILES['video']['size'])) {
			if ($_FILES['video']['error'] === 0) {
				if($_FILES['video']['type'] == 'video/mp4') {

					$name_file = $id.'.mp4';
					$uploadfile = $_SERVER['DOCUMENT_ROOT'].'/app/template/video/';
					move_uploaded_file($_FILES['video']['tmp_name'], $uploadfile.$name_file);
					$files = '/app/template/video/'.$name_file;
					clearstatcache(true,$files);
					sleep(1);
					return $files;
				}
			}
		}
	}
}
?>