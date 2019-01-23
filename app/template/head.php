<?php
// Позже убрать
function in_array_multy($haystack,$array) {
	foreach ($array as $key => $val) {
		if(in_array($haystack, $val)) {
			return true;
		}
	}
	return false;
}
function sortOrder($sort) {
	$order = !empty($_GET['order']) && $_GET['order'] == 'asc' ? 'desc' : 'asc';
	return '?sort='.$sort.'&order='.(!empty($_GET['sort']) && $_GET['sort'] == $sort ? $order : 'asc');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<base href="/">
	<link rel="stylesheet" href="/app/template/style.css"/>
	<title>Мед. Эксперт</title>
</head>
<header id="header">
	<div class="container">
		<div class="block">
			<div class="logo">
				<a href="/"><img src="/img/logo.png" alt=""></a>
			</div>
		</div>
		<?php if(!empty($_SESSION)) { ?>
			<div class="block">
				<div class="account">
					<p><?php echo 'Ваш логин: '.$_SESSION['login']; ?></p>
					<p><?php echo 'Ваш уровень: '.$_SESSION['role']; ?></p>
				</div>
			</div>
			<div class="block">
				<div class="exit right">
					<a href="/personal" class="button">Личный кабинет</a>
					<a href="/logout" class="button">Выход</a>
				</div>
			</div>
		<? } ?>
	</div>
</header>
<?php if(isset($data['page'])) { ?>
	<nav class="main-menu">
		<ul>
			<?php foreach($data['page'] as $page) {
				?>
				<li><a href="<?php echo $page['href']; ?>"><?php echo $page['page']; ?></a></li>
			<?php } ?>
		</ul>
	</nav>
	<?php } ?>