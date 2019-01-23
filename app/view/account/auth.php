<section id="home">
	<form method="POST">
		<span class="h2">Войти в личный кабинет</span>
		<input type="text" name="login">
		<input type="password" name ="password">
		<span class="error"><?php echo $data; ?></span>
		<button>Войти</button>
		<a href="/registr" class="block">Регистрация</a>
		<a href="/forgot" class="block">Забыл пароль</a>
	</form>
</section>