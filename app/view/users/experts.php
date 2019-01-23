<section id="users">
	<?php if(!empty($data['experts'])) { ?>
	<div class="table grid">
		<div class="thead">
			<div class="tr">
				<?php foreach($data['title'] as $key => $val) { ?>
					<div class="th"><a href="<?php echo '/users/experts'.sortOrder($key); ?>" class="asc"><?php echo $val; ?></a></div>
				<?php } ?>
				<div class="td"><button class="reset">Сбросить</button></div>
			</div>
		</div>
			<div class="tbody">
				<?php foreach($data['experts'] as $u => $user) { ?>
					<form class="tr fast_edit expert" action="javascript:void(null);" data-href="/users/users/edit?action=create_expert">
						<div class="td"><input type="text" readonly name="attest_id" value="<?php echo $user['attest_id']; ?>"></div>
						<div class="td"><input type="text" readonly name="login" value="<?php echo $user['login']; ?>"></div>
						<div class="td"><input type="text" readonly name="fio" value="<?php echo $user['fio']; ?>"></div>
						<div class="td"><input type="text" readonly name="email" value="<?php echo $user['email']; ?>"></div>
						<div class="td"><input type="text" readonly name="phone_private" value="<?php echo $user['phone_private']; ?>"></div>
						<div class="td"><input type="text" readonly name="phone_work" value="<?php echo $user['phone_work']; ?>"></div>

						<div class="td"><input type="checkbox" name="enable" <?php echo !empty($user['enable']) ? 'checked' :'' ?>></div>
						<div class="td"><button>Сохранить</button></div>
					</form>
			</div>
			<?php } ?>
		</div>
	<?php } else { ?>
		<span class="h2 center">Кандидаты отсутствуют!</span>
	<?php } ?>	
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