<?php //print_r($data); ?>
<div class="block">
	<h2>Количество проверенных тестов</h2>
	<a href="/reports/file?file=quantity" class="button">Скачать</a>
	<div class="table reports">
		<div class="thead">
			<div class="tr">
				<?php foreach($data['title'] as $key => $val) { ?>
					<div class="th"><?php echo $val; ?></div>
				<?php } ?>
			</div>
		</div>
		<div class="tbody">
			<?php foreach($data['data'] as $key => $val) { ?>
				<div class="tr">
					<div class="td"><?php echo $val['login']; ?></div>
					<div class="td"><?php echo $val['role_name']; ?></div>
					<div class="td"><?php echo $val['name']; ?></div>
					<div class="td"><?php echo $val['count']; ?></div>
					<div class="td"><?php echo $val['level1']; ?></div>
					<div class="td"><?php echo $val['level2']; ?></div>
				</div>
			<?php } ?>
		</div>
	</div>
</div>