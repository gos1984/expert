<?php //print_r($data); ?>
<section id="directory">
	<div class="error">
		<?php if(!empty($data['error'])) { ?>
		<?php foreach($data['error'] as $val) { ?>
			<p><?php echo $val; ?></p>
		<?php } ?>
		<?php } ?>
	</div>
	<div class="container">
		<div class="block">
			<form class="table" action="javascript:void(null);" data-href="/directory/edit">
				<div class="tr">
					<div class="th h2">Модальности</div>
				</div>
				<div class="tbody">
					<?php foreach($data['modality'] as $modality) { ?>
						<div class="tr">
							<div class="td"><input type="text" value="<?php echo $modality['name']; ?>" name="<?php echo "modality[edit][{$modality['id']}]"; ?>"></div>
							<div class="td"><i class="button edit del" data-href="<?php echo "/directory/show?type=test&direct=modality&id={$modality['id']}"; ?>">-</i></div>
						</div>
					<?php } ?>
				</div>
				<div class="tfoot">
					<div class="tr">
						<div class="td"><input type="text" value="" data-name="modality"></div>
						<div class="td"><i class="button edit add">+</i></div>
					</div>
				</div>
				<button>Сохранить</button>
			</form>
		</div>
		<div class="block">
			<form class="table" action="javascript:void(null);" data-href="/directory/edit">
				<div class="tr">
					<div class="th h2">Системы стратификации и параметры измерения</div>
				</div>
				<div class="tbody">
					<?php foreach($data['ssapm'] as $ssapm) { ?>
						<div class="tr">
							<div class="td"><input type="text" value="<?php echo $ssapm['name']; ?>" name="<?php echo "ssapm[edit][{$ssapm['id']}]"; ?>"></div>
							<div class="td"><i class="button edit del" data-href="<?php echo "/directory/show?type=test&direct=ssapm&id={$ssapm['id']}"; ?>">-</i></div>
						</div>
					<?php } ?>
				</div>
				<div class="tfoot">
					<div class="tr">
						<div class="td"><input type="text" data-name="ssapm"></div>
					<div class="td"><i class="button edit add">+</i></div>
					</div>
				</div>
				<button>Сохранить</button>
			</form>
		</div>
	</div>
</section>