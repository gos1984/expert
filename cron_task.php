<?php
if(isset($_GET['expert']) && isset($_GET['org'])) {
	if($_GET['expert'] == 'medexpertradiology' && $_GET['org'] == 'npcmr') {
		require_once $_SERVER['DOCUMENT_ROOT']."/config_exp.php";
		$dbh = new PDO('mysql:host='.HOST.';dbname='.DB, USER, PASSWORD, array(
			PDO::ATTR_PERSISTENT => true
		));
		$dbh->query("SET wait_timeout=9999;");
		$dbh->exec("SET CHARACTER SET utf8");

		$updateReasult = $dbh->exec("UPDATE exam e
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

		$insertSertif = $dbh->exec("INSERT INTO sertif(exam_id, modality_id,ssapm_id, date_start, date_end, public_link)
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

		$insertExpertWork = $dbh->exec("INSERT INTO expert_work(login,attest_id,enable)
			SELECT
			e.login,
			e.attest_id,
			0
			FROM exam e WHERE e.level = 2 
			AND e.state_id = 4 
			AND e.result = 1 
			AND NOT EXISTS(SELECT attest_id FROM expert_work WHERE attest_id = e.attest_id)");


		file_put_contents("result.html", date("d.m.Y H:i:s")." update - $reasult, sertif - $insertSertif, expert_work - $insertExpertWork  <br/>", FILE_APPEND);
	}
}
?>
