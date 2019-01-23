<section id="home">
	<form method="POST">
		<span class="h2">Восстановление пароля</span>
		<?php if(!empty($_GET['repair']) && !empty($_GET['hash'])) {  ?>
			<?php if($_GET['hash'] == 1) { ?>
				<div class="validate">
					<label for="#password">
						<span>Пароль</span>
						<input id="password" type="password" name="password" required="" minlength="6">
					</label>

					<label for="#password_repeat">
						<span>Повторите пароль</span>
						<input id="password_repeat" type="password" name="password_repeat" required="" minlength="6">
					</label>
					<span class="error error-password"></span>
				</div>
				<button>Восстановить</button>
				<a href="/registr" class="block">Регистрация</a>
				<a href="/auth" class="block">Войти в аккаунт</a>
			<?php } ?>
		<?php } else { ?>
			<label for="#email">
				<span>E-mail</span>
				<input id="email" type="email" name="email" required="">
				<span class="error error-email"></span>
			</label>
			<button>Восстановить</button>
			<a href="/registr" class="block">Регистрация</a>
			<a href="/auth" class="block">Войти в аккаунт</a>
		<?php } ?>
	</form>
</section>
