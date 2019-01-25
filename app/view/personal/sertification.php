<div class="block">
	<?php if(!empty($data['sertif'])) { ?>
		<h3>Мои сертификаты</h3>
		<ul class="items">
			<?php for($i=0;$i < count($data['sertif']);$i++) {
				?>
				<li>
					<?php if($_SESSION['medic'] == 1) { ?>
						<a href="<?php echo "/personal/show?pdf=1&login={$_SESSION['login']}&level={$data['sertif'][$i]['level']}&id={$data['sertif'][$i]['id']}"; ?>" target="_blank"></a>
						<div class="image">
							<img src="/app/template/img/docs/user1/26.jpg" alt="">
						</div>
						<h3 class="title"><?php echo "{$data['sertif'][$i]['modality']} / {$data['sertif'][$i]['ssapm']}"; ?></h3>
						<p class="descr"><?php echo "Сертификат уровень: {$data['level'][$data['sertif'][$i]['level']]} "?></p>
					<?php } else { ?>
						<h3 class="title-no">Для доступа к сетрификатам загрузите документы об образовании</h3>
					<?php } ?>

				</li>

			<?php } ?>
		</ul>
	<?php } else { ?>
		<h3>Сертификатов нет</h3>
	<?php } ?>
</div>