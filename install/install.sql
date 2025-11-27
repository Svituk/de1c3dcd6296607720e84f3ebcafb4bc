-- --------------------------------------------------------
--                  База данных ApiCMS                   --
-- --------------------------------------------------------



--
-- Структура таблицы `advertising`
--

CREATE TABLE IF NOT EXISTS `advertising` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `link` varchar(150) DEFAULT NULL,
  `time` int(100) NOT NULL,
  `mesto` int(10) NOT NULL,
  `id_user` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `advertising`
--

INSERT INTO `advertising` (`id`, `name`, `link`, `time`, `mesto`, `id_user`) VALUES
(1, 'Мульти - Партнерская Сеть', 'http://klybok.net', 2147483647, 1, '1'),
(2, 'Скачать модули для APICMS', 'http://apicms.ru', 2147483647, 1, '1'),
(3, 'Разработчик CMS', 'http://vk.com/vip_geka', 2147483647, 2, '1');

-- --------------------------------------------------------

--
-- Структура таблицы `api_forum_post`
--

CREATE TABLE IF NOT EXISTS `api_forum_post` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `text` varchar(10000) NOT NULL,
  `time` int(10) NOT NULL,
  `theme` int(30) NOT NULL,
  `id_user` int(50) DEFAULT NULL,
  `edit` enum('0','1') NOT NULL DEFAULT '0',
  `edit_time` int(30) DEFAULT NULL,
  `delete` enum('0','1') NOT NULL DEFAULT '0',
  `delete_time` int(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Структура таблицы `api_forum_razdel`
--

CREATE TABLE IF NOT EXISTS `api_forum_razdel` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(1024) NOT NULL,
  `opisanie` varchar(1024) DEFAULT NULL,
  `time` int(10) NOT NULL,
  `id_user` int(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Структура таблицы `api_forum_subforum`
--

CREATE TABLE IF NOT EXISTS `api_forum_subforum` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(1024) NOT NULL,
  `opisanie` varchar(1024) DEFAULT NULL,
  `time` int(10) NOT NULL,
  `razdel` int(30) NOT NULL,
  `id_user` int(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Структура таблицы `api_forum_theme`
--

CREATE TABLE IF NOT EXISTS `api_forum_theme` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(1024) NOT NULL,
  `text` varchar(10000) NOT NULL,
  `time` int(10) NOT NULL,
  `subforum` int(30) NOT NULL,
  `id_user` int(30) DEFAULT NULL,
  `close` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Структура таблицы `api_lib_article`
--

CREATE TABLE IF NOT EXISTS `api_lib_article` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `id_user` varchar(50) DEFAULT NULL,
  `name` varchar(1024) DEFAULT NULL,
  `text` mediumtext,
  `cat` int(30) DEFAULT NULL,
  `time` int(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Структура таблицы `api_lib_cat`
--

CREATE TABLE IF NOT EXISTS `api_lib_cat` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `id_user` varchar(50) DEFAULT NULL,
  `name` varchar(1024) DEFAULT NULL,
  `opis` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Структура таблицы `api_system`
--

CREATE TABLE IF NOT EXISTS `api_system` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `id_user` int(50) NOT NULL,
  `text` varchar(10000) NOT NULL,
  `time` int(50) NOT NULL,
  `read` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Структура таблицы `contact_list`
--

CREATE TABLE IF NOT EXISTS `contact_list` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `id_user` varchar(50) DEFAULT NULL,
  `time` int(100) NOT NULL,
  `my_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Структура таблицы `guest`
--

CREATE TABLE IF NOT EXISTS `guest` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `txt` varchar(1024) NOT NULL,
  `time` int(10) NOT NULL,
  `ip` varchar(50) DEFAULT NULL,
  `browser` varchar(200) DEFAULT NULL,
  `oc` varchar(300) DEFAULT NULL,
  `adm` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Структура таблицы `mini_chat`
--

CREATE TABLE IF NOT EXISTS `mini_chat` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `txt` varchar(1024) NOT NULL,
  `time` int(10) NOT NULL,
  `id_user` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `txt` varchar(1500) DEFAULT NULL,
  `time` int(100) NOT NULL,
  `id_user` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`id`, `name`, `txt`, `time`, `id_user`) VALUES
(1, 'APICMS v.3.0 Установлена!', 'Поздравляю с успешной установкой APICMS! Хочу напомнить что вы используете ядро, для создания полноценного сайта вам необходимо скачать и установить (бесплатные/платные) модули с официального сайта apicms.ru. Просим вас не снимать копирайт и рекламные ссылки в течении 30 суток с момента установки в качестве благодарности за бесплатную CMS. Желаю приятной работы и новых идей! Если у вас возникнут вопросы, мы с радостью поможем вам найти решение на официальном форуме поддержки apicms.ru/api_forum/ С уважением главный разработчик и дизайнер Евгений Медянкин (Kyber)', 1394241057, '1');

-- --------------------------------------------------------

--
-- Структура таблицы `news_comm`
--

CREATE TABLE IF NOT EXISTS `news_comm` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `id_news` int(50) NOT NULL,
  `txt` varchar(1024) NOT NULL,
  `time` int(10) NOT NULL,
  `id_user` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `news_main` enum('0','1') NOT NULL DEFAULT '1',
  `reg` enum('0','1') NOT NULL DEFAULT '0',
  `open_guest` enum('0','1') NOT NULL DEFAULT '1',
  `style` varchar(250) NOT NULL DEFAULT 'default',
  `set_diz` enum('0','1') NOT NULL DEFAULT '1', 
  `on_page` int(10) NOT NULL DEFAULT '10',
  `counters` varchar(2500) NOT NULL,
  `rules` varchar(10000) DEFAULT NULL,
  `title` varchar(75) DEFAULT NULL,
  `Keywords` varchar(180) DEFAULT NULL,
  `Description` varchar(180) DEFAULT NULL,
  `revisit` int(10) NOT NULL DEFAULT '60',
  `adm_mail` varchar(300) DEFAULT NULL,
  `fishka_chat` int(10) NOT NULL DEFAULT '1',
  `fishka_mail` int(10) NOT NULL DEFAULT '0',
  `fishka_n_comm` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`news_main`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `settings`
--

INSERT INTO `settings` (`news_main`, `reg`, `open_guest`, `style`, `on_page`, `counters`, `rules`, `title`, `Keywords`, `Description`, `revisit`, `adm_mail`, `fishka_chat`, `fishka_mail`, `fishka_n_comm`) VALUES
('1', '1', '1', 'default', 10, '', '', 'ApiCMS.Ru - Мобильное управление сайтом', 'CMS, система управления, двиг, APICMS, API', 'Бесплатная система управления сайтом APICMS от Kyber 2013', 60, 'admin@site.ru', 1, 1, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `smiles_list`
--

CREATE TABLE IF NOT EXISTS `smiles_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(11) NOT NULL,
  `id_dir` int(50) NOT NULL,
  `sim` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=532 ;

--
-- Дамп данных таблицы `smiles_list`
--

INSERT INTO `smiles_list` (`id`, `name`, `id_dir`, `sim`) VALUES
(5, 'lips', 2, ':-*'),
(6, 'tongue', 2, ':-p'),
(7, 'dovolen', 2, ':]]'),
(8, 'biggrin', 2, ':-D'),
(9, 'biggrin2', 2, '=))'),
(10, 'hm', 2, ':-/'),
(11, 'smile', 2, ':-)'),
(12, 'sad', 2, ':-('),
(13, 'poh', 2, '8-)'),
(14, 'wink', 2, ';-)'),
(15, 'eqr', 2, '=]'),
(16, 'dance', 3, '.дансе.'),
(17, 'binok', 3, '.бинок.'),
(18, 'bolen', 3, '.болен.'),
(19, 'chit', 3, '.чит.'),
(20, 'chit2', 3, '.чит2.'),
(21, 'chit3', 3, '.чит3.'),
(22, 'dozhd', 3, '.дожд.'),
(23, 'draznilka', 3, '.дразнилка.'),
(24, 'druzhba', 3, '.дружба.'),
(25, 'duw', 3, '.душ.'),
(26, 'edu', 3, '.еду.'),
(27, 'pistoleta2', 6, '.пистолета2.'),
(28, 'fotograf', 3, '.фотограф.'),
(29, 'hudozh', 3, '.худож.'),
(30, 'igra', 3, '.игра.'),
(31, 'igra2', 3, '.игра2.'),
(32, 'karty', 3, '.карты.'),
(33, 'kompolom', 3, '.комполом.'),
(34, 'atata', 6, '.атата.'),
(35, 'draka', 6, '.драка.'),
(36, 'vinsent', 6, '.мафиози.'),
(37, 'zakosu', 6, '.закосу.'),
(38, 'vis', 6, '.вис.'),
(39, 'vis2', 6, '.вис2.'),
(40, '', 0, ''),
(41, 'kovyr2', 3, '.ковыр2.'),
(42, 'krug', 3, '.круг.'),
(43, 'kuku', 3, '.куку.'),
(44, 'kuku2', 3, '.куку2.'),
(45, 'kur', 3, '.кур.'),
(46, 'lak', 3, '.лак.'),
(47, 'mob', 3, '.моб.'),
(49, 'night', 3, '.ноч.'),
(50, '', 0, ''),
(51, 'piosmok', 3, '.пиосмок.'),
(52, 'spicy', 3, '.спицы.'),
(53, 'tomat', 3, '.томат.'),
(54, 'zasyp', 3, '.засып.'),
(55, 'zawtoroj', 3, '.зашторой.'),
(56, 'zerkalo', 3, 'зеркало.'),
(57, 'zerkalo2', 3, '.зеркало2.'),
(58, 'zevaet', 3, '.зевает.'),
(59, 'zubch', 3, '.зубч.'),
(60, 'zvezdy', 3, '.звезды.'),
(61, 'kofe', 3, '.кофе.'),
(62, 'kach', 3, '.качаюсь.'),
(63, 'strela', 3, '.стрела.'),
(64, 'ubi', 3, '.самоубица.'),
(65, 'gud', 3, '.пляж.'),
(66, 'jazyk', 3, '.язык.'),
(67, 'koldun', 3, '.колдун.'),
(68, 'botan', 3, '.ботан.'),
(69, 'truby', 3, '.трубы.'),
(70, 'poves', 3, '.повесился.'),
(71, 'drel', 3, '.дрель.'),
(72, 'sleep', 3, '.сплю.'),
(73, 'hrjas', 6, '.хрясь.'),
(74, 'akula', 4, '.акула.'),
(75, 'chervyak', 4, '.червяк.'),
(76, 'cyplenok', 4, '.цыпленок.'),
(77, 'kisa', 4, '.киса.'),
(78, 'korova', 4, '.корова.'),
(79, 'kot', 4, '.кот.'),
(80, 'krolik', 4, '.кролик.'),
(81, 'morkovka', 4, '.морковка.'),
(82, 'maus', 4, '.мышка.'),
(83, 'pauk', 4, '.паук.'),
(84, 'pingvenok', 4, '.пингвин.'),
(85, '', 0, ''),
(86, 'rybka', 4, '.рыбка.'),
(87, 'rybka2', 4, '.рыбка2.'),
(88, 'slon', 4, '.слон.'),
(89, 'slonik', 4, '.слоник.'),
(90, 'sobaka', 4, '.собака.'),
(91, 'ulitka', 4, '.улитка.'),
(92, 'zhaba', 4, '.жаба.'),
(93, 'zhuk', 4, '.жук.'),
(94, 'angel', 5, '.ангел.'),
(95, 'angel2', 5, '.ангел2.'),
(96, 'cherep', 5, '.череп.'),
(97, 'devil', 5, '.девил.'),
(98, 'ispug', 5, '.испуг.'),
(99, 'mertvec', 5, '.мертвец.'),
(100, 'molitva', 5, '.молитва.'),
(101, 'neangel', 5, '.неангел.'),
(102, 'skosoj', 5, '.скосой.'),
(103, 'vampir', 5, '.вампир.'),
(104, 'vedqma', 5, '.ведма.'),
(105, '2pistoleta', 6, '.2пистолета.'),
(106, 'asasin', 6, '.асасин.'),
(107, 'bomba', 6, '.бомба.'),
(108, 'granatomet', 6, '.гранатомет.'),
(109, 'lowadka', 6, '.лошадка.'),
(110, 'bomba', 6, '.бомба.'),
(111, 'nozh', 6, '.нож.'),
(112, 'orc', 6, '.орк.'),
(113, 'palach', 6, '.палач.'),
(114, 'paladin', 6, '.паладин.'),
(115, 'popope', 6, '.попопе.'),
(116, 'puwki2', 6, '.пушки.'),
(117, 'russoldat', 6, '.руссолдат.'),
(118, 'star', 6, '.стар.'),
(119, 'strelok', 6, '.стрелок.'),
(120, 'varvar', 6, '.варвар.'),
(121, 'nakazan', 6, '.наказан.'),
(122, 'vglaz', 6, '.вглаз.'),
(123, 'viselica', 6, '.виселица.'),
(124, 'benzopila', 6, '.бензопила.'),
(125, 'bita', 6, '.бита.'),
(126, 'molotkom', 6, '.молотком.'),
(127, 'karate', 6, '.каратэ.'),
(128, 'pogolove', 6, '.поголове.'),
(129, 'box', 6, '.бокс.'),
(130, 'zdayus', 6, '.сдаюсь.'),
(131, 'alkawi', 7, '.алкаши.'),
(132, 'arbuz', 7, '.арбуз.'),
(133, 'bokaly', 7, '.бокалы.'),
(134, 'butylki', 7, '.бутылки.'),
(135, 'stakan', 7, '.стакан.'),
(136, 'koktel', 7, '.коктель.'),
(137, 'kruzhki', 7, '.кружки.'),
(138, 'ledenec', 7, '.леденец.'),
(139, 'morozhenoe', 7, '.мороженое.'),
(140, 'napitok', 7, '.напиток.'),
(141, 'oguryum', 7, '.огурюм.'),
(142, 'pizza', 7, '.пицца.'),
(143, 'pil', 7, '.пил.'),
(144, 'pila', 7, '.пила.'),
(145, 'pivo', 7, '.пиво.'),
(146, 'konfeta', 7, '.конфета.'),
(147, 'woko', 7, '.шоко.'),
(148, 'povar', 7, '.повар.'),
(149, 'rybu', 7, '.рыбу.'),
(150, 'tort', 7, '.торт.'),
(151, 'vilka_nozh', 7, '.вилка_нож.'),
(152, 'vino', 7, '.вино.'),
(153, 'wampanskoe', 7, '.шампанское.'),
(154, 'alkogolik', 8, '.алкоголик.'),
(155, 'fokus', 8, '.фокус.'),
(156, 'gudok', 8, '.гудок.'),
(157, 'idiot', 8, '.идиот.'),
(158, 'ik', 8, '.ик.'),
(159, 'yazyk', 8, '.язык.'),
(160, 'kofein', 8, '.кофеин.'),
(161, 'malyw', 8, '.малыш.'),
(162, 'nark', 8, '.нарик.'),
(163, 'pifpaf', 8, '.пифпаф.'),
(164, 'pilot', 8, '.пилот.'),
(165, 'yad', 8, '.яд.'),
(166, 'pilotidiot', 8, '.пилотидиот.'),
(167, 'rusruletka', 8, '.русрулетка.'),
(168, 'suicid', 8, '.суицид.'),
(169, 'suicid2', 8, '.суицид2.'),
(170, 'telefon', 8, '.телефон.'),
(171, 'tormoz', 8, '.тормоз.'),
(172, 'vonyuchka', 8, '.вонючка.'),
(173, 'wutnik', 8, '.шутник.'),
(174, 'glaza', 9, '.глаза.'),
(175, 'aaa', 9, '.ааа.'),
(176, 'ah', 9, '.ах.'),
(177, 'bis', 9, '.бис.'),
(178, 'blabla', 9, '.блабла.'),
(179, 'blabla2', 9, '.блабла2.'),
(180, 'bur2', 9, '.бур2.'),
(181, 'dovolen2', 9, '.доволен2.'),
(182, 'dum', 9, '.дум.'),
(183, 'figase', 9, '.фигасе.'),
(184, 'fing', 9, '.фингал.'),
(185, 'fu', 9, '.фу.'),
(186, 'fuu', 9, '.фуу.'),
(187, 'gordo', 9, '.гордо.'),
(188, 'gy', 9, '.гы.'),
(189, 'gyy', 9, '.гыы.'),
(190, 'haha', 9, '.хаха.'),
(191, 'hnyk', 9, '.хнык.'),
(192, 'idea', 9, '.идея.'),
(193, 'isterika', 9, '.истерика.'),
(194, 'jahu', 9, '.яху.'),
(195, 'jeh2', 9, '.эх.'),
(196, 'krasn', 9, '.красн.'),
(197, 'cool', 9, '.кул4.'),
(198, 'lol', 9, '.лол.'),
(199, 'lol2', 9, '.лол2.'),
(200, 'mat', 9, '.мат.'),
(201, 'mda', 9, '.мда.'),
(203, 'nevozm', 9, '.невозм.'),
(204, 'nifiga', 9, '.нифига.'),
(205, 'novichek', 9, '.новичек.'),
(206, 'nyam', 9, '.ням.'),
(207, 'or', 9, '.ор.'),
(208, 'pardon', 9, '.пардон.'),
(209, 'pardon2', 9, '.пардон2.'),
(210, 'pasiba', 9, '.пасиба.'),
(211, 'plachet', 9, '.плачет.'),
(212, 'plak', 9, '.плак.'),
(213, 'plaksa', 9, '.плакса.'),
(214, 'plushit', 9, '.плющит.'),
(215, 'helpme', 9, '.помогите.'),
(216, 'prelest', 9, '.прелесть.'),
(217, 'razmaz', 9, '.размаз.'),
(218, 'rzhu', 9, '.ржу.'),
(219, 'sarkastik', 9, '.саркастик.'),
(220, 'sarkastik2', 9, '.саркастик2.'),
(221, 'acute', 9, '.смех.'),
(222, 'smeh2', 9, '.смех2.'),
(223, 'sorri', 9, '.сорри.'),
(224, 'dash1', 9, '.стена.'),
(225, 'dash2', 9, '.стена1.'),
(226, 'dash3', 9, '.стена2.'),
(227, 'svist', 9, '.свист.'),
(228, 'tanz', 9, '.танц.'),
(229, 'ukaz', 9, '.указ.'),
(230, 'vopros', 9, '.вопрос.'),
(231, 'yeh', 9, '.вздох.'),
(232, 'wutka', 9, '.шутка.'),
(233, 'zharko', 9, '.жарко.'),
(234, 'zloj', 9, '.злой.'),
(235, '2pal', 10, '.2пал.'),
(236, 'apl', 10, '.апл.'),
(237, 'bezpaniki', 10, '.безпаники.'),
(238, 'yes', 10, '.ес.'),
(239, 'figa', 10, '.фига.'),
(240, 'figa2', 10, '.фига2.'),
(241, 'hlopaet', 10, '.хлопает.'),
(242, 'horow', 10, '.хорош.'),
(243, 'kul', 10, '.кул.'),
(244, 'kul2', 10, '.кул2.'),
(245, 'kul3', 10, '.кул3.'),
(246, 'lapa', 10, '.лапа.'),
(247, 'nea', 10, '.неа.'),
(248, 'nenado', 10, '.ненадо.'),
(249, 'neochem', 10, '.неочем.'),
(250, 'neya', 10, '.нея.'),
(251, 'neznaet', 10, '.хз.'),
(252, 'ok', 10, '.ок.'),
(253, 'ploho', 10, '.плохо.'),
(254, 'poklon', 10, '.поклон.'),
(255, 'pora', 10, '.пора.'),
(256, 'preved', 10, '.превед.'),
(257, 'privet', 10, '.привет.'),
(258, 'pryatki', 10, '.прятки.'),
(259, 'reverans', 10, '.реверанс.'),
(260, 'sumas', 10, '.сумас.'),
(261, 'sumas2', 10, '.сумас2.'),
(262, 'zhopa', 10, '.жопа.'),
(263, '2serdca', 11, '.2сердца.'),
(264, 'banany', 11, '.бананы.'),
(265, 'chmak', 11, '.чмак.'),
(266, 'chmok', 11, '.чмок.'),
(267, 'chmok2', 11, '.чмок2.'),
(268, 'd', 11, '.д.'),
(269, 'angel3', 11, '.ангел3.'),
(270, 'daryserd', 11, '.дарюсерд.'),
(271, 'feministka', 11, '.феминистка.'),
(272, 'flirt', 11, '.флирт.'),
(273, 'gadaet', 11, '.гадает.'),
(274, 'inlav', 11, '.инлав.'),
(275, 'inlove', 11, '.инлове.'),
(276, 'kruzhit', 11, '.кружит.'),
(277, 'lapuwka', 11, '.лапушка.'),
(278, 'lesbi', 11, '.лесби.'),
(279, 'm', 11, '.м.'),
(280, 'manjuta', 11, '.манюта.'),
(281, 'netlyub', 11, '.нетлюб.'),
(282, 'nravitsya', 11, '.нравится.'),
(283, 'obozhayu', 11, '.обожаю.'),
(284, 'pink', 11, '.пинк.'),
(285, 'kiss2', 11, '.поц2.'),
(286, 'kiss3', 11, '.поц3.'),
(287, 'lips', 11, '.поц.'),
(288, 'pwag', 11, '.пшаг.'),
(289, 'seks', 11, '.секс.'),
(290, 'seks2', 11, '.секс2.'),
(291, 'serdce', 11, '.сердце.'),
(292, 'serdce2', 11, '.сердце2.'),
(293, 'serenada', 11, '.серенада.'),
(294, 'stesnit', 11, '.стеснит.'),
(295, 'stesnit2', 11, '.стеснит2.'),
(296, 'strela2', 11, '.стрела2.'),
(297, 'vkusna', 11, '.вкусна.'),
(298, 'vruku', 11, '.вруку.'),
(299, 'lov', 11, '.7небо.'),
(300, 'lju', 11, '.лю.'),
(301, 'love', 11, '.лобовь.'),
(302, 'obnimki', 11, '.обнимки.'),
(304, 'risuet', 11, '.рисует.'),
(305, 'vozdp', 11, '.воздп.'),
(306, 'vzasos', 11, '.взасос.'),
(307, 'miwka', 11, '.мишка.'),
(308, 'lasso', 11, '.тянет.'),
(309, 'kiddi', 11, '.дите.'),
(310, 'bajan2', 12, '.баян.'),
(311, 'baraban', 12, '.барабан.'),
(312, 'disko2', 12, '.диско2.'),
(313, 'disko3', 12, '.диско3.'),
(314, 'disko', 12, '.диско.'),
(315, 'dj', 12, '.дж.'),
(316, 'harp', 12, '.арфа.'),
(317, 'muzon', 12, '.музон.'),
(318, 'pank', 12, '.панк.'),
(320, 'skripka', 12, '.скрипка.'),
(321, 'stereo', 12, '.стерео.'),
(322, 'truba4', 12, '.труба4.'),
(323, 'noty', 12, 'ноты'),
(324, 'rojal', 12, '.рояль.'),
(325, 'gitara', 12, '.гитара.'),
(326, 'gitara2', 12, '.гитара2.'),
(327, 'gitara3', 12, '.гитара3.'),
(328, 'gitara4', 12, '.гитара4.'),
(329, 'gitara5', 12, 'гитара5.'),
(330, 'icq', 13, '.ася.'),
(331, 'baj', 13, '.бай.'),
(332, 'kiss', 13, '.кисс.'),
(333, 'kleva', 13, '.клева.'),
(334, 'super', 13, '.супер.'),
(335, 'vsempr', 13, '.всемпр.'),
(336, 'vt', 13, '.тапком.'),
(337, 'translit', 13, '.транслит.'),
(338, 'yy', 13, '.ыы.'),
(339, 'lol3', 13, '.лол3.'),
(340, 'owibochka', 13, '.ошибка.'),
(341, 'gugl', 13, '.гугл.'),
(342, 'ps', 13, '.пс.'),
(344, 'russkij', 13, '.русский.'),
(345, 'servis', 13, '.сервис.'),
(346, 'ban', 13, '.бан.'),
(347, 'Moder1', 13, '.спам.'),
(348, 'Moder3', 13, '.джд.'),
(349, 'ops', 13, '.упс.'),
(350, 'perv', 13, '.перв.'),
(351, 'pravila', 13, '.павила.'),
(352, 'tLol', 13, '.лол2.'),
(353, 'welcome', 13, '.дпож.'),
(354, 'new', 13, '.нев.'),
(355, 'boss', 14, '.босс.'),
(356, 'buba', 14, '.джигит.'),
(357, 'chebur', 14, '.чебур.'),
(358, 'chel', 14, '.чел.'),
(359, 'darov', 14, '.даров.'),
(360, 'dev', 14, '.дев.'),
(361, 'dev2', 14, '.дев2.'),
(362, 'evrej', 14, '.еврей.'),
(363, 'kanabis', 14, '.канабис.'),
(364, 'kloun', 14, '.клоун.'),
(365, 'kolyaska', 14, '.коляска.'),
(366, 'comando', 14, '.командо.'),
(367, 'comando2', 14, '.командо2.'),
(368, 'korol', 14, '.корол.'),
(369, 'korol2', 14, '.корол2.'),
(370, 'korol3', 14, '.корол3.'),
(371, 'krut', 14, '.крут.'),
(372, 'kurit', 14, '.курит.'),
(373, 'larisu', 14, '.ларису.'),
(374, 'letaet', 14, '.летает.'),
(375, 'mafiya', 14, '.мафия.'),
(376, 'mag', 14, '.маг.'),
(377, 'ment', 14, '.мент.'),
(378, 'nakone', 14, '.наконе.'),
(379, 'neo', 14, '.нео.'),
(380, 'nitki', 14, '.нитки.'),
(381, 'novrus', 14, '.новрус.'),
(382, 'pioner', 14, '.пионер.'),
(383, 'pirat', 14, '.пират.'),
(384, 'pirat2', 14, '.пират2.'),
(385, 'poryadok', 14, '.порядок.'),
(386, 'princesa', 14, '.принцесса.'),
(387, 'princesa2', 14, '.принцесса2.'),
(388, 'priwel', 14, '.пришел.'),
(389, 'rap', 14, '.реп.'),
(390, 'pogran', 14, '.погран.'),
(391, 'soldat', 14, '.солдат.'),
(392, 'triniti', 14, '.тринити.'),
(393, 'ukr', 14, '.укр.'),
(394, 'ukr2', 14, '.укр2.'),
(395, 'usa', 14, '.сша.'),
(396, 'zk', 14, '.зк.'),
(397, 'ded', 15, '.дед.'),
(398, 'ded_moroz', 15, '.дед_мороз.'),
(399, 'ded_snegur2', 15, '.дед_снегурка.'),
(400, 'newyear', 15, '.новгод.'),
(401, 'santa', 15, '.санта.'),
(402, 'santa2', 15, '.санта2.'),
(403, 'santa3', 15, '.санта3.'),
(404, 'snegur', 15, '.снегур.'),
(405, 'snezhok', 15, '.снежок.'),
(406, 'xmas2', 15, '.нг.'),
(407, 'zima', 15, '.зима.'),
(408, 'elka', 15, '.елка.'),
(409, 'wummi', 16, '.формула1.'),
(410, 'moto', 16, '.мото.'),
(411, 'samolet', 16, '.самолет.'),
(412, 'skuter', 16, '.скутер.'),
(413, 'velo', 16, '.велоc.'),
(414, 'parovoz2', 16, '.паровоз.'),
(415, 'tachka', 16, '.тачка.'),
(416, 'bt', 17, '.бт.'),
(417, 'id', 17, '.ид.'),
(418, 'irda', 17, '.ирда.'),
(419, 'java', 17, '.ява.'),
(420, 'arrow', 17, '.стрелка.'),
(421, 'q', 17, '.вопр.'),
(422, 'voskl', 17, '.воскл.'),
(423, 'xp', 17, '.винда.'),
(424, 'java2', 17, '.ява2.'),
(425, 'opera', 17, '.опера.'),
(426, 'opera2', 17, '.опера2.'),
(427, 'se', 17, '.се.'),
(428, 'seanim', 17, '.се2.'),
(429, 'w', 17, '.в.'),
(430, 'cvetok4', 18, '.дарюрозу'),
(431, 'romawki', 18, '.ромашки.'),
(432, 'roza', 18, '.роза.'),
(433, 'roza2', 18, '.роза2.'),
(434, 'roza3', 18, '.роза3.'),
(435, 'roza4', 18, '.роза4.'),
(436, 'roza5', 18, '.роза5.'),
(437, 'roza6', 18, '.роза6.'),
(438, 'roza7', 18, '.роза7.'),
(439, 'roza8', 18, '.роза8.'),
(440, 'roza9', 18, '.роза9.'),
(441, 'roza10', 18, '.роза10.'),
(442, 'anjutki', 18, '.анютки.'),
(443, 'tjulpan', 18, '.тюльпан.'),
(444, 'cvetok', 18, '.цветок.'),
(445, 'cvetok2', 18, '.цветок2.'),
(446, 'cvetok3', 18, '.цветок3.'),
(447, 'cvetok0', 18, '.цветок4.'),
(448, 'cvetok5', 18, '.цветок5.'),
(449, 'cvetok6', 18, '.цветок6.'),
(450, 'cvetok7', 18, '.цветок7.'),
(451, 'cvetok8', 18, 'cvetok8'),
(452, 'kyban', 19, '.кубань.'),
(453, 'cska', 19, '.цска.'),
(454, 'loko', 19, '.локо.'),
(455, 'dinamo', 19, '.динамо.'),
(456, 'zenit', 19, '.зенит.'),
(457, 'amkar', 19, '.амкар.'),
(458, 'rybin', 19, '.рубин.'),
(459, 'rostov', 19, '.ростов.'),
(460, 'spam', 19, '.спартак.'),
(461, 'moscow', 19, '.москва.'),
(462, 'satyrn', 19, '.сатурн.'),
(463, 'himki', 19, '.химки.'),
(464, 'mjach', 19, '.мяч.'),
(465, 'basket', 19, '.баскет.'),
(466, 'nhl', 19, '.хоккей.'),
(467, 'bobslej', 19, '.бобслей.'),
(468, 'bodibild', 19, '.бодибилд.'),
(469, 'aikido', 19, '.айкидо.'),
(470, 'wtanga', 19, '.штанга.'),
(471, 'fanaty', 19, '.фанаты.'),
(472, 'boks', 19, '.бокс.'),
(473, 'beg', 19, '.бег.'),
(474, 'best', 19, '.10балов.'),
(476, 'ganteli', 19, '.гантели.'),
(477, 'ganteli2', 19, '.гантели2.'),
(478, 'lyzhi', 19, '.лыжи.'),
(479, 'olimp', 19, '.олимп.'),
(480, 'obruch', 19, '.обруч.'),
(481, 'plavaet', 19, '.плавает.'),
(482, 'rybalka', 19, '.рыбалка.'),
(483, 'serfing', 19, '.серфинг.'),
(484, 'tennis', 19, '.теннис.'),
(485, 'tennis2', 19, '.теннис2.'),
(486, 'trening', 19, '.тренинг.'),
(487, 'velo2', 19, '.вело2.'),
(488, 'vodolaz', 19, '.водолаз.'),
(489, 'wtanga2', 19, '.штанга2.'),
(490, 'wtanga3', 19, '.штанга3.'),
(491, '', 0, ''),
(492, '', 0, ''),
(493, 'mnogobukav', 20, '.многабукф.'),
(494, 'niasilil', 20, '.ниасилил.'),
(495, 'pazitiv', 20, '.пазитиф.'),
(496, 'vgazenwagen', 20, '.вгазенваген.'),
(497, 'nichotak', 20, '.ничотак.'),
(498, 'okpelotka', 20, '.окпелотка.'),
(499, 'niasilil2', 20, '.ниасилил2.'),
(500, 'ahtung', 20, '.ахтунг.'),
(501, 'vypejyadu', 20, '.выпеййаду.'),
(502, 'komradrespe', 20, '.камрад.'),
(503, 'poradoval', 20, '.порадовал.'),
(504, 'nizachot', 20, '.низачет.'),
(505, 'vbobrujsk', 20, '.вбобруйск.'),
(506, 'ftopku', 20, '.фтопку.'),
(507, 'fdisyatke', 20, '.фдисятке.'),
(508, 'rjunimagu', 20, '.ржунимагу.'),
(509, 'kisaku', 20, '.кисакуку.'),
(510, 'dajtedv', 20, '.дайтедва.'),
(511, 'kgam', 20, '.кгам.'),
(512, 'kvsmile', 21, 'kvsmile'),
(513, 'kvsad', 21, 'kvsad'),
(514, 'kvbiggrin', 21, 'kvbiggrin'),
(515, 'kvwink', 21, 'kvwink'),
(516, 'kvbiggrin2', 21, 'kvbiggrin2'),
(517, 'kvpoh', 21, 'kvpoh'),
(518, 'kvtongue', 21, 'kvtongue'),
(519, 'facepalm', 22, 'facepalm'),
(520, 'vk_lol', 22, 'vk_lol'),
(521, 'vk_troll', 22, 'vk_troll'),
(522, 'mmm', 22, 'mmm'),
(523, 'pfff', 22, 'pfff'),
(524, 'jaki', 22, 'jaki'),
(525, 'bleat', 22, 'bleat'),
(526, 'xmm', 22, 'xmm'),
(527, 'fuuu', 22, 'fuuu'),
(528, 'vk_hhh', 22, 'vk_hhh'),
(529, 'mister', 22, 'mister'),
(530, 'ololoev', 22, 'ololoev'),
(531, 'bloo', 22, 'bloo');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `login` varchar(12) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `activ_mail` varchar(32) DEFAULT NULL,
  `fishka` int(100) NOT NULL DEFAULT '0',
  `rating` varchar(10000) NOT NULL DEFAULT '0',
  `pass` varchar(32) DEFAULT NULL,
  `level` enum('0','1','2') NOT NULL DEFAULT '0',
  `sex` int(1) NOT NULL DEFAULT '0',
  `name` varchar(300) DEFAULT NULL,
  `surname` varchar(300) DEFAULT NULL,
  `country` varchar(300) DEFAULT NULL,
  `city` varchar(300) DEFAULT NULL,
  `block_time` int(50) DEFAULT NULL,
  `block_count` int(50) NOT NULL DEFAULT '0',
  `regtime` int(30) DEFAULT NULL,
  `last_aut` int(30) DEFAULT NULL,
  `activity` int(50) DEFAULT NULL,
  `style` varchar(250) NOT NULL DEFAULT 'default',
  `ip` varchar(300) DEFAULT NULL,
  `browser` varchar(300) DEFAULT NULL,
  `oc` varchar(300) DEFAULT NULL,
  `my_place` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users_ban`
--

CREATE TABLE IF NOT EXISTS `users_ban` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `prich` varchar(500) NOT NULL,
  `ank_ban` int(50) NOT NULL,
  `time` int(10) NOT NULL,
  `id_user` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `user_mail`
--

CREATE TABLE IF NOT EXISTS `user_mail` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `id_sender` int(50) NOT NULL,
  `id_recipient` int(50) NOT NULL,
  `txt` varchar(1024) NOT NULL,
  `time` int(50) NOT NULL,
  `views` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
