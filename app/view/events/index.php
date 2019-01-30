<section id="events">
	<div class="table grid">
		<div class="thead filter">
			<div class="tr">
				<?php foreach($data['title'] as $key => $val) { ?>
					<div class="th">
						<a href="<?php echo '/events'.sortOrder($key); ?>" class="asc"><?php echo $val; ?></a>
						<div class="find">
							<?php if($key == "modality" || $key == "ssapm") { ?>
								<select data-find="<?php echo $key; ?>">
									<option value=""></option>
									<?php foreach($data[$key] as $el) { ?>
										<option value="<?php echo $el['id']; ?>"><?php echo $el['name']; ?></option>
									<?php } ?>	
								</select>
							<? } else { ?>
								<input type="text" data-find="<?php echo $key; ?>">
							<?php } ?>
						</div>
					</div>
				<?php } ?>
				<div class="td"><button class="reset">Сбросить</button>
					<a href="/events/show?type=json" class="button new_events">Добавить случай</a></div>
			</div>
		</div>
		<div class="tbody">
			<?php foreach($data['events'] as $e => $event) { ?>
				<form class="tr fast_edit" action="javascript:void(null);" data-href="/events/edit?action=update">
					<div class="td"><input type="text" name="id" value="<?php echo $event['id']; ?>" class="id"></div>
					<div class="td"><input type="text" name="name" value="<?php echo $event['name']; ?>" class="name"></div>
					<div class="td">
						<select name="modality" class="modality">
							<option value=""></option>
							<?php foreach($data['modality'] as $m) { ?>
								<option value="<?php echo $m['id']; ?>" <?php echo $m['id'] == $event['modality'] ? 'selected' : ''; ?>><?php echo $m['name']; ?></option>
							<?php } ?>	
						</select>
					</div>
					<div class="td">
						<select name="ssapm" class="ssapm">
							<option value=""></option>
							<?php foreach($data['ssapm'] as $m) { ?>
								<option value="<?php echo $m['id']; ?>" <?php echo $m['id'] == $event['ssapm'] ? 'selected' : ''; ?>><?php echo $m['name']; ?></option>
							<?php } ?>	
						</select>
					</div>
					<div class="td"><textarea name="descr" class="descr"><?php echo $event['descr']; ?></textarea></div>
					<div class="td"><input type="text" name="attest_before" value="<?php echo $event['attest_before']; ?>" class="attest_before"></div>
					<div class="td"><input type="text" name="image_max_count_level1" value="<?php echo $event['image_max_count_level1']; ?>" class="image_max_count_level1"></div>
					<div class="td"><input type="text" name="image_max_count_level2" value="<?php echo $event['image_max_count_level2']; ?>" class="image_max_count_level2"></div>
					<div class="td">
						<a href="<?php echo "/events/show?type=json&id_event={$event['id']}";?>" class="button more">Подробнее</a>
						<button class="save">Сохранить</button>
						<a class="button del red" href="/events/edit?action=del&id_event=<?php echo $event['id']; ?>">Удалить</a>
						<span class="result"></span>
					</div>
				</form>
			<?php } ?>
		</div>
	</div>
</section>
<div id="popup">
	<button class="close">X</button>
	<div class="wrap_popup">
		<div id="testing">
			<form class="edit_form"  action="javascript:void(null);" data-href="/events/edit?action=update&full=true">
				<div class="container">
					<div class="block">
						<h3>Случай</h3>

						<div class="block_data"></div>

					</div>
					<div class="block">
						<h3>Видео</h3>
						<div class="block_video">
						</div>
						<div class="block_descr">
							<label for="descr">Описание</label>
							<textarea name="descr" id="descr"></textarea>
							<script>
								//CKEDITOR.replace('descr');
							</script>
						</div>
					</div>
				</div>
				<button>Сохранить</button>
			</form>
		</div>
	</div>
</div>