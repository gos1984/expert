<section id="home">
	<form method="POST">
		<span class="h2">Введите новый пароль</span>
		<input type="password" name ="password" required="" minlength="6">
		<input type="password" name ="password_repeat" required="" minlength="6">
		<span class="error"><?php echo $data; ?></span>
		<button>Изменить</button>
		<a href="/auth" class="block">Авторизация</a>
		<a href="/registr" class="block">Регистрация</a>
	</form>
</section>