<?php
namespace core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer {
	private $mail;
	public function __construct() {
		$this->mail = new PHPMailer();
		$this->mail->isSMTP(true);
		$this->mail->Host = 'smtp.yandex.ru';
		$this->mail->SMTPAuth = true;
		$this->mail->Username = 'npcmr-webinar@yandex.ru';
		$this->mail->Password = 'hflbjkjubzvjcrds';
		$this->mail->SMTPSecure = 'ssl';                           
		$this->mail->Port = 465;
	}

	public function __destruct() {
		$this->mail->send();
	}
	

	public function sendConfirm($login,$email,$hex) {

		$this->mail->setFrom('npcmr-webinar@yandex.ru', 'МедЭксперт');
		$this->mail->CharSet = "utf-8";
		$this->mail->addAddress($email);
		$this->mail->isHTML(true);
		$this->mail->Subject = "Активация учётной записи";
		$this->mail->Body    = "<p>Добрый день,</p>
		<p>Данное письмо подтверждает вашу регистрацию.</p>
		<p>Для активации учётной записи пройдите пожалуйста по ссылке <a href=\"http://{$_SERVER['HTTP_HOST']}/confirm?login=$login&email=$email&hex=$hex\" target=\"_blank\">Активация аккаунта</a></p>
		<p>С уважением,<br/>
		Команда МедЭксперт<br/>
		<a href=\"http://www.attested.npcmr.ru\" target=\"_blank\">medexpert.ru</a></p>";
	}

	public function sendForgot($login,$email) {
		$this->mail->setFrom('npcmr-webinar@yandex.ru', 'МедЭксперт');
		$this->mail->CharSet = "utf-8";
		$this->mail->addAddress($email);
		$this->mail->isHTML(true);
		$this->mail->Subject = "Смена пароля";
		$this->mail->Body    = "<p>Добрый день,</p>
		<p>Для смены пароля пройдите по <a href=\"http://{$_SERVER['HTTP_HOST']}/password?login=$login&email=$email\" target=\"_blank\">ссылке</a></p>
		<p>С уважением,<br/>
		Команда МедЭксперт<br/>
		<a href=\"http://www.attested.npcmr.ru\" target=\"_blank\">medexpert.ru</a></p>";
	}

	public function sendCheck($theme,$email,$name) {
		$this->mail->setFrom('npcmr-webinar@yandex.ru', 'МедЭксперт');
		$this->mail->CharSet = "utf-8";
		$this->mail->addAddress($email);
		$this->mail->isHTML(true);
		$this->mail->Subject  = "Проверка вашей аттестации";
		$this->mail->Body = "Уважаемый (ая) $name,
		<p>Вашу аттестацию по теме $theme, проверил эксперт. С результатами проверки можно ознакомиться во вкладке результаты на сайте <a href=\"http://www.attested.npcmr.ru\" target=\"_blank\">medexpert.ru</a></p>
		<p>С уважением,<br/>
		Команда МедЭксперт<br/>
		<a href=\"http://www.attested.npcmr.ru\" target=\"_blank\">medexpert.ru</a></p>";
	}

	public function sendPublicAttestation($theme,$email,$name,$level,$result) {
		$this->mail->setFrom('npcmr-webinar@yandex.ru', 'Всероссийский рейтинг отделений лучевой диагностики');
		$this->mail->CharSet = "utf-8";
		$this->mail->addAddress($email);
		$this->mail->isHTML(true);
		$this->mail->Subject  = "Публикация вашей аттестации";
		$this->mail->Body = "Уважаемый (ая) $name,
		<p>Ваша аттестация по теме $theme, опубликована.</p>
		<p>С уважением,<br/>
		Команда МедЭксперт<br/>
		<a href=\"http://www.attested.npcmr.ru\" target=\"_blank\">medexpert.ru</a></p>";
	}
}
?>