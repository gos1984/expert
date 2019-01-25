<div class="block">
	<h3>Данные пользователя</h3>
	<form id="personal_data" action="javascript:void(null);" data-href="/personal/edit?action=info">
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