<section id="reports">
	<nav class="main-menu">
		<ul>
			<li><a href="/reports/all">Все тесты</a></li>
			<li><a href="/reports/vkk">ВКК</a></li>
			<li><a href="/reports/students">Сдающие</a></li>
			<li><a href="/reports/experts">Проверяющие</a></li>
			<li><a href="/reports/quantity">Количество проверенных тестов</a></li>
			<li><a href="/reports/detail">Детальный отчёт по работе проверяющего</a></li>
		</ul>
	</nav>
	<div class="content">
		<h1>Отчёты</h1>
		<div class="container">
			<div class="block">
				<h2>Все тесты</h2>
				<a href="/reports/file/file?file=all" class="button">Скачать</a>
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
								<div class="td"><?php echo $val['email']; ?></div>
								<div class="td"><?php echo $val['phone_private']; ?></div>
								<div class="td"><?php echo $val['phone_work']; ?></div>
								<div class="td"><?php echo $val['state']; ?></div>
								<div class="td"><?php echo $val['dt_create']; ?></div>
								<div class="td"><?php echo $val['dt_public']; ?></div>
								<div class="td"><?php echo $val['quantity']; ?></div>
								<div class="td"><?php echo $val['result']; ?></div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>