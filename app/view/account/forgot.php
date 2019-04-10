<section id="home">
	<form method="POST">
		<span class="h2">Восстановление пароля</span>
		<label for="#email">
			<span>E-mail</span>
			<input id="email" type="email" name="email" required="">
			<span class="error error-email"></span>
		</label>
		<span class="error"><?php echo $data; ?></span>
		<button>Восстановить</button>
		<a href="/registr" class="block">Регистрация</a>
		<a href="/auth" class="block">Войти в аккаунт</a>
	</form>
</section>
