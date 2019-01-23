<section id="personal">
	<div class="main">
		<nav class="sidebar">
			<ul>
				<li><a href="/personal">Личная информация</a></li>
				<li><a href="/personal/docs">Копии документов</a></li>
				<li><a href="/personal/password">Смена пароля</a></li>
				<li><a href="/personal/sertification">Сертификаты</a></li>
			</ul>
		</nav>
		<div class="content">
			<h1>Личный кабинет</h1>
			<div class="container">
				<form id="personal_data" action="javascript:void(null);" data-href="/personal/info/edit?action=info">
					<?php foreach($data['info'] as $key => $val) { ?>
						<label for="<?php echo "id_$key"; ?>">
							<span><?php echo $data['title'][$key]['name']; ?></span>
							<? switch($data['title'][$key]['type']) {
								case 'tel': { ?>
									<input id="<?php echo "id_$key"; ?>" type="<?php echo $data['title'][$key]['type']; ?>" name="<?php echo $key; ?>" value="<?php echo $val; ?>" pattern="(8|\+7)(\s\(\d{3}\)\s)(\d{3}-\d{2}-\d{2})" maxlength="18">
								<?php }
								break;
								default: { ?>
									<input id="<?php echo "id_$key"; ?>" type="<?php echo $data['title'][$key]['type']; ?>" name="<?php echo $key; ?>" value="<?php echo $val; ?>">
								<?php }
								break;
							} ?>
						</label>
					<?php } ?>
					<input type="hidden" name="login" value="<?php echo $_SESSION['login']; ?>">
					<button>Обновить</button>
					<span class="error"><?php //echo $_SESSION['error']['name']; ?></span>
				</form>
			</div>
		</div>
	</div>
</section>