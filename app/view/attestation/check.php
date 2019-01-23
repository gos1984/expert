<section id="check">
	<?php if(!empty($data['check'])) { ?>
		<div class="table">
			<div class="thead">
				<div class="tr">
					<div class="th">№ теста</div>
					<div class="th">Тема</div>
					<div class="th">Модальность</div>
					<div class="th">Системы стратификации и параметры измерения</div>
					<div class="th">Уровень</div>
					<div class="th">Дата заполнения</div>
					<div class="td"><button class="reset">Сбросить</button></div>
				</div>
			</div>
			<div class="tbody">
				<?php for($i = 0; $i < count($data['check']); $i++) { ?>
					<div class="tr">
						<div class="td"><?php echo $data['check'][$i]['attest_id']; ?></div>
						<div class="td"><?php echo $data['check'][$i]['theme']; ?></div>
						<div class="td"><?php echo $data['check'][$i]['modality']; ?></div>
						<div class="td"><?php echo $data['check'][$i]['ssapm']; ?></div>
						<div class="td"><?php echo $data['check'][$i]['level']; ?></div>
						<div class="td"><?php echo $data['check'][$i]['dt_create']; ?></div>
						<div class="td"><a class="button test more" href="<?php echo "/attestation/show?type=json&id_result={$data['check'][$i]['id']}"; ?>">Проверить</a></div>
					</div>
				<?php } ?>
			</div>
		</div>
	<?php } else { ?>
		<div class="center">
			<h2>Ничего не найдено!</h2>
		</div>
	<?php }  ?>
	</section>
	<div id="popup">
		<button class="close">X</button>
		<div class="wrap_popup">
			<div class="container">
				<table>
					<thead><tr></tr></thead>
					<tbody><tr></tr></tbody>
				</table>
			</div>
			<div class="container">
				<div class="block">
					<div class="video">
					</div>
				</div>
				<form class="block" action="javascript:void(null);" data-href="/attestation/edit?action=check">
					<input type="hidden" name="login" value="<?php echo $_SESSION['login']; ?>">
					<div class="image_group">
					</div>
					<button>Отправить</button>
				</form>
			</div>
		</div>
</div>