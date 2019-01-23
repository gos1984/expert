<?php //print_r($data); ?>
<section id="results">
	<?php if(!empty($data['result'])) { ?>
		<div class="table grid">
			<div class="thead">
				<div class="tr">
					<?php foreach($data['title'] as $key => $val) { ?>
						<div class="th"><a href="<?php echo '/results'.sortOrder($key); ?>" class="asc"><?php echo $val; ?></a></div>
					<?php } ?>
					<!-- <th>Уровень</th> -->
					<div class="td"><button class="reset">Сбросить</button></div>
				</div>
			</div>
			<div class="tbody">
				<?php foreach($data['result'] as $result) { 
					?>
					<div class="<?php echo isset($result['result']) && $result['state_id'] == 4 ? ($result['result'] == 0 ? 'tr red' : 'tr green') : 'tr' ; ?>">
						<div class="td"><?php echo $result['attest_id']; ?></div>
						<div class="td"><?php echo $result['dt_create']; ?></div>
						<div class="td"><?php echo $result['state']; ?></div>
						<div class="td"><?php echo isset($result['result']) && $result['state_id'] == 4 ? ($result['result'] == 1 ? 'Верно' : 'Неверно') : ''; ?></div>
						<div class="td"><?php echo $result['dt_public']; ?></div>
						<div class="td"><?php echo $result['dt_end']; ?></div>
						<div class="td"><a href="<?php echo "/results/show?type=json&id_result={$result['id']}";?>" class="button more">Подробнее</a></div>
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
			<div class="block">
				<div class="image_group">
				</div>
			</div>
		</div>
	</div>
</div>