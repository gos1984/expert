<div class="block">
	<h3>Изменить пароль</h3>
	<form id="password_update" action="javascript:void(null);" data-href="/personal/edit?action=password">
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



