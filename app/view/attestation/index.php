<?php //print_r($data); ?>
<section id="attests">
	<div class="content">
		<p class="h2 center">«Сдав тест уровня Эксперт и документы о медицинском образовании Вы получаете сертификат.<br/> Уровень Эксперт-Консультант дополнительно позволяет заключить договор с НПЦМР и проверять других аттестуемых, зарабатывая на этом»</p>
	<div class="grid table">
		<div class="thead">
			<div class="tr">
				<?php foreach($data['title'] as $key => $val) { ?>
					<div class="th"><a href="<?php echo '/attestation/attests'.sortOrder($key); ?>" class="asc"><?php echo $val; ?></a></div>
				<?php } ?>
				<!-- <th>Уровень</th> -->
				<div class="td"><button class="reset">Сбросить</button></div>
			</div>
		</div>
		<div class="tbody">
			<?php foreach($data['attest'] as $attest) { ?>
				<div class="tr">
					<div class="td"><?php echo $attest['attest_id']; ?></div>
					<div class="td"><?php echo $attest['name']; ?></div>
					<div class="td"><?php echo $attest['modality']; ?></div>
					<div class="td"><?php echo $attest['ssapm']; ?></div>
					<div class="td"><?php echo $attest['image_max_count']; ?></div>
					<div class="td level"><?php echo $attest['level']; ?></div>
					<div class="td"><?php echo $attest['price']; ?></div>
					<div class="td"><?php echo $attest['active_days']; ?></div>
					<div class="td"><a class="button test more" href="<?php echo "/attestation/attests/show?type=json&id_attest={$attest['attest_id']}&level={$attest['level']}"; ?>">Пройти</a></div>
				</div>
			<?php } ?>
		</div>
	</div>
	</div>
</section>
<div id="popup">
	<button class="close">X</button>
	<div class="wrap_popup">
		<div id="testing">
			<div class="container">
			<div class="block">
				<h3>1. Посмотрите ролик</h3>
				<div class="video">
				</div>
			</div>
			<div class="block">
				<h3>2. Загрузите изображения</h3>
				<form id="result_testing" class="test" action="javascript:void(null);" data-href="/attestation/attests/attests?action=testing">
					<input type="hidden" name="login" value="<?php echo $_SESSION['login']; ?>">
					<div class="files">
					</div>
					<label for="message" class="h3">Общие комментарии</label>
					<textarea name="attested_comment" id="message" rows="5"></textarea>
					<button>Отправить на проверку</button>
				</form>
			</div>
		</div>
		</div>
	</div>
</div>