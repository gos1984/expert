<?php
namespace app\model;
use core\Model;
use core\traits\{Defense,Page,Level,Password};
use PDO;
use Mpdf\Mpdf;

class Personal extends Model{
	use Defense, Level, Page, Password;
	
	public function __construct() {
		parent::__construct();
	}

	function getInfo() {
		$data = array(
			'info' => $this->db->query("SELECT 
				u.name_f,
				u.name_i,
				u.name_o,
				u.email,
				u.phone_private,
				u.phone_work,
				u.birthday,
				u.birthplace,
				u.position,
				u.education,
				u.education_add
				FROM user u WHERE u.login = '{$this->user['login']}'")->fetch(PDO::FETCH_ASSOC),
			'page' => $this->getPage($this->user['login'], $this->user['role']),
			'title' => array(
				'name_f' => array('name' => 'Фамилия', 'type' => 'text'),
				'name_i' => array('name' => 'Имя', 'type' => 'text'),
				'name_o' => array('name' => 'Отчество', 'type' => 'text'),
				'email' => array('name' => 'E-mail', 'type' => 'email'),
				'phone_private' => array('name' => 'Телефон личный', 'type' => 'tel'),
				'phone_work' => array('name' => 'Телефон рабочий', 'type' => 'tel'),
				'birthday' => array('name' => 'Дата рождения', 'type' => 'date'),
				'birthplace' => array('name' => 'Место рождения', 'type' => 'text'),
				'position' => array('name' => 'Должность', 'type' => 'text'),
				'education' => array('name' => 'Образование', 'type' => 'text'),
				'education_add' => array('name' => 'Дополнительное образование', 'type' => 'text'),
				'medic' => array('name' => 'Наличие медицинского образования', 'type' => 'text')
			),
		);
		return $data;
	}

	function getDocs() {
		$d = $this->db->query("SELECT
			ud.id,
			ud.doc_name,
			DATE_FORMAT(ud.dt_insert,'%d.%m.%Y') AS dt_insert,
			DATE_FORMAT(ud.dt_check,'%d.%m.%Y') AS dt_check,
			ud.login_check,
			ud.result_check AS result,
			IF(ud.result_check IS NOT NULL,(IF(ud.result_check = 0,'Отклоненно','Принято')), NULL) AS result_check,
			ud.comment_check,
			ud.doc_file
			FROM user_docs ud WHERE login_user = '{$_SESSION['login']}' ORDER BY id DESC");
		while ($row = $d->fetch(PDO::FETCH_ASSOC)) {
			$docs['docs'][] = $row;
		}
		$docs['page'] = $this->getPage($this->user['login'], $this->user['role']);
		if(!empty($docs['docs'])) {
			$docs['title'] = array(
				'doc_name'      => 'Наименование',
				'dt_insert'     => 'Дата добавления',
				'dt_check'      => 'Дата проверки',     
				'login_check'   => 'Логин проверившего',
				'result_check'  => 'Результат',
				'comment_check' => 'Комментарии',
				'doc_file'		=> 'Документ',
			);
			return $docs;
		}
		$docs['docs'] = 'Загруженных документов нет';
		return $docs;
		
	}

	function getPassword() {
		$data['page'] = $this->getPage($this->user['login'], $this->user['role']);
		return $data;
	}

	function getSertification() {
		$s = $this->db->query("SELECT
			s.id,
			s.exam_id,
			s.modality_id,
			m.name AS modality,
			s.ssapm_id,
			ss.name AS ssapm,
			s.date_start,
			s.date_end,
			s.public_link,
			e.level
			FROM
			exam e
			INNER JOIN sertif s ON s.exam_id = e.id
			INNER JOIN modality m ON m.id = s.modality_id
			INNER JOIN ssapm ss ON ss.id = s.ssapm_id
			WHERE
			e.login = '{$this->user['login']}'");
		while ($row = $s->fetch(PDO::FETCH_ASSOC)) {
			$sertification['sertif'][] = $row;
		}

		$sertification['page'] = $this->getPage($this->user['login'], $this->user['role']);
		$sertification['level'] = $this->getLevel();

		return $sertification;
	}

	function getSertifCreate(int $id,$login, int $level) {
		$login = $this->defenseStr($login);
		$sertif = $this->db->query("SELECT
			s.id,
			e.login,
			CONCAT(u.name_f,' ',u.name_i,' ',u.name_o) AS name,
			ss.name AS ssapm,
			s.date_start,
			s.date_end,
			s.public_link,
			l.name AS level
			FROM
			exam e
			INNER JOIN sertif s ON s.exam_id = e.id
			INNER JOIN modality m ON m.id = s.modality_id
			INNER JOIN ssapm ss ON ss.id = s.ssapm_id
			INNER JOIN user u ON u.login = e.login
			INNER JOIN level l ON l.id = e.level
			WHERE
			e.login = '{$login}' AND e.level = $level AND s.id = $id");
		while ($row = $sertif->fetch(PDO::FETCH_ASSOC)) {
			$data = $row;
		}
		return $data;
	}



	function setEdit($action) {

		switch($action) {
			case 'info' :
			$name_f 		= 	$this->defenseSQL($_POST['name_f'], 'NULL');
			$name_i 		=	$this->defenseSQL($_POST['name_i'], 'NULL');
			$name_o 		= 	$this->defenseSQL($_POST['name_o'], 'NULL');
			$email 			= 	$this->defenseSQL($_POST['email'], 'NULL');
			$phone_private 	= 	$this->defenseSQL($_POST['phone_private'], 'NULL');
			$phone_work 	= 	$this->defenseSQL($_POST['phone_work'], 'NULL');
			$birthday 		= 	$this->defenseSQL($_POST['birthday'], 'NULL');
			$birthplace 	= 	$this->defenseSQL($_POST['birthplace'], 'NULL');
			$position 		= 	$this->defenseSQL($_POST['position'], 'NULL');
			$education 		= 	$this->defenseSQL($_POST['education'], 'NULL');
			$education_add 	= 	$this->defenseSQL($_POST['education_add'], 'NULL');
			$login 			= 	$this->defenseSQL($_POST['login'], 'NULL');

			$this->db->exec("UPDATE user SET
				name_f = $name_f,
				name_i = $name_i,
				name_o = $name_o,
				email = $email,
				phone_private = $phone_private,
				phone_work = $phone_work,
				birthday = $birthday,
				birthplace = $birthplace,
				position = $position,
				education = $education,
				education_add = $education_add
				WHERE login = $login");
			break;
			case 'password' :
			$this->setPassword($_POST['new_password'],$_POST['repeat_password'],$_POST['old_password']);
			break;
			case 'docs' :
			$login = $this->defenseStr($_SESSION['login']);
			for($i = 0; $i < count($_POST['comment']); $i++) {
				if(!empty($_FILES['img']['size'][$i])) {

					if ($_FILES['img']['error'][$i] === 0) {

						if($_FILES['img']['type'][$i] == 'image/jpeg' || $_FILES['img']['type'][$i] == 'image/png') {
							$comment = $this->defenseSQL($_POST['comment'][$i],'NULL');
							
							$this->db->exec("INSERT INTO user_docs(login_user,doc_name,dt_insert) VALUES('$login',$comment,NOW())");

							preg_match('/(.\w{3})$/',$_FILES['img']['name'][$i],$type);
							$id = $this->db->lastInsertId();
							$name_file = $id.$type[0];
							$dir = "/app/template/img/docs/$login/";
							if(is_dir($_SERVER['DOCUMENT_ROOT'].$dir)) {
								$uploadfile = $_SERVER['DOCUMENT_ROOT'].$dir;
							} else {
								mkdir($_SERVER['DOCUMENT_ROOT'].$dir, 0777, true);
								$uploadfile = $_SERVER['DOCUMENT_ROOT'].$dir;
							}

							move_uploaded_file($_FILES['img']['tmp_name'][$i], $uploadfile.$name_file);
							$file = $dir.$name_file;
							$this->db->exec("UPDATE user_docs SET doc_file = '$file' WHERE id = $id");
						}
					}
				}
			}

			break;
		}
	}


	function getShow() {
		$data = $this->getSertifCreate($_GET['id'],$_GET['login'], $_GET['level']);
		$mpdf = new Mpdf();
		$date_end = date("d.m.Y", strtotime($data['date_end']));

		$mpdf->AddPage('L');
		$mpdf->SetTitle("{$data['ssapm']} - {$data['level']}");
		$mpdf->SetSubject("{$data['ssapm']} - {$data['level']}");
		$mpdf->WriteHTML('<div style="text-align: center;"><div><img style="width: 250px" src="/app/template/img/logo.png"></div><h1 style="font-size: 40px; text-transform: uppercase">Сертификат</h1>
			<p style="font-size: 30px;">Настоящий сертификат подтверждает, что</p><h2>'.$data['name'].'</h2>
			<p style="font-size: 30px;">сдал следующий кейс:</p>
			<p style="font-size: 30px;">'.$data['ssapm'].'</p>
			<p style="font-size: 30px;">на уровень: '.$data['level'].'</p>
			</div>
			<div><p style="text-align: center">Сертификат действует до: '.$date_end.'</p></div>');
		$mpdf->Output();
	}
}
?>