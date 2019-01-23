<?php //print_r($data); ?>
<section id="personal">
	<div class="main">
		<nav class="sidebar">
			<ul>
				<li><a href="/personal/info">Личная информация</a></li>
				<li><a href="/personal/docs">Копии документов</a></li>
				<li><a href="/personal/password">Смена пароля</a></li>
				<li><a href="/personal/sertification">Сертификаты</a></li>
			</ul>
		</nav>
		<div class="content">
			<h1>Личный кабинет</h1>
			<div class="container">
				<form id="password_update" action="javascript:void(null);" data-href="/personal/password/edit?action=password">
					<input type="hidden" name="login" value="<?php echo $_SESSION['login']; ?>">
					<label for="old_password">
						<span>Старый пароль</span>
						<input id="old_password" type="password" name="old_password" required="">
					</label>
					<label for="new_password">
						<span>Новый пароль</span>
						<input id="new_password" type="password" pattern="\w{6,}" name="new_password" required="">
					</label>
					<label for="repeat_password">
						<span>Повторить новый пароль</span>
						<input id="repeat_password" type="password" pattern="\w{6,}" name="repeat_password" required="">
					</label>
					<button type="submit">Изменить пароль</button>
					<span class="error"></span>
				</form>
			</div>
		</div>
	</div>
</section>



