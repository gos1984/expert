<section id="personal">
	<div class="main">
		<nav class="sidebar">
			<ul>
				<li><a href="/personal">Личная информация</a></li>
				<li><a href="/personal/docs">Копии документов</a></li>
				<li><a href="/personal/password">Смена пароля</a></li>
				<li><a href="/personal/sertification">Сертификаты</a></li>
			</ul>
		</nav>
		<div class="content">
			<h1>Личный кабинет</h1>
			<div class="container">
				<div class="block">

	<h3>Загрузите документы об образовании!</h3>
	<form id="education_docs" class="scan" action="javascript:void(null);" data-href="/personal/docs/edit?action=docs">
		<input type="hidden" name="login" value="<?php echo $_SESSION['login']; ?>">
		<div class="files docs">
		</div>
		<div class="info"></div>
		<button>Отправить на проверку</button>
	</form>
	<hr>
	<div class="block_docs">
		<h3>Ваши документы</h3>
		<?php if(is_array($data['docs'])) { ?>
			<div class="table">
				<div class="thead">
					<div class="tr">
						<?php foreach($data['title'] as $key => $val) { ?>
							<div class="th"><?php echo $val; ?></div>
						<?php } ?>
					</div>
				</div>
				<div class="tbody">
					<?php foreach($data['docs'] as $key => $val) { ?>
						<div class="<?php  echo isset($val['result']) ? ($val['result'] == 1 ? 'tr green' : 'tr red') : 'tr'; ?>">
							<div class="td"><?php echo $val['doc_name']; ?></div>
							<div class="td"><?php echo $val['dt_insert']; ?></div>
							<div class="td"><?php echo $val['dt_check']; ?></div>
							<div class="td"><?php echo $val['login_check']; ?></div>
							<div class="td"><?php echo $val['result_check']; ?></div>
							<div class="td"><?php echo $val['comment_check']; ?></div>
							<div class="td">
								<div class="doc_img">
									<img src="<?php echo $val['doc_file']; ?>" alt="<?php echo $val['doc_name']; ?>">
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php } else { ?>
			<h3><?php echo $data['docs']; ?></h3>
		<?php } ?>
	</div>
</div>
<div id="popup">
	<div class="image_group">
		<div class="image">
			<div class="image_wrap">
				<img src="" alt="">
			</div>
			<div class="tools"></div>
		</div>
	</div>
</div>
			</div>
		</div>
	</div>
</section>

