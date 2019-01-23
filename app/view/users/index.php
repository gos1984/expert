<section id="users">
	<div class="table grid">
		<div class="thead">
			<div class="tr">
				<?php foreach($data['title'] as $key => $val) { ?>
					<div class="th"><a href="<?php echo '/users'.sortOrder($key); ?>" class="asc"><?php echo $val; ?></a></div>
				<?php } ?>
				<div class="td"><button class="reset">Сбросить</button></div>
			</div>
		</div>
		<div class="tbody">
			<?php foreach($data['user'] as $u => $user) { ?>
				<form class="tr fast_edit" action="javascript:void(null);" data-href="/users/users/edit?action=update">
					<div class="td"><input type="text" readonly name="login" value="<?php echo $user['login']; ?>"></div>
					<div class="td"><textarea readonly><?php echo "{$user['name_f']} {$user['name_i']} {$user['name_o']}"; ?></textarea></div>
					<div class="td">
						<select name="role">
							<?php foreach($data['role'] as $r) { ?>
								<option value="<?php echo $r['name']; ?>" <?php echo $r['name'] == $user['role_name'] ? 'selected' : ''; ?>><?php echo $r['name']; ?></option>
							<?php } ?>	
						</select>
					</div>
					<div class="td"><input type="text" name="email" value="<?php echo $user['email']; ?>" required></div>
					<div class="td"><textarea readonly><?php echo $user['position']; ?></textarea></div>
					<div class="td"><textarea readonly><?php echo $user['education']; ?></textarea></div>
					<div class="td"><input type="checkbox" name="medic" <?php echo $user['medic'] == 1 ? 'checked' :'' ?>></div>
					<div class="td"><input type="checkbox" name="dt_insert" <?php echo !empty($user['dt_insert']) ? 'checked' :'' ?>></div>
					<div class="td"><a href="<?php echo "/users/users/show?type=json&login_user={$user['login']}"; ?>" class="button more">Подробнее</a><button>Сохранить</button></div>
				</form>
			<?php } ?>
		</div>
	</div>
</section>
<div id="popup">
	<button class="close">X</button>
	<div class="wrap_popup">
		<div id="users_verif" class="image_group">
			<form class="edit_form" action="javascript:void(null);" data-href="/users/users/edit?action=update">
				<div class="container">
					<div class="block">
						<h3>Данные пользователя</h3>
						
						<div class="block_data"></div>
						<button>Редактировать</button>
						
					</div>
					<div class="block">
						<h3>Документы об образовании</h3>
						<div class="image_docs">
						</div>
					</div>
				</div>
			</form>
			<h3 class="center">Проверенные документы</h3>
			<div class="history table">
			</div>
		</div>
	</div>
</div>