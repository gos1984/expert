<?php //print_r($data); ?>
<div class="block">
	<h2>Детальный отчёт по работе проверяющего</h2>
	<a href="/reports/file?file=detail" class="button">Скачать</a>
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
					<div class="td"><?php echo $val['dt_check']; ?></div>
					<div class="td"><?php echo $val['attest_id']; ?></div>
					<div class="td"><?php echo $val['exam_id']; ?></div>
					<div class="td"><?php echo $val['modality']; ?></div>
					<div class="td"><?php echo $val['ssapm']; ?></div>
					<div class="td"><?php echo $val['summ']; ?></div>
					
				</div>
			<?php } ?>
		</div>
		<!-- <div class="tfoot">
			<div class="tr">
				<div class="td"></div>
				<div class="td"></div>
				<div class="td"></div>
				<div class="td"></div>
				<div class="td"></div>
				<div class="td border">Итого</div>
				<div class="td border"></div>
			</div>
		</div> -->
	</div>
</div>