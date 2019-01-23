<?php //print_r($data); ?>
<section id="setting">
	<div class="container">
		<div class="block">
			<div class="table">
				<div class="tbody">
					<?php foreach($data['setting'] as $key => $val) { ?>
						<form class="tr" action="javascript:void(null);" data-href="/settings/setting/edit?action=update">
							<label class="td left h3" for="<?php echo $key; ?>"><?php echo $data['title'][$key]; ?></label>
							<div class="td">
								<input id="<?php echo $key; ?>" type="number" name="<?php echo $key; ?>" value="<?php echo $val; ?>" min="0">
							</div>
							<div class="td"><button>Сохранить</button></div>
						</form>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</section>