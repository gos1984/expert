-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 08 2019 г., 10:42
-- Версия сервера: 5.6.38
-- Версия PHP: 7.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `medexpert3`
--

-- --------------------------------------------------------

--
-- Структура таблицы `access`
--

CREATE TABLE `access` (
  `user_login` varchar(50) NOT NULL COMMENT 'Логин пользователя',
  `role_name` varchar(50) NOT NULL COMMENT 'роль'
) ENGINE=InnoDB AVG_ROW_LENGTH=5461 DEFAULT CHARSET=utf8 COMMENT='Права пользователей';

--
-- Дамп данных таблицы `access`
--

INSERT INTO `access` (`user_login`, `role_name`) VALUES
('admin', 'Администратор'),
('admin1', 'Администратор'),
('admin2', 'Администратор'),
('123123', 'Аттестуемый'),
('admin3', 'Аттестуемый'),
('sdfsdf', 'Аттестуемый'),
('test', 'Аттестуемый'),
('test1', 'Аттестуемый'),
('test111', 'Аттестуемый'),
('test123', 'Аттестуемый'),
('test123123', 'Аттестуемый'),
('test123123123', 'Аттестуемый'),
('test123123123123', 'Аттестуемый'),
('test1231233', 'Аттестуемый'),
('test12312333', 'Аттестуемый'),
('test133', 'Аттестуемый'),
('test5', 'Аттестуемый'),
('user1', 'Аттестуемый'),
('user2', 'Аттестуемый'),
('user3', 'Аттестуемый'),
('user4', 'Аттестуемый');

-- --------------------------------------------------------

--
-- Структура таблицы `attest`
--

CREATE TABLE `attest` (
  `id` int(11) NOT NULL,
  `modality_id` int(11) DEFAULT NULL COMMENT 'Модальность. Ссылка на справочник modality.id',
  `ssapm_id` int(11) DEFAULT NULL COMMENT 'Системы стратификации и параметры измерения. Ссылка на справочник ssapm.id',
  `name` varchar(50) DEFAULT NULL COMMENT 'Наименование случая.',
  `descr` varchar(3000) DEFAULT NULL COMMENT 'Описание задания - что именно нужно измерить ',
  `image_max_count_level1` tinyint(4) DEFAULT NULL COMMENT 'Поле-галочка «Опубликован» (случаи могут быть «Опубликованы» и «Скрыты»)',
  `image_max_count_level2` tinyint(4) DEFAULT NULL,
  `public` tinyint(4) DEFAULT NULL COMMENT 'Поле-галочка «Опубликован» (случаи могут быть «Опубликованы» и «Скрыты»)',
  `price_level1_first` decimal(15,2) DEFAULT NULL COMMENT 'Цена сдачи на уровне Эксперт для первой попытки',
  `price_level1_next` decimal(15,2) DEFAULT NULL COMMENT 'Цена сдачи на уровне Эксперт для второй и последующих попыток',
  `price_level2_first` decimal(15,2) DEFAULT NULL COMMENT 'Цена сдачи на уровне Эксперт-Консультант для первой попытки',
  `price_level2_next` decimal(15,2) DEFAULT NULL COMMENT 'Цена сдачи на уровне Эксперт-Консультант для второй и последующих попыток',
  `active_days_level1` int(11) DEFAULT NULL COMMENT 'Срок действия сертификации (в днях) для уровня Эксперт',
  `active_days_level2` int(11) DEFAULT NULL COMMENT 'Срок действия сертификации (в днях) для уровня Эксперт-Консультант'
) ENGINE=InnoDB AVG_ROW_LENGTH=780 DEFAULT CHARSET=utf8 COMMENT='Аттестация';

--
-- Дамп данных таблицы `attest`
--

INSERT INTO `attest` (`id`, `modality_id`, `ssapm_id`, `name`, `descr`, `image_max_count_level1`, `image_max_count_level2`, `public`, `price_level1_first`, `price_level1_next`, `price_level2_first`, `price_level2_next`, `active_days_level1`, `active_days_level2`) VALUES
(0, 1, 1, 'Видео о пользовании системой', '<p><img alt=\"\" src=\"/app/template/js/kcfinder/upload/images/5c969ed6f434552056886fe4fa5cb3d3.jpg\" style=\"float:left; height:63px; width:100px\" />УКНЕУКЕНУКНЕУКНЕ</p>\r\n\r\n<p><a href=\"http://3123\">ЫВАПЫВАПЫВАП</a>asdfasdfasdf</p>\r\n\r\n<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"width:500px\">\r\n	<tbody>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>fsdfgsdfgsdfg</p>', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(1, 1, 1, 'КТ / Замер размера', '<p><img alt=\"\" src=\"/app/template/js/kcfinder/upload/images/5c969ed6f434552056886fe4fa5cb3d3.jpg\" />Представить 5 принтскринов маммограмм разных пациентов в хорошем качестве с образованиями молочной железы, соответствующими каждой из 5 категорий BI-RADS.</p>\r\n\r\n<p>Подписать в поле &quot;Комментарий&quot; соответствующую категорию по BI-RADS и рекомендации. Изображения должны быть представлены в форматах jpeg или png, размер всех изображений в сумме не должен превышать 1Гб.</p>', 2, 10, 1, '0.00', '50.00', '100.00', '50.00', 365, 365),
(2, 2, 1, 'МРТ / Замер размера', '<p>ывапывап</p>\r\n\r\n<p>jolijhph[io</p>\r\n\r\n<p>&nbsp;</p>', 2, 10, 1, NULL, NULL, '100.00', '50.00', 365, 365),
(3, 1, 1, 'КТ / Замер размера', NULL, 3, 10, 1, NULL, NULL, '100.00', '50.00', 365, 365),
(4, 2, 1, 'МРТ / Замер размера', NULL, 3, 10, 1, NULL, NULL, '100.00', '50.00', 365, 365),
(5, 4, 1, 'ММГ / Замер размера', NULL, 3, 10, 1, NULL, NULL, '100.00', '50.00', 365, 365),
(6, 3, 1, 'УЗИ / Замер размера', NULL, 5, 10, 1, NULL, NULL, '100.00', '50.00', 365, 365),
(7, 1, 2, 'КТ / КТ- LungRADS', 'Измерения 1-ой категории', 3, 10, 1, NULL, NULL, '100.00', '50.00', 365, 365),
(8, 1, 2, 'КТ / КТ- LungRADS', 'Измерения 3-ой категории', 3, 10, 1, NULL, NULL, '100.00', '50.00', 365, 365),
(9, 1, 2, 'КТ / КТ- LungRADS', 'Измерения 4-ой категории', 3, 10, 1, NULL, NULL, '300.00', '150.00', 365, 365),
(10, 1, 7, 'КТ / RECIST', NULL, 3, 10, 1, NULL, NULL, '300.00', '150.00', 365, 365),
(11, 1, 3, 'КТ / RECIST', NULL, 3, 10, 1, NULL, NULL, '300.00', '150.00', 365, 365),
(12, 1, 3, 'КТ / RECIST', NULL, 3, 10, 1, NULL, NULL, '300.00', '150.00', 365, 365),
(13, 1, 1, 'КТ / Замер размера', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 1, 1, 'КТ / Замер размера', NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 1, 1, 'КТ / Замер размера', '<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas feugiat consequat diam. Maecenas metus. Vivamus diam purus, cursus a, commodo non, facilisis vitae, nulla. Aenean dictum lacinia tortor. Nunc iaculis, nibh non iaculis aliquam, orci felis euismod neque, sed ornare massa mauris sed velit. Nulla pretium mi et risus. Fusce mi pede, tempor id, cursus ac, ullamcorper nec, enim. Sed tortor. Curabitur molestie. Duis velit augue, condimentum at, ultrices a, luctus ut, orci. Donec pellentesque egestas eros. Integer cursus, augue in cursus faucibus, eros pede bibendum sem, in tempus tellus justo quis ligula. Etiam eget tortor. Vestibulum rutrum, est ut placerat elementum, lectus nisl aliquam velit, tempor aliquam eros nunc nonummy metus. In eros metus, gravida a, gravida sed, lobortis id, turpis. Ut ultrices, ipsum at venenatis fringilla, sem nulla lacinia tellus, eget aliquet turpis mauris non enim. Nam turpis. Suspendisse lacinia. Curabitur ac tortor ut ipsum egestas elementum. Nunc imperdiet gravida mauris.<img alt=\"\" src=\"/app/template/js/kcfinder/upload/images/5c969ed6f434552056886fe4fa5cb3d3.jpg\" style=\"float:left; height:125px; margin:10px; width:200px\" /></p>', NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `attest_before`
--

CREATE TABLE `attest_before` (
  `attest_id` int(11) NOT NULL,
  `attest_id_before` int(11) NOT NULL COMMENT 'аттестация,  которая должна быть обязательно пройдена, чтобы отобразилась данная аттестация'
) ENGINE=InnoDB AVG_ROW_LENGTH=744 DEFAULT CHARSET=utf8 COMMENT='Списки аттестаций, которые должны быть обязательно пройдены, чтобы отобразилась данная аттестация';

--
-- Дамп данных таблицы `attest_before`
--

INSERT INTO `attest_before` (`attest_id`, `attest_id_before`) VALUES
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(8, 3),
(9, 3),
(10, 3),
(11, 3),
(12, 3),
(8, 7),
(9, 7),
(9, 8),
(11, 10),
(12, 10),
(12, 11);

-- --------------------------------------------------------

--
-- Структура таблицы `attest_video`
--

CREATE TABLE `attest_video` (
  `id` int(11) NOT NULL,
  `attest_id` int(11) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL COMMENT 'ссылка на файл обучающего видео'
) ENGINE=InnoDB AVG_ROW_LENGTH=4096 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `attest_video`
--

INSERT INTO `attest_video` (`id`, `attest_id`, `video`) VALUES
(7, 10, '/app/template/video/10.mp4'),
(8, 11, '/app/template/video/11.mp4'),
(9, 12, '/app/template/video/12.mp4'),
(10, 7, '/app/template/video/7.mp4'),
(11, 8, '/app/template/video/8.mp4'),
(12, 5, '/app/template/video/5.mp4'),
(13, 6, '/app/template/video/6.mp4'),
(14, 9, '/app/template/video/9.mp4'),
(15, 1, '/app/template/video/1.mp4');

-- --------------------------------------------------------

--
-- Структура таблицы `black_list`
--

CREATE TABLE `black_list` (
  `login` varchar(50) NOT NULL,
  `dt_insert` timestamp NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Чёрный список - список тех кому Админ запретил оценивать других аттестуемых';

--
-- Дамп данных таблицы `black_list`
--

INSERT INTO `black_list` (`login`, `dt_insert`) VALUES
('user4', '2019-01-30 07:46:20');

-- --------------------------------------------------------

--
-- Структура таблицы `exam`
--

CREATE TABLE `exam` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL COMMENT 'логин аттестуемого',
  `attest_id` int(11) NOT NULL COMMENT 'идентификационный номер случая',
  `state_id` tinyint(4) DEFAULT NULL COMMENT 'Статус теста, определенный в справочнике exam_state',
  `level` tinyint(4) DEFAULT NULL COMMENT '1 - уровень Эксперт, 2 - уровень Эксперт-консультант',
  `result` tinyint(4) DEFAULT NULL COMMENT '0 - не верно, 1 - верно',
  `dt_create` timestamp NULL DEFAULT NULL COMMENT 'Дата/время создания теста',
  `dt_pay` timestamp NULL DEFAULT NULL COMMENT 'Дата/время оплаты теста',
  `dt_upload` timestamp NULL DEFAULT NULL COMMENT 'Дата/время отправки теста на проверку',
  `dt_public` timestamp NULL DEFAULT NULL,
  `attested_comment` varchar(1000) DEFAULT NULL COMMENT 'комментарии аттестуемого',
  `price_pay` decimal(18,2) DEFAULT NULL COMMENT 'Сумма, которую заплатил аттестуемый за тест',
  `dt_lock_until` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=4096 DEFAULT CHARSET=utf8 COMMENT='Экзамен. Проверочный тес, сдаваемый аттестуемым врачом.';

--
-- Дамп данных таблицы `exam`
--

INSERT INTO `exam` (`id`, `login`, `attest_id`, `state_id`, `level`, `result`, `dt_create`, `dt_pay`, `dt_upload`, `dt_public`, `attested_comment`, `price_pay`, `dt_lock_until`) VALUES
(1, 'user1', 1, 4, 1, 1, '2018-09-20 08:22:40', NULL, NULL, '2018-10-09 11:24:00', 'Думаю всё верно!', NULL, NULL),
(2, 'user1', 1, 4, 2, 1, '2018-09-21 12:37:02', NULL, NULL, '2018-10-09 11:24:00', 'Уверен что всё правильно!!!', NULL, NULL),
(3, 'user2', 1, 4, 1, 1, '2018-09-22 06:40:11', NULL, NULL, '2018-10-09 11:24:00', 'Думаю, всё очень даже правильно!', NULL, NULL),
(4, 'user3', 1, 4, 1, 1, '2018-10-10 07:02:50', NULL, NULL, '2018-10-25 14:17:00', 'Можно не проверять, всё верно!!!', NULL, NULL),
(5, 'user1', 1, 2, 1, NULL, '2019-01-23 12:38:50', NULL, NULL, NULL, 'asdfasdf', NULL, NULL),
(6, 'user1', 1, 2, 1, NULL, '2019-01-23 12:54:32', NULL, NULL, NULL, 'aasdfasdfasdf', NULL, NULL),
(7, 'user1', 4, 2, 1, NULL, '2019-01-23 12:55:03', NULL, NULL, NULL, 'asdfasdf', NULL, NULL),
(8, 'user2', 1, 3, 1, NULL, '2019-01-01 13:04:52', NULL, NULL, '2019-01-30 10:14:50', 'фывафыва', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `exam_check`
--

CREATE TABLE `exam_check` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) DEFAULT NULL COMMENT 'ссылка на тест',
  `login` varchar(50) DEFAULT NULL COMMENT 'Тот, кто проверил тест',
  `dt_check` timestamp NULL DEFAULT NULL COMMENT 'Дата и время проверки',
  `result` tinyint(4) DEFAULT NULL COMMENT '0 - не верно, 1 - верно',
  `expert_comment` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=8192 DEFAULT CHARSET=utf8 COMMENT='Одна строка - одна проверка теста. Один тест можетпроверяться несколько раз.';

--
-- Дамп данных таблицы `exam_check`
--

INSERT INTO `exam_check` (`id`, `exam_id`, `login`, `dt_check`, `result`, `expert_comment`) VALUES
(1, 1, 'admin', '2018-10-08 08:24:07', 1, 'Молодец!'),
(2, 1, 'admin1', '2018-10-08 08:26:12', 1, 'Круто!'),
(3, 1, 'admin2', '2018-10-08 11:15:46', 0, 'Попробуй ещё раз!'),
(4, 2, 'admin', '2018-10-08 12:40:13', 1, 'Молодец, нет слов'),
(5, 3, 'user1', '2018-10-09 06:40:57', 1, 'Даже я бы так не ответил!'),
(6, 4, 'admin', '2018-10-12 08:30:02', 1, 'Всё правильно, садись 5! :)'),
(7, 4, 'admin1', '2018-10-25 13:54:08', 1, 'Супер'),
(8, 8, 'user1', '2019-01-23 13:10:01', 1, 'Всё правильно!');

-- --------------------------------------------------------

--
-- Структура таблицы `exam_image`
--

CREATE TABLE `exam_image` (
  `id` int(11) NOT NULL,
  `attested_comment` varchar(4000) DEFAULT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `image_file` varchar(200) DEFAULT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=3276 DEFAULT CHARSET=utf8 COMMENT='Картинки загруженные аттестуемыми при сдаче тестов';

--
-- Дамп данных таблицы `exam_image`
--

INSERT INTO `exam_image` (`id`, `attested_comment`, `exam_id`, `image_file`) VALUES
(1, 'Вот бы и мне так полежать!', 1, '/app/template/img/testing/admin/1/1/0.jpg'),
(2, 'Красиво конечно!', 1, '/app/template/img/testing/admin/1/1/1.jpg'),
(3, 'Какая высота!', 2, '/app/template/img/testing/user1/1/2/0.jpg'),
(4, 'Горы!', 2, '/app/template/img/testing/user1/1/2/1.jpg'),
(5, 'Хорошая там рыбалка', 2, '/app/template/img/testing/user1/1/2/2.jpg'),
(6, 'Дорога в никуда', 2, '/app/template/img/testing/user1/1/2/3.jpg'),
(7, 'Чудо природы в Тихом океане', 2, '/app/template/img/testing/user1/1/2/4.jpg'),
(8, 'Осень пришла', 2, '/app/template/img/testing/user1/1/2/5.jpg'),
(9, 'Красиво конечно', 2, '/app/template/img/testing/user1/1/2/6.jpg'),
(10, 'Край земли', 2, '/app/template/img/testing/user1/1/2/7.jpg'),
(11, 'Весна', 2, '/app/template/img/testing/user1/1/2/8.jpg'),
(12, 'Закат', 2, '/app/template/img/testing/user1/1/2/9.jpg'),
(13, 'Так высоко!', 3, '/app/template/img/testing/user2/1/3/0.jpg'),
(14, 'Красиво конечно!', 3, '/app/template/img/testing/user2/1/3/1.jpg'),
(15, 'Атлантида!', 4, '/app/template/img/testing/user3/1/4/0.jpg'),
(16, 'Золотая пора', 4, '/app/template/img/testing/user3/1/4/1.jpg'),
(17, 'asdfasdf', 5, '/app/template/img/testing/user1/1/5/0.jpg'),
(18, 'asdfasdf', 5, '/app/template/img/testing/user1/1/5/1.jpg'),
(19, 'asdfasdf', 6, '/app/template/img/testing/user1/1/6/0.jpg'),
(20, 'asdfasdf', 6, '/app/template/img/testing/user1/1/6/1.jpg'),
(21, 'asedfasdfasdfasdf', 7, '/app/template/img/testing/user1/4/7/0.jpg'),
(22, 'asdfasd', 7, '/app/template/img/testing/user1/4/7/1.jpg'),
(23, 'fasdfasdf', 7, '/app/template/img/testing/user1/4/7/2.jpg'),
(24, 'фывафывафыва', 8, '/app/template/img/testing/user2/1/8/0.jpg'),
(25, 'фывафывафыва', 8, '/app/template/img/testing/user2/1/8/1.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `exam_image_result`
--

CREATE TABLE `exam_image_result` (
  `id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  `result` int(11) NOT NULL,
  `expert_comment` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `exam_image_result`
--

INSERT INTO `exam_image_result` (`id`, `image_id`, `result`, `expert_comment`) VALUES
(1, 1, 1, 'Так и есть!'),
(2, 2, 1, 'Круто конечно!'),
(3, 1, 1, 'Это точно!'),
(4, 2, 1, 'Ага!'),
(5, 1, 1, 'Точно так!'),
(6, 2, 0, 'Какая-то фигня!'),
(7, 3, 1, 'Так и есть!'),
(8, 4, 1, 'Они самые)))'),
(9, 5, 1, 'Ага'),
(10, 6, 1, 'В ад)))'),
(11, 7, 1, 'Это точно!'),
(12, 8, 1, 'Уже???'),
(13, 9, 1, 'Ну да!'),
(14, 10, 1, 'А ниже слоны, киты и черепаха :)'),
(15, 11, 1, 'Это да'),
(16, 12, 1, 'Верно'),
(17, 13, 1, 'Так и есть'),
(18, 14, 1, 'Ага'),
(19, 15, 1, 'Молодец'),
(20, 16, 1, 'Супер!'),
(21, 15, 1, 'Молодец'),
(22, 16, 1, 'Круто'),
(23, 24, 1, 'Молодец'),
(24, 25, 1, 'Красавчик');

-- --------------------------------------------------------

--
-- Структура таблицы `exam_state`
--

CREATE TABLE `exam_state` (
  `id` tinyint(4) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=5461 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `exam_state`
--

INSERT INTO `exam_state` (`id`, `name`) VALUES
(1, 'Оплачен'),
(2, 'Заполнен'),
(3, 'Проверен'),
(4, 'Опубликован'),
(5, 'Устарел');

-- --------------------------------------------------------

--
-- Структура таблицы `expert_work`
--

CREATE TABLE `expert_work` (
  `id` int(11) NOT NULL,
  `login` varchar(50) DEFAULT NULL,
  `attest_id` int(11) DEFAULT NULL,
  `enable` tinyint(4) DEFAULT NULL COMMENT 'Активен: 0 - если эксперту запрещается проверять случаи данного типа, 1 - если разрешается.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Списки случаев, которые может проверять каждый из экспертов';

--
-- Дамп данных таблицы `expert_work`
--

INSERT INTO `expert_work` (`id`, `login`, `attest_id`, `enable`) VALUES
(6, 'user1', 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `level`
--

CREATE TABLE `level` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=8192 DEFAULT CHARSET=utf8 COMMENT='Уровни теста';

--
-- Дамп данных таблицы `level`
--

INSERT INTO `level` (`id`, `name`) VALUES
(1, 'Эксперт'),
(2, 'Эксперт-консультант');

-- --------------------------------------------------------

--
-- Структура таблицы `modality`
--

CREATE TABLE `modality` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=4096 DEFAULT CHARSET=utf8 COMMENT='Справочник Модальность';

--
-- Дамп данных таблицы `modality`
--

INSERT INTO `modality` (`id`, `name`) VALUES
(1, 'КТ'),
(2, 'МРТ'),
(3, 'УЗИ'),
(4, 'ММГ');

-- --------------------------------------------------------

--
-- Структура таблицы `page`
--

CREATE TABLE `page` (
  `id` int(11) NOT NULL,
  `page` varchar(255) NOT NULL,
  `href` varchar(255) NOT NULL,
  `priority` int(11) NOT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=2730 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `page`
--

INSERT INTO `page` (`id`, `page`, `href`, `priority`) VALUES
(1, 'Пользователи', '/users', 1),
(2, 'Случаи', '/events', 1),
(3, 'Справочники', '/directory', 1),
(4, 'Аттестации', '/attestation', 4),
(5, 'Проверка', '/check', 2),
(6, 'Результаты', '/results', 3),
(7, 'Настройки', '/setting', 1),
(8, 'Отчеты', '/reports', 2),
(9, 'Кандидаты в эксперты', '/experts', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `role`
--

CREATE TABLE `role` (
  `name` varchar(50) NOT NULL,
  `priority` int(11) NOT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=5461 DEFAULT CHARSET=utf8 COMMENT='Роли пользователей: Аттестуемый, Эксперт, Администратор, ....';

--
-- Дамп данных таблицы `role`
--

INSERT INTO `role` (`name`, `priority`) VALUES
('Администратор', 1),
('Аттестуемый', 3);

-- --------------------------------------------------------

--
-- Структура таблицы `sertif`
--

CREATE TABLE `sertif` (
  `id` int(11) NOT NULL,
  `exam_id` int(11) DEFAULT NULL COMMENT 'ссылка на тест, успешная сдача которого обеспечила выдачу этого сертификата',
  `modality_id` int(11) NOT NULL,
  `ssapm_id` int(11) DEFAULT NULL COMMENT 'ссылка на систему стратификации',
  `date_start` date DEFAULT NULL COMMENT 'дата начала действия сертификата',
  `date_end` date DEFAULT NULL COMMENT 'дата окончания действия сертификата',
  `public_link` tinyint(4) DEFAULT NULL COMMENT '0- ссылка не действует, 1 - ссылка действует'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='сертификаты ';

--
-- Дамп данных таблицы `sertif`
--

INSERT INTO `sertif` (`id`, `exam_id`, `modality_id`, `ssapm_id`, `date_start`, `date_end`, `public_link`) VALUES
(44, 1, 1, 1, '2018-10-09', '2019-10-09', 1),
(45, 2, 1, 1, '2018-10-09', '2019-10-09', 1),
(46, 3, 1, 1, '2018-10-09', '2019-10-09', 0),
(51, 4, 1, 1, '2018-10-25', '2019-10-25', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `setup`
--

CREATE TABLE `setup` (
  `id` int(11) NOT NULL,
  `percent_vcc` tinyint(4) DEFAULT NULL COMMENT 'процент вероятности попадания теста 1 уровня на перепроверку вторым экспертом-консультантом',
  `salary_level1` int(11) DEFAULT NULL COMMENT 'Оплата за проверку теста уровня Эксперт',
  `salary_level2` int(11) DEFAULT NULL COMMENT 'оплата за проверку теста уровня Эксперт_Консультант',
  `days_wait_until_puplic` int(11) DEFAULT NULL COMMENT 'Количество дней до публикации результата с момента сдачи теста',
  `hours_for_checking` tinyint(4) DEFAULT NULL
) ENGINE=MyISAM AVG_ROW_LENGTH=19 DEFAULT CHARSET=utf8 COMMENT='глобальные настройки сервиса';

--
-- Дамп данных таблицы `setup`
--

INSERT INTO `setup` (`id`, `percent_vcc`, `salary_level1`, `salary_level2`, `days_wait_until_puplic`, `hours_for_checking`) VALUES
(1, 10, 70, 490, 14, 24);

-- --------------------------------------------------------

--
-- Структура таблицы `ssapm`
--

CREATE TABLE `ssapm` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AVG_ROW_LENGTH=2730 DEFAULT CHARSET=utf8 COMMENT='Системы стратификации и параметры измерения';

--
-- Дамп данных таблицы `ssapm`
--

INSERT INTO `ssapm` (`id`, `name`) VALUES
(1, 'Замер размера'),
(2, 'КТ- LungRADS'),
(3, 'RECIST'),
(4, 'BiRADS'),
(5, 'TiRads'),
(6, 'PiRADS'),
(7, 'RECIST');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `login` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL COMMENT 'Пароль НЕ храниится в открытом виде. Хранится лишь хэш пароля.',
  `name_f` varchar(50) DEFAULT NULL COMMENT 'Фамилия',
  `name_i` varchar(50) DEFAULT NULL COMMENT 'Имя',
  `name_o` varchar(50) DEFAULT NULL COMMENT 'Отчество',
  `dt_reg` timestamp NULL DEFAULT NULL COMMENT 'Дата регистрации',
  `email` varchar(70) DEFAULT NULL COMMENT 'почта',
  `phone_private` varchar(50) DEFAULT NULL COMMENT 'телефон личный',
  `phone_work` varchar(50) DEFAULT NULL COMMENT 'Телефон рабочий',
  `birthday` date DEFAULT NULL COMMENT 'Дата рождения',
  `birthplace` varchar(255) DEFAULT NULL COMMENT 'Место рождения',
  `position` varchar(255) DEFAULT NULL COMMENT 'Должность',
  `education` varchar(255) DEFAULT NULL COMMENT 'Образование основное',
  `education_add` varchar(255) DEFAULT NULL COMMENT 'Дополнительное образование',
  `active_hex` varchar(255) DEFAULT NULL,
  `medic` tinyint(4) DEFAULT '0' COMMENT '0 - нет мед-образования, 1 - есть мед-образование. Поле заполняется проверяющим документы.'
) ENGINE=InnoDB AVG_ROW_LENGTH=5461 DEFAULT CHARSET=utf8 COMMENT='Пользователи любых ролей. И клиенты, и эксперты, и администраторы.';

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`login`, `password`, `name_f`, `name_i`, `name_o`, `dt_reg`, `email`, `phone_private`, `phone_work`, `birthday`, `birthplace`, `position`, `education`, `education_add`, `active_hex`, `medic`) VALUES
('123123', '$2y$10$4mKbbpNbj.K9Ng7rg8Ujo.B51hCiGCyLRYDXj2ZTSXmkCJ2KzOVRq', '', 'Олег', '', '2019-03-28 09:29:36', 'o.gaivoronsky@npcmr.ru123123123', '+7 (123) 123-12-31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
('admin', '$2y$10$UFGoRpmocKHhvDrkgET0COgk9SxYRUpo4Af/j1oL8dahtGsDyNtt.', 'Гайворонский', 'Олег', 'Сергеевич', '2018-01-18 11:00:00', 'o.gaivoronsky@npcmr.ru', '+7 (563) 456-34-56', '+7 (345) 634-56-34', '1984-12-06', 'Москва', 'Программист', 'Среднее', 'Курсы', '57cec4137b614c87cb4e24a3d003a3e0', 0),
('admin1', '$2y$10$g30l7jhPn3dbzAyFg0LuH.jauMOCjcTI5mm3eO4N9xbCvPX1bUSte', 'Бубликов', 'Инокентий', 'Ростиславович', '2018-01-18 15:08:25', 'mail@mail.ru', NULL, NULL, '1965-12-01', NULL, NULL, NULL, NULL, 'ff44570aca8241914870afbc310cdb85336d5ebc5436534e61d16e63ddfca3278fa14cdd754f91cc6554c9e71929cce75206560a306a2e085a437fd258eb57ceb9ece18c950afbfa6b0fdbfa4ff731d3', 0),
('admin2', '$2y$10$rsbw2D9fV.oE6xpj/DiCG.z2BKKGysZccbEzy9nREeFySvZpf8cua', 'Васильков', 'Пётр', 'Бенедиктович', '2018-01-18 15:16:32', 'mail1@mail.ru', NULL, '8 (890) 888-88-88', '1980-11-01', 'Санкт-Петербург', 'Врач', 'Высшее', NULL, '', 0),
('admin3', '$2y$10$AHGNxB3aMv3WufENOgEPeeKkaUTdM/w3pWoLv9aVl/7kNOFkyCPdG', '', 'Олег', '', '2018-10-30 07:21:17', 'o.gaivoronsky@npcmr.ru1', '+7 (234) 523-45-23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
('sdfsdf', '$2y$10$lwMm/lMNjrMdPKemyhHFlum0TCfjSJEJ3.LZT.StX8vSEWUi0LLAS', '', 'asdasd', '', '2019-01-11 09:52:52', 'mail@mail.ru12', '+7 (123) 123-12-31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
('test', '$2y$10$r/5KS7C07UcF4FfUzpbqEebv5xQeoStcHN1ijKrOAyGiHb71bpWSe', 'asfdasdf', 'Олег', NULL, '2018-10-30 07:40:52', 'o.gaivoronsky@npcmr.ru12', '+7 (234) 523-45-23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
('test1', '$2y$10$fPL1orRrJl22e.OZbH.gYOhy12PU3KykACx1Tb7LdkZH2g2JAMbWm', '', 'Олег', '', '2019-01-11 09:49:35', 'mail12@mail.ru', '+7 (634) 563-45-63', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
('test111', '$2y$10$ueGGRMa/QCGatSczyrR/xupXTJOUnrNgL53FYA/ZnB08Up4KTrXha', 'Бенедиктов', 'Сигизмунд', 'Ральфович', '2019-03-28 09:19:55', 'npcmr-webinar@yandex.ru', '+7 (123) 123-12-31', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
('test123', '$2y$10$BF.ZZvWoAPQ7/1x6ng.ce.00sLD8LxAw5K55Kr0HYM.U5Ch2yd9c.', '', 'Олег', '', '2019-03-28 09:25:16', 'o.gaivoronsky@npcmr.ru1233', '+7(634) 563-45-63', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
('test123123', '$2y$10$wtZVd8BS6HEWj5lrOVbfr.bPbVn.Zcb0mWblrlhG0GFELd3yRp0Gm', '', 'Олег', '', '2018-10-30 08:15:50', 'o.gaivoronsky@npcmr.ru123', '+7 (234) 523-45-23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
('test123123123', '$2y$10$BAeUQGzfo5J0/LcQHxWgrODWBwj4Sty/AGOfJi2ND.wjgnLbKL8jG', '', 'Олег', '', '2019-03-28 09:31:53', 'o.gaivoronsky@npcmr.ru1231231233', '+7(634) 563-45-63', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
('test123123123123', '$2y$10$CKgFFzWE/aSGwa2dz1zQsOR7KQPT4VfT/2IcpO/CvK/x54b2vw2tK', '', 'Олег123123', '', '2019-03-28 09:34:02', 'mail@mail.ru123123', '+7(634) 563-45-63', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
('test1231233', '$2y$10$.vtgh9UcK1sjgoi24BBXpOuErcjCyeKxV5tYK6Kh7MGiOimedhbjO', '', 'Олег', '', '2019-03-28 09:26:45', 'o.gaivoronsky@npcmr.ru3123123', '+7(634) 563-45-63', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
('test12312333', '$2y$10$dvAT5rWcEybMp7Kb939mxexXOTCiZpu8MS9NeiUHzttqHeHKJBVA.', '', 'Олег', '', '2019-03-28 09:35:00', 'o.gaivoronsky@npcmr.ru123123123123', '+7(634) 563-45-63', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
('test133', '$2y$10$kwUar5ggGreLtYem6c5Di.zr2WMI32bNQ6SO25iN5fk7dJmZOr1v.', '', 'Олег', '', '2019-03-28 09:36:18', 'o.gaivoronsky@npcmr.ru3', '+7(634) 563-45-63', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
('test5', '$2y$10$bo7CheDw2n1gzQ9dIoREROkNg2m55xc/ILUgih5hoxHzK22Q3tnm.', '', 'Олег', '', '2019-03-28 09:37:35', 'o.gaivoronsky@npcmr.ru5', '+7(634) 563-45-63', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
('user1', '$2y$10$0vezvhGfZYhFLsrGssgJeOHRLmi4LKUESAVVs/I41esha4GxcLbWq', 'Сталин', 'Иосиф', 'Виссарионович', '2018-01-18 15:49:17', 'mail2@mail.ru', '+7 (123) 123-12-31', '+7 (234) 523-45-13', '1965-11-01', 'Москва', 'Врач', 'Высшее', NULL, '', 1),
('user2', '$2y$10$ZLkiV1N/wzma4K8WgA./ROJ7p8x91dFf5p4e7.r.bH5Q84dgyiemu', NULL, NULL, NULL, '2018-01-18 15:49:17', 'mail3@mail.ru', NULL, '+7 (234) 523-45-23', '1980-11-01', 'Москва', 'Врач', 'Высшее', NULL, '', 0),
('user3', '$2y$10$7wExLZYrEU4n4W.po.m/S.jXu8RyTe5sFLZMxhQmqJSF4DRdswQVi', NULL, NULL, NULL, '2018-04-20 11:37:00', 'mail4@mail.ru', NULL, '', '0000-00-00', '', '', '', NULL, '3590cb8af0bbb9e78c343b52b93773c9363b122c528f54df4a0446b6bab05515e1e1d3d40573127e9ee0480caf1283d6', 0),
('user4', '$2y$10$cOh8Boc.g2f4W6vIuaL3cOm8mhR5FOV2G2WRFgFL4APXPI6PiGjka', '', 'Веньямин', '', '2018-09-26 06:16:43', 'o.gaivoronsky@npcmr.ru', '+7 (123) 456-78-99', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `user_docs`
--

CREATE TABLE `user_docs` (
  `id` int(11) NOT NULL,
  `login_user` varchar(50) DEFAULT NULL,
  `doc_name` varchar(250) NOT NULL COMMENT 'Название прикрепленного документа, вводится хозяином документа',
  `doc_file` varchar(200) NOT NULL COMMENT 'Название файла на сервере',
  `dt_insert` timestamp NULL DEFAULT NULL COMMENT 'Дата/время прикрепления документа',
  `login_check` varchar(50) DEFAULT NULL COMMENT 'Логин человека, который проверил документы',
  `dt_check` timestamp NULL DEFAULT NULL COMMENT 'Дата, время проверки документа',
  `result_check` tinyint(4) DEFAULT NULL COMMENT '0 - отклонено, 1 - принято',
  `comment_check` varchar(255) DEFAULT NULL COMMENT 'Причина отклонения документа'
) ENGINE=InnoDB AVG_ROW_LENGTH=16384 DEFAULT CHARSET=utf8 COMMENT='Сканы документов пользователя';

--
-- Дамп данных таблицы `user_docs`
--

INSERT INTO `user_docs` (`id`, `login_user`, `doc_name`, `doc_file`, `dt_insert`, `login_check`, `dt_check`, `result_check`, `comment_check`) VALUES
(16, 'admin', 'Картинка 1', '/app/template/img/docs/admin/16.png', '2018-09-27 07:29:51', 'admin', '2018-09-28 07:21:36', 1, 'Хороший документ'),
(17, 'admin', 'Картинка 2', '/app/template/img/docs/admin/17.png', '2018-09-27 07:29:51', 'admin', '2018-09-28 07:50:40', 0, 'Липа'),
(18, 'admin', 'image 1', '/app/template/img/docs/admin/18.jpg', '2018-09-27 07:41:37', 'user1', '2018-09-28 08:43:06', 1, 'Хороший документ'),
(19, 'admin', 'image 2', '/app/template/img/docs/admin/19.jpg', '2018-09-27 07:41:37', 'user1', '2018-09-28 08:43:06', 1, 'Молодец'),
(20, 'admin', 'Паспорт', '/app/template/img/docs/admin/20.jpg', '2018-09-28 06:13:02', 'user1', '2018-09-28 08:43:06', 0, 'Не то!'),
(21, 'admin', 'Самое крутое образование', '/app/template/img/docs/admin/21.png', '2018-09-28 06:13:02', 'user1', '2018-09-28 08:43:06', 0, 'Подделка'),
(22, 'admin', 'Было и такое', '/app/template/img/docs/admin/22.jpg', '2018-09-28 06:13:02', 'user1', '2018-09-28 08:43:06', 0, 'Фальшивка'),
(23, 'admin', 'Время было сложное, пришлось и этим заняться ;)', '/app/template/img/docs/admin/23.jpg', '2018-09-28 06:13:02', 'user1', '2018-09-28 08:43:06', 1, 'Молодец'),
(24, 'user1', 'Документ об образовании 1', '/app/template/img/docs/user1/24.jpg', '2018-09-28 08:47:53', 'admin', '2018-09-28 09:06:17', 1, 'Хороший документ'),
(25, 'user1', 'Документ об образовании 2', '/app/template/img/docs/user1/25.jpg', '2018-09-28 08:47:53', 'admin', '2018-09-28 09:06:17', 0, 'Плохой документ'),
(26, 'user1', 'Документ об образовании 3', '/app/template/img/docs/user1/26.jpg', '2018-09-28 08:47:53', 'admin', '2018-10-02 13:40:39', 1, 'Молодец!'),
(27, 'user1', 'Гора', '/app/template/img/docs/user1/27.jpg', '2018-10-15 09:36:49', NULL, NULL, NULL, NULL),
(28, 'user1', 'Закат', '/app/template/img/docs/user1/28.jpg', '2018-10-15 09:36:49', NULL, NULL, NULL, NULL),
(29, 'user1', 'Лежит', '/app/template/img/docs/user1/29.jpg', '2018-10-15 09:42:20', NULL, NULL, NULL, NULL),
(30, 'user1', 'Заказт', '/app/template/img/docs/user1/30.jpg', '2018-10-15 09:59:25', NULL, NULL, NULL, NULL),
(31, 'admin', 'гора', '/app/template/img/docs/admin/31.jpg', '2018-10-15 10:00:12', NULL, NULL, NULL, NULL),
(32, 'admin', 'осень', '/app/template/img/docs/admin/32.jpg', '2018-10-15 10:00:12', NULL, NULL, NULL, NULL),
(33, 'user3', 'Документ', '/app/template/img/docs/user3/33.jpg', '2018-10-25 14:20:18', 'admin1', '2018-10-25 14:21:46', 1, 'Все правильно!'),
(34, 'user2', 'Лапы', '/app/template/img/docs/user2/34.jpg', '2018-11-06 07:50:13', 'admin', '2019-04-05 09:49:18', 1, 'пывап'),
(35, 'user2', 'Хвост', '/app/template/img/docs/user2/35.jpg', '2018-11-06 07:50:13', NULL, NULL, NULL, NULL),
(36, 'admin', 'asdfasdfasdf', '/app/template/img/docs/admin/36.jpg', '2019-01-25 10:06:14', NULL, NULL, NULL, NULL),
(37, 'admin', 'asddghfdghdfghdfgh', '/app/template/img/docs/admin/37.jpg', '2019-01-25 10:06:14', NULL, NULL, NULL, NULL),
(38, 'admin', 'dfghdfghdfgh', '/app/template/img/docs/admin/38.jpg', '2019-01-25 10:06:14', NULL, NULL, NULL, NULL),
(39, 'admin', 'fasdfasdf', '/app/template/img/docs/admin/39.jpg', '2019-01-28 07:25:20', NULL, NULL, NULL, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `access`
--
ALTER TABLE `access`
  ADD PRIMARY KEY (`user_login`,`role_name`),
  ADD KEY `FK_access_role_name` (`role_name`);

--
-- Индексы таблицы `attest`
--
ALTER TABLE `attest`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_attest_modality_id` (`modality_id`),
  ADD KEY `FK_attest_ssapm_id` (`ssapm_id`);

--
-- Индексы таблицы `attest_before`
--
ALTER TABLE `attest_before`
  ADD PRIMARY KEY (`attest_id`,`attest_id_before`),
  ADD KEY `FK_attest_before_attest_id_bef` (`attest_id_before`);

--
-- Индексы таблицы `attest_video`
--
ALTER TABLE `attest_video`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_attest_video_attest_id` (`attest_id`);

--
-- Индексы таблицы `black_list`
--
ALTER TABLE `black_list`
  ADD PRIMARY KEY (`login`);

--
-- Индексы таблицы `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_exam_result_id` (`result`),
  ADD KEY `FK_exam_attest_id` (`attest_id`),
  ADD KEY `FK_exam_login` (`login`),
  ADD KEY `FK_exam_state_id` (`state_id`);

--
-- Индексы таблицы `exam_check`
--
ALTER TABLE `exam_check`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `UK_exam_check` (`exam_id`,`login`);

--
-- Индексы таблицы `exam_image`
--
ALTER TABLE `exam_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_exam_image_exam_id` (`exam_id`);

--
-- Индексы таблицы `exam_image_result`
--
ALTER TABLE `exam_image_result`
  ADD PRIMARY KEY (`id`),
  ADD KEY `image_id` (`image_id`);

--
-- Индексы таблицы `exam_state`
--
ALTER TABLE `exam_state`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `expert_work`
--
ALTER TABLE `expert_work`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_expert` (`login`,`attest_id`),
  ADD KEY `FK_expert_attest_id` (`attest_id`);

--
-- Индексы таблицы `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `modality`
--
ALTER TABLE `modality`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`name`);

--
-- Индексы таблицы `sertif`
--
ALTER TABLE `sertif`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `setup`
--
ALTER TABLE `setup`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `ssapm`
--
ALTER TABLE `ssapm`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`login`);

--
-- Индексы таблицы `user_docs`
--
ALTER TABLE `user_docs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `attest`
--
ALTER TABLE `attest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `attest_video`
--
ALTER TABLE `attest_video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `exam`
--
ALTER TABLE `exam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `exam_check`
--
ALTER TABLE `exam_check`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `exam_image`
--
ALTER TABLE `exam_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `exam_image_result`
--
ALTER TABLE `exam_image_result`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `exam_state`
--
ALTER TABLE `exam_state`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `expert_work`
--
ALTER TABLE `expert_work`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `level`
--
ALTER TABLE `level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `modality`
--
ALTER TABLE `modality`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `page`
--
ALTER TABLE `page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `sertif`
--
ALTER TABLE `sertif`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT для таблицы `setup`
--
ALTER TABLE `setup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `ssapm`
--
ALTER TABLE `ssapm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `user_docs`
--
ALTER TABLE `user_docs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `access`
--
ALTER TABLE `access`
  ADD CONSTRAINT `FK_access_role_name` FOREIGN KEY (`role_name`) REFERENCES `role` (`name`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_access_user_login` FOREIGN KEY (`user_login`) REFERENCES `user` (`login`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `attest`
--
ALTER TABLE `attest`
  ADD CONSTRAINT `FK_attest_modality_id` FOREIGN KEY (`modality_id`) REFERENCES `modality` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_attest_ssapm_id` FOREIGN KEY (`ssapm_id`) REFERENCES `ssapm` (`id`) ON DELETE NO ACTION;

--
-- Ограничения внешнего ключа таблицы `attest_before`
--
ALTER TABLE `attest_before`
  ADD CONSTRAINT `FK_attest_before_attest_id` FOREIGN KEY (`attest_id`) REFERENCES `attest` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_attest_before_attest_id_bef` FOREIGN KEY (`attest_id_before`) REFERENCES `attest` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `attest_video`
--
ALTER TABLE `attest_video`
  ADD CONSTRAINT `FK_attest_video_attest_id` FOREIGN KEY (`attest_id`) REFERENCES `attest` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `black_list`
--
ALTER TABLE `black_list`
  ADD CONSTRAINT `FK_black_list_login` FOREIGN KEY (`login`) REFERENCES `user` (`login`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `exam`
--
ALTER TABLE `exam`
  ADD CONSTRAINT `FK_exam_attest_id` FOREIGN KEY (`attest_id`) REFERENCES `attest` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_exam_login` FOREIGN KEY (`login`) REFERENCES `user` (`login`) ON DELETE NO ACTION,
  ADD CONSTRAINT `FK_exam_state_id` FOREIGN KEY (`state_id`) REFERENCES `exam_state` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `exam_check`
--
ALTER TABLE `exam_check`
  ADD CONSTRAINT `exam_check_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`id`);

--
-- Ограничения внешнего ключа таблицы `exam_image`
--
ALTER TABLE `exam_image`
  ADD CONSTRAINT `FK_exam_image_exam_id` FOREIGN KEY (`exam_id`) REFERENCES `exam` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `exam_image_result`
--
ALTER TABLE `exam_image_result`
  ADD CONSTRAINT `exam_image_result_ibfk_1` FOREIGN KEY (`image_id`) REFERENCES `exam_image` (`id`);

--
-- Ограничения внешнего ключа таблицы `expert_work`
--
ALTER TABLE `expert_work`
  ADD CONSTRAINT `FK_expert_attest_id` FOREIGN KEY (`attest_id`) REFERENCES `attest` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_expert_login` FOREIGN KEY (`login`) REFERENCES `user` (`login`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
