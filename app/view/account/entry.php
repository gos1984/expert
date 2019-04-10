<section id="home">
	<h1><?php echo $data; ?></h1>
	<form method="POST" action="/auth">
		<span class="h2">Войти в личный кабинет</span>
		<input type="text" name="login">
		<input type="password" name ="password">
		
		<button>Войти</button>
		<a href="/registr" class="block">Регистрация</a>
		<a href="/forgot" class="block">Забыл пароль</a>
	</form>
</section>