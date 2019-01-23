<section id="events">
	<div class="table grid">
		<div class="thead">
			<div class="tr">
				<?php foreach($data['title'] as $key => $val) { ?>
					<div class="th"><a href="<?php echo '/events'.sortOrder($key); ?>" class="asc"><?php echo $val; ?></a></div>
				<?php } ?>
				<div class="td"><button class="reset">Сбросить</button>
					<a href="/events/events/show?type=json" class="button new_events">Добавить случай</a></div>
			</div>
		</div>
		<div class="tbody">
			<?php foreach($data['events'] as $e => $event) { ?>
				<form class="tr fast_edit" action="javascript:void(null);" data-href="/events/edit?action=update">
					<div class="td"><input type="text" name="id" value="<?php echo $event['id']; ?>"></div>
					<div class="td"><input type="text" name="name" value="<?php echo $event['name']; ?>"></div>
					<div class="td">
						<select name="modality">
							<?php foreach($data['modality'] as $m) { ?>
								<option value="<?php echo $m['id']; ?>" <?php echo $m['id'] == $event['modality'] ? 'selected' : ''; ?>><?php echo $m['name']; ?></option>
							<?php } ?>	
						</select>
					</div>
					<div class="td">
						<select name="ssapm">
							<?php foreach($data['ssapm'] as $m) { ?>
								<option value="<?php echo $m['id']; ?>" <?php echo $m['id'] == $event['ssapm'] ? 'selected' : ''; ?>><?php echo $m['name']; ?></option>
							<?php } ?>	
						</select>
					</div>
					<div class="td"><textarea name="descr"><?php echo $event['descr']; ?></textarea></div>
					<div class="td"><input type="text" name="attest_before" value="<?php echo $event['attest_before']; ?>"></div>
					<div class="td"><input type="text" name="image_max_count_level1" value="<?php echo $event['image_max_count_level1']; ?>"></div>
					<div class="td"><input type="text" name="image_max_count_level2" value="<?php echo $event['image_max_count_level2']; ?>"></div>
					<div class="td">
						<a href="<?php echo "/events/events/show?type=json&id_event={$event['id']}";?>" class="button more">Подробнее</a>
						<button class="save">Сохранить</button>
						<a class="button del red" href="/events/events/edit?action=del&id_event=<?php echo $event['id']; ?>">Удалить</a>
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
			<form class="edit_form"  action="javascript:void(null);" data-href="/events/events/edit?action=update&full=true">
				<div class="container">
					<div class="block">
						<h3>Случай</h3>

						<div class="block_data"></div>

					</div>
					<div class="block">
						<h3>Видео</h3>
						<div class="block_video">
						</div>
					</div>
				</div>
				<button>Сохранить</button>
			</form>
		</div>
	</div>
</div>