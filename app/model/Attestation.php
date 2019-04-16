<?php
namespace app\model;
use core\{Model, Mailer};
use core\traits\{Defense,Modality,Ssapm,Page, Sort};
use PDO;

class Attestation extends Model{
	use Defense, Modality, Ssapm, Page, Sort;
	private $mail;

	public function __construct() {
		parent::__construct();
		$this->mail = new Mailer();
	}

	public function getAttestsAll() {
		$a = $this->db->query("SELECT
			1 AS level,
			a.id AS attest_id,
			m.name AS modality,
			s.name AS ssapm,
			a.name,
			a.descr,
			a.image_max_count_level1 AS image_max_count,
			a.public,
			IF(tf.id IS NULL, a.price_level1_first, a.price_level1_next) AS price,
			a.active_days_level1 AS active_days
			FROM attest a
			INNER JOIN modality m ON m.id = a.modality_id
			INNER JOIN ssapm s ON s.id = a.ssapm_id
			INNER JOIN
			(
 # Доступные, пользователю случаи, с учётом случаев, которые открыаются только после сдачи других случаев
			SELECT a.id,
			COUNT(DISTINCT ab.attest_id_before) c1,
			COUNT(DISTINCT e.attest_id) AS c2
			FROM attest a
			LEFT JOIN attest_before ab ON a.id = ab.attest_id
			LEFT JOIN exam e ON e.attest_id = ab.attest_id_before 
			AND e.login = '{$this->user['login']}'
			AND e.level = 1
			AND e.result = 1
			AND e.state_id = 4
			WHERE a.public = 1
			GROUP BY a.id
			HAVING c1 = c2
			) t1 ON t1.id = a.id
			LEFT JOIN
			(
 # Случаи этого уровня, которые пользователь уже 1 раз оплачивал, чтобы потом понять какую из цен показывать
			SELECT DISTINCT a.id
			FROM attest a
			JOIN exam e ON e.attest_id = a.id
			AND e.login = '{$this->user['login']}'
			AND e.level = 1
			) tf ON tf.id = a.id

			UNION ALL

			SELECT
			2 AS level,
			a.id AS attest_id,
			m.name AS modality,
			s.name AS ssapm,
			a.name,
			a.descr,
			a.image_max_count_level2 AS image_max_count,
			a.public,
			IF(tf.id IS NULL, a.price_level2_first, a.price_level2_next) AS price,
			a.active_days_level2 AS active_days
			FROM attest a
			INNER JOIN modality m ON m.id = a.modality_id
			INNER JOIN ssapm s ON s.id = a.ssapm_id
			INNER JOIN
			(
 # Доступные, пользователю случаи, с учётом случаев, которые открыаются только после сдачи других случаев
			SELECT a.id,
			COUNT(DISTINCT ab.attest_id_before) c1,
			COUNT(DISTINCT e.attest_id) AS c2
			FROM attest a
			LEFT JOIN attest_before ab ON a.id = ab.attest_id
			LEFT JOIN exam e ON e.attest_id = ab.attest_id_before 
			AND e.login = '{$this->user['login']}'
			AND e.level = 2
			AND e.result = 1
			AND e.state_id = 4
			GROUP BY a.id
			HAVING c1 = c2
			) t1 ON t1.id = a.id
			INNER JOIN
			(
 # ID случаев, успешно-пройденных и опубликованных тестов, срок сертификации которых ещё не исчерпан.
			SELECT DISTINCT a.id
			FROM attest a
			INNER JOIN exam e ON a.id = e.attest_id
			WHERE e.login = '{$this->user['login']}'
			AND e.level = 1
			AND e.result = 1
			AND e.state_id = 4
			AND DATEDIFF(NOW(), e.dt_public) < a.active_days_level1
			) t2 ON t2.id = a.id 
			LEFT JOIN
			(
 # Случаи этого уровня, которые пользователь уже 1 раз оплачивал, чтобы потом понять какую из цен показывать
			SELECT DISTINCT a.id
			FROM attest a
			JOIN exam e ON e.attest_id = a.id
			AND e.login = '{$this->user['login']}'
			AND e.level = 2
		) tf ON tf.id = a.id WHERE a.public = 1".$this->getSort('attest_id'));
		while ($row = $a->fetch(PDO::FETCH_ASSOC)) {
			$attests['attest'][] = $row;
		}

		$attests['page'] = $this->getPage($this->user['login'], $this->user['role']);
		$attests['title'] = array(
			'attest_id' 		=> '№ теста',
			'name'				=> 'Тема',
			'modality'			=> 'Модальность',
			'ssapm'				=> 'Системы стратификации и параметры измерения',
			'image_max_count' 	=> 'Количество картинок',
			'level' 			=> 'Уровень',
			'price' 			=> 'Цена',
			'active_days' 		=> 'Срок действия сертификации (в днях)'
		);
		return $attests;
	}

	public function getAttest($id,$level) {

		$attest = $this->db->query("SELECT 
			a.id,
			a.descr,
			a.image_max_count_level$level AS image,
			av.video
			FROM attest a
			LEFT JOIN attest_video av ON av.attest_id = a.id
			WHERE a.id = $id")->fetch(PDO::FETCH_ASSOC);
		return $attest;
	}

	public function getResult($id) {

		$result['descr'] = $this->db->query("SELECT
			e.id,
			e.login,
			a.name,
			e.attest_id,
			e.state_id,
			e.level,
			e.result,
			DATE_FORMAT(dt_create,'%d.%m.%Y') AS dt_create,
			DATE_FORMAT(dt_pay,'%d.%m.%Y') AS dt_pay,
			DATE_FORMAT(dt_upload,'%d.%m.%Y') AS dt_upload,
			DATE_FORMAT(dt_public,'%d.%m.%Y') AS dt_public,
			e.attested_comment,
			e.price_pay,
			e.dt_lock_until,
			av.video,
			m.name AS modality,
			s.name AS ssapm
			FROM exam e
			INNER JOIN attest a ON a.id = e.attest_id
			INNER JOIN modality m ON m.id = a.modality_id
			INNER JOIN ssapm s ON s.id = a.ssapm_id
			LEFT JOIN attest_video av ON av.attest_id = e.attest_id
			WHERE e.id = $id")->fetch(PDO::FETCH_ASSOC);
		$img = $this->db->query("SELECT
			id, 
			attested_comment, 
			exam_id, 
			image_file
			FROM exam_image WHERE exam_id = $id");
		$i = 0;
		while ($row = $img->fetch(PDO::FETCH_ASSOC)) {
			
			$result['image'][$i] = $row;
			$img_result = $this->db->query("SELECT
				result, 
				expert_comment
				FROM exam_image_result WHERE image_id = {$row['id']}");
			
			while ($row1 = $img_result->fetch(PDO::FETCH_ASSOC)) {
				$result['image'][$i]['result'][] = $row1;
			}

			$i++;
		}
		$expert_comment = $this->db->query("SELECT
			login,
			dt_check,
			result,
			expert_comment
			FROM exam_check
			WHERE exam_id = $id");
		while($row = $expert_comment->fetch(PDO::FETCH_ASSOC)) {
			$result['expert_comment'][] = $row;
		}

		$result['title'] = array(
			'attest_id' => '№ теста',
			'name' => 'Название',
			'modality' => 'Модальность',
			'ssapm' => 'Системы стратификации и параметры измерения',
			'result' => 'Общая оценка',
		);
		return $result;
	}

	public function getResultsAll() {
		$results = null;
		$r = $this->db->query("SELECT
			e.id,
			e.login,
			e.attest_id,
			e.state_id,
			s.name AS state,
			e.level,
			e.result,
			DATE_FORMAT(dt_create,'%d.%m.%Y') AS dt_create,
			DATE_FORMAT(dt_pay,'%d.%m.%Y') AS dt_pay,
			DATE_FORMAT(dt_upload,'%d.%m.%Y') AS dt_upload,
			DATE_FORMAT(dt_public,'%d.%m.%Y') AS dt_public,
			e.attested_comment,
			e.price_pay,
			e.dt_lock_until,
			DATE_FORMAT(ADDDATE(e.dt_public,IF(e.level = 1, a.active_days_level1, a.active_days_level2)), '%d.%m.%Y') AS dt_end
			FROM exam e
			INNER JOIN attest a ON a.id = e.attest_id
			INNER JOIN exam_state s ON s.id = e.state_id
			WHERE e.login = '{$this->user['login']}'".$this->getSort('id'));
		while ($row = $r->fetch(PDO::FETCH_ASSOC)) {
			if(!empty($row)) {
				$results['result'][] = $row;
			}
		}

		$results['page'] = $this->getPage($this->user['login'],$this->user['role']);
		$results['title'] = array(
			'attest_id' => '№ теста',
			'dt_create'	=> 'Дата тестирования',
			'state_id'	=> 'Статус',
			'result'	=> 'Результат',
			'dt_public' 	=> 'Дата публикации',
			'dt_end' 	=> 'Срок действия сертификации до'
		);
		return $results;
	}

	public function getCheck() {
		$c = $this->db->query("SELECT 
			e.*,
			m.name AS modality,
			s.name AS ssapm,
			a.name AS theme,
			DATE_FORMAT(e.dt_create,'%d.%m.%Y') AS dt_create,
			rand() AS random
			FROM exam e
			INNER JOIN attest a ON a.id=e.attest_id
			INNER JOIN modality m ON m.id = a.modality_id
			INNER JOIN ssapm s ON s.id = a.ssapm_id
			# Если эксперт, то делаем проверку на его присутствие в списке expert_work. Если проверка указанного случая разрешена, то выдаем проверки, иначе нет.
			# Если администратор, то выводим всех
			INNER JOIN (
			SELECT attest_id FROM expert_work WHERE login = '{$this->user['login']}' AND enable = 1 AND (SELECT role_id FROM access WHERE user_login = '{$this->user['login']}') = 3
			UNION
			SELECT attest_id FROM exam WHERE (SELECT role_id FROM access WHERE user_login = '{$this->user['login']}') = 'Администратор' GROUP BY attest_id
			) t1 ON t1.attest_id = e.attest_id
		# Проверяем присутствие данного юзера в списке проверивших раннее
			LEFT JOIN (SELECT exam_id FROM exam_check WHERE login = '{$this->user['login']}') t2 ON t2.exam_id = e.id
			WHERE ((e.state_id=2)OR(e.state_id=3))AND(DATEDIFF(NOW(), e.dt_create) <= (SELECT days_wait_until_puplic FROM setup)) AND (e.login<>'{$this->user['login']}') AND t2.exam_id IS NULL
			ORDER BY random
			LIMIT 1
			");
		while ($row = $c->fetch(PDO::FETCH_ASSOC)) {
			$check['check'][] = $row;
		}
		$check['page'] = $this->getPage($this->user['login'], $this->user['role']);
		return $check;
	}

	public function getShow() {
		if(!empty($_GET)) {
			if(isset($_GET['id_attest'])) {
				switch($_GET['type']) {
					case 'json' :
					echo json_encode($this->getAttest($_GET['id_attest'],$_GET['level']), true);
					break;
				}
			}
			if(!empty($_GET['id_result'])) {
				switch($_GET['type']) {
					case 'json' :
					echo json_encode($this->getResult($_GET['id_result']), true);
					break;
				}
			}
		}
	}

	public function setAttests($action) {
		if($action == 'testing') {
			$this->user['login'] = $this->defenseStr($_POST['login']);
			$attest_id 			= $this->defenseStr($_POST['attest_id']);
			$state_id 			= 2;
			$level 				= $this->defenseStr($_POST['level']);
			$attested_comment 	= $this->defenseSQL($_POST['attested_comment'],'NULL');

			$this->db->exec("INSERT INTO exam(
				login,
				attest_id,
				state_id,
				level,
				dt_create,
				attested_comment
				)
				VALUES (
				'{$this->user['login']}',
				$attest_id,
				$state_id,
				$level,
				NOW(),
				$attested_comment
			)");

			$exam = $this->db->lastInsertId();
			for($i = 0; $i < count($_POST['comment']); $i++) {
				if(!empty($_FILES['img']['size'][$i])) {

					if ($_FILES['img']['error'][$i] === 0) {

						if($_FILES['img']['type'][$i] == 'image/jpeg' || $_FILES['img']['type'][$i] == 'image/png') {
							preg_match('/(.\w{3})$/',$_FILES['img']['name'][$i],$type);

							$name_file = $i.$type[0];
							$dir = "/app/template/img/testing/{$this->user['login']}/$attest_id/$exam/";
							if(is_dir($_SERVER['DOCUMENT_ROOT'].$dir)) {
								$uploadfile = $_SERVER['DOCUMENT_ROOT'].$dir;
							} else {
								mkdir($_SERVER['DOCUMENT_ROOT'].$dir, 0777, true);
								$uploadfile = $_SERVER['DOCUMENT_ROOT'].$dir;
							}

							move_uploaded_file($_FILES['img']['tmp_name'][$i], $uploadfile.$name_file);
							$file = $dir.$name_file;

						}
					}
				}
				$comment = $this->defenseSQL($_POST['comment'][$i],'NULL');
				$file = $this->defenseSQL($file,'NULL');
				$this->db->exec("INSERT INTO exam_image (
					attested_comment,
					exam_id,
					image_file
					) VALUES (
					$comment,
					$exam,
					$file)");

				sleep(1);
			}
		}

		if($action == 'check') {
			$this->user['login'] = $this->defenseStr($_POST['login']);
			$user_result = $this->defenseStr($_SESSION['login']);
			$exam = $this->defenseStr($_POST['exam']);
			$level = $this->defenseStr($_POST['level']);
			$attest_id 	= $this->defenseStr($_POST['attest_id']);
			$expert_comment = $this->defenseSQL($_POST['expert_comment'],'NULL');
			$result = in_array(0, $_POST['result']) ? 0 : 1;
			$this->db->beginTransaction();

			if(!empty($_POST['result'])) {
				foreach ($_POST['result'] as $key => $val) {
					$comment = $this->defenseSQL($_POST['comment'][$key],'NULL');
					$upd = $this->db->exec("INSERT INTO exam_image_result(image_id,result, expert_comment) VALUES($key,$val,$comment)");
				}
			}

			$upd = $this->db->exec("UPDATE exam SET 
				state_id = 3
				WHERE id = $exam");

			$ins = $this->db->exec("INSERT INTO exam_check(exam_id,login,dt_check,result,expert_comment) VALUES ($exam,'$user_result',NOW(),$result,$expert_comment)");

			$user = $this->db->query("SELECT
				CONCAT(m.name,'/',s.name) AS theme,
				CONCAT(u.name_i,' ',u.name_o) AS name,
				email
				FROM exam e
				INNER JOIN user u ON u.login = e.login
				INNER JOIN attest a ON a.id = e.attest_id
				INNER JOIN modality m ON m.id = a.modality_id
				INNER JOIN ssapm s ON s.id = a.ssapm_id
				WHERE e.id = $exam")->fetch(PDO::FETCH_ASSOC);

			$this->mail->sendCheck($user['theme'],$user['email'],$user['name']);
			
			if($upd || $ins) {
				$this->db->commit();
			} else {
				$this->db->rollBack();
			}
		}
	}

	public function setPublicAttests($expert,$org) {
		if($expert == 'medexpertradiology' && $org == 'npcmr') {
			
			$updateReasult = $this->db->exec("UPDATE exam e
				SET e.state_id = 4,
				e.result = (SELECT
				ROUND(AVG(result))
				FROM exam_check
				WHERE exam_id = e.id),
				dt_public = NOW()
				WHERE DATEDIFF(NOW(), e.dt_create) > (SELECT
				days_wait_until_puplic
				FROM setup)
				AND e.result IS NULL
				AND e.state_id = 3
				AND e.id = e.id");

			$insertSertif = $this->db->exec("INSERT INTO sertif(exam_id, modality_id,ssapm_id, date_start, date_end, public_link)
				SELECT
				e.id,
				a.modality_id,
				a.ssapm_id,
				e.dt_public,
				ADDDATE(e.dt_public,IF(e.level = 1, a.active_days_level1, a.active_days_level2)),
				u.medic
				FROM exam e
				INNER JOIN attest a ON a.id = e.attest_id
				INNER JOIN user u ON u.login = e.login
				WHERE e.state_id = 4 
				AND e.result = 1 
				AND e.id 
				AND NOT EXISTS(SELECT exam_id FROM sertif WHERE exam_id = e.id)");

			$insertExpertWork = $this->db->exec("INSERT INTO expert_work(login,attest_id,purpose,enable)
				SELECT
				e.login,
				e.attest_id,
				0,
				0
				FROM exam e WHERE e.level = 2 
				AND e.state_id = 4 
				AND e.result = 1 
				AND NOT EXISTS(SELECT attest_id FROM expert_work WHERE attest_id = e.attest_id)");

			$u = $this->db->query("SELECT
				CONCAT(m.name,'/',s.name) AS theme,
				CONCAT(u.name_i,' ',u.name_o) AS name,
				u.email,
				e.level,
				e.result
				FROM exam e
				INNER JOIN user u ON u.login = e.login
				INNER JOIN attest a ON a.id = e.attest_id
				INNER JOIN modality m ON m.id = a.modality_id
				INNER JOIN ssapm s ON s.id = a.ssapm_id
				WHERE  DATEDIFF(NOW(), e.dt_public) < 1");

			while ($row = $u->fetch(PDO::FETCH_ASSOC)) {
				$this->mail->sendPublicAttestation($row['theme'],$row['email'],$row['name'],$row['level'],$row['result']);
			}

			file_put_contents(ROOT."/result.html", date("d.m.Y H:i:s")." update - $updateReasult, sertif - $insertSertif, expert_work - $insertExpertWork  <br/>", FILE_APPEND);
		}
	}
}
?>


