<section id="home">
	<form method="POST" id="registr" class="validate">
		<span class="h2">Регистрация</span>
		<label for="#name">
			<span>ФИО</span>
			<input id="name" type="text" name="name" required="">
		</label>
		<label for="#login">
			<span>Логин</span>
			<input id="login" type="text" name="login" required="">
			<span class="error error-login"></span>
		</label>
		<label for="#phone">
			<span>Телефон</span>
			<input id="phone" type="tel" name="phone" required="" maxlength="18">
		</label>
		
		<label for="#email">
			<span>E-mail</span>
			<input id="email" type="email" name="email" required="">
			<span class="error error-email"></span>
		</label>
		<label for="#password">
			<span>Пароль</span>
			<input id="password" type="password" name="password" required="" minlength="6">
		</label>

		<label for="#password_repeat">
			<span>Повторите пароль</span>
			<input id="password_repeat" type="password" name="password_repeat" required="" minlength="6">
		</label>
		<label for="conf" class="confidential">
			<input id="conf" type="checkbox" name="conf" required="">
			<span>Согласование на обработку </span><a href="#" target="_blank">персональных данных</a>
		</label>
		<span class="error"><?php echo $data; ?></span>
		<button>Зарегистрироваться</button>

		<a href="/auth" class="block">Войти в аккаунт</a>
	</form>
</section>
