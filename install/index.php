<?php
@error_reporting(E_ALL ^ E_NOTICE);
@ini_set('display_errors', false);
@ini_set('html_errors', false);
@ini_set('error_reporting', E_ALL ^ E_NOTICE);

echo '<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="shortcut icon" href="/favicon.ico"/>
<style>
body { background: #8ec1da url(/design/styles/default/style_images/bg.jpg) fixed; margin: 0 auto; max-width: 700px; font-size: 13px; color: #16223b; font-family: Arial; } a, a:link, a:active, a:visited { color: #39728a; text-decoration: none; } a:hover { text-decoration: none; } .headmenu, .foot { background: #24627b; } a.headmenulink { display: inline-block; padding: 12px; color: #bddeed; text-decoration: none; } a.headmenulink:hover { color: #f2fbff; background: #326c85 url(/design/styles/default/style_images/headmenulinkhover.gif) no-repeat bottom; } a.headbut { padding: 6px 12px; background: #3e7c96 url(/design/styles/default/style_images/aheadbut.gif) repeat-x top; color: #fff; margin: 0 4px; -khtml-border-radius: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px; border-radius: 3px; text-decoration: none; } a.headbut:hover { background: #5790a1 url(/design/styles/default/style_images/aheadbuthover.gif) repeat-x top; } .apicms_content{ background: #5790a1; color: #fff; padding: 10px; border-top: 1px solid #437e8f; border-bottom: 1px solid #6da1b0; } .apicms_menu{ background: #5790a1; color: #fff; padding: 10px; border-top: 1px solid #437e8f; border-bottom: 1px solid #6da1b0; } .descr{ background: #6b9dac; padding: 4px 8px; font-size: 12px; margin-top: 5px; -khtml-border-radius: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px; border-radius: 3px; border: 1px solid #4f899a; } .erors { color: #ffffff; padding:7px; background-color: #CC1559; text-align: center; border-top: 1px #ffffff solid; border-bottom: 1px #e8e8ea solid; display: block; } .newstitle { display: inline-block; background: #24627b; padding: 5px 10px; -khtml-border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; font-size: 14px; } .txt { margin: 3px; } .linksbar { } .linksbar a { display: inline-block; background: #efefef url(/design/styles/default/style_images/linksbara.gif) repeat-x top; margin: 3px 0; color: #24627b; padding: 6px 10px; -khtml-border-radius: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px; border-radius: 3px; text-decoration: none; } .linksbar a:hover { background: #d2e9ef url(/design/styles/default/style_images/linksbarahover.gif) repeat-x top; } .apicms_subhead { color: #39728a; padding:7px; background-color: #f5f5f5; border-top: 1px #ffffff solid; border-bottom: 1px #e8e8ea solid; display: block; } .apicms_subhead:hover { color: #2c5f75; padding:7px; background-color: #f1f1f1; border-top: 1px #ffffff solid; border-bottom: 1px #e8e8ea solid; display: block; } .apicms_titles { color: #39728a; padding:7px; background-color: #f5f5f5; border-top: 1px #ffffff solid; border-bottom: 1px #e8e8ea solid; display: block; } .apicms_menu_s{ color: #39728a; padding:7px; background-color: #f5f5f5; border-top: 1px #ffffff solid; border-bottom: 1px #e8e8ea solid; display: block; } .apicms_menu_s:hover{ color: #2c5f75; padding:7px; background-color: #f1f1f1; border-top: 1px #ffffff solid; border-bottom: 1px #e8e8ea solid; display: block; } .apicms_ads { color: #39728a; padding:7px; background-color: #f5f5f5; border-top: 1px #ffffff solid; border-bottom: 1px #e8e8ea solid; display: block; } .apicms_comms { color: #39728a; padding:7px; background-color: #f5f5f5; border-top: 1px #ffffff solid; border-bottom: 1px #e8e8ea solid; display: block; } .apicms_footer { color: #39728a; padding:7px; background-color: #f5f5f5; border-top: 1px #ffffff solid; border-bottom: 1px #e8e8ea solid; display: block; } .apicms_dialog{ background: #5790a1; color: #fff; padding: 10px; border-top: 1px solid #437e8f; border-bottom: 1px solid #6da1b0; } .loghead { padding: 12px; font-size: 12px; color: #ffffff; text-decoration: none; background: #326c85 url(/design/styles/default/style_images/foothover.gif) no-repeat top; } .logo { padding: 7px; font-size: 12px; color: #ffffff; text-decoration: none; background: #326c85; } .foot { text-align: right; } .foot a { display: inline-block; padding: 12px; font-size: 12px; color: #bddeed; text-decoration: none; } .foot a:hover { background: #326c85 url(/design/styles/default/style_images/foothover.gif) no-repeat top; color: #f2fbff; } form { padding: 0; margin: 0; } input, select, textarea { font-size: 13px; -khtml-border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px; background: #fff url(/design/styles/default/style_images/input.gif) repeat-x top; border: 1px solid #326d85; padding: 6px 10px; } input[type=submit],input[type=button] { background: #24627b url(/design/styles/default/style_images/inputbutton.gif) repeat-x top; border: 1px solid #24627b; color: #fff; } .class span { float: left; } img { vertical-align: middle; } table { font-size: 12px; }
</style>
<link rel="stylesheet" type="text/css" href="css/normalize.css" />
<script src="js/modernizr.custom.js"></script>
		<link rel="stylesheet" type="text/css" href="css/component.css" />
<title>Установка APICMS v.3.0</title>
</head>
<body>';
/////////////////////////////////////////
///////Установка Системы Управления//////
/////////////////////////////////////////
echo '<div class="logo"><a href="/"><center><img src="http://apicms.ru/design/styles/default/logo2.png"/></center></a></div>';
echo '<div class="apicms_ads">
<img src="/design/styles/default/images/reks.png" alt=""> <a href="http://apicms.ru"><small>Скачать модули для APICMS</small></a></div>';
echo '<div class="apicms_menu">Правила и информация по эксплуатации</div>


<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=cms.png></center></td><td width="80%">
Система управления сайтом <b>APICMS v.3.0</b> была разработана для распространения на <b>бесплатной</b> основе!
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=author.png></center></td><td width="80%">
<b>Автором</b> CMS является <b>Медянкин Евгений Николаевич</b> известный в сети под псевдонимом (ником) <b>Kyber</b>.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=if.png></center></td><td width="80%">
APICMS выпущена изначально как <b>ядро</b> для <b>общетематических сайтов</b>, <b>социальных сетей</b>, <b>блогов</b> и <b>контент сайтов</b>.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=md.png></center></td><td width="80%">
<b>CMS</b> выпускается <b>отдельно ядром</b>, модули к которому можно скачать на официальном сайте apicms.ru.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=sv.png></center></td><td width="80%">
В качестве уважения к разработчику CMS просим вас <b>не снимать копирайт</b> и рекламные ссылки или хотя бы оставить его на срок 30 суток.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=settings.png></center></td><td width="80%">
<b>Не приветствуется</b> выпуск <b>модификаций</b> с изменением кода <b>без копирайтов</b> и придержания авторства за Kyber и apicms.ru.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=notes.png></center></td><td width="80%">
<b>Запрещается</b> выпуск модификаций (<b>ядра</b>) <b>без</b> личного <b>согласования</b> с <b>автором</b> APICMS (за исключением выпуска дополнений к CMS).
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=mod.png></center></td><td width="80%">
<b>Советуем</b> скачивать <b>модули</b> для <b>APICMS</b> <b>только</b> <b>на</b> официальном сайте <b>apicms.ru</b>! В противном случае вы можете быть подвержены взлому вашего сайта или попаданию вирусов.
</td></tr></tbody></table></div>';

echo'<div class="apicms_menu">Встроенные модули в сборку</div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=network.png></center></td><td width="80%">
Системная часть (подключение к базе, базы ОС и т.п.).
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=cp.png></center></td><td width="80%">
Регистрация, Авторизация, Выход, Активация, Каптча.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=pas.png></center></td><td width="80%">
Изменение, восстановление пароля.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=in.png></center></td><td width="80%">
Анкета, изменение, блокировка.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=st.png></center></td><td width="80%">
Настройки аккаунта.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=dz.png></center></td><td width="80%">
Смена оформления.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=er.png></center></td><td width="80%">
Админ часть (расширенная).
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=msn.png></center></td><td width="80%">
Онлайн, список зарегистрированных, последняя регистрация.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=new.png></center></td><td width="80%">
Новости (Вывод, рассылка по email пользователей и т. д.).
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=re.png></center></td><td width="80%">
Реклама (верх и низ сайта).
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=sm.png></center></td><td width="80%">
Поддержка смайлов (установлено более 500 шт.).
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=foobar.png></center></td><td width="80%">
Загрузка аватаров (автор RSST).
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=ct.png></center></td><td width="80%">
Приватная почта.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=sc.png></center></td><td width="80%">
Двойная шифрация пароля, фильтрация для защиты сноса базы данных.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=we.png></center></td><td width="80%">
Легкое редактирование счетчиков и правил сайта.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=fz.png></center></td><td width="80%">
Форум, Мини-чат, Rss лента и гостевая книга.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=op.png></center></td><td width="80%">
Модуль системных оповещений.
</td></tr></tbody></table></div>';

echo'<div class="apicms_menu">Изменения</div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=dw.png></center></td><td width="80%">
Полностью переделанное ядро, теперь еще быстрее и проще.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=fe.png></center></td><td width="80%">
Изменен код на более простой.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=ew.png></center></td><td width="80%">
Часть вывода переведена в функции.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=zs.png></center></td><td width="80%">
Усовершенствована защита.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=sf.png></center></td><td width="80%">
Добавлены новые возможности.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=rd.png></center></td><td width="80%">
Полный редизайн CMS.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=bf.png></center></td><td width="80%">
Полный баг фикс CMS.
</td></tr></tbody></table></div>';

echo'<div class="apicms_menu">Действие</div>

<a href="install.php"><div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=sp.png></center></td><td width="80%">
Согласен с правилами и готов продолжить
</td></tr></tbody></table></div></a>';



echo'<div class="loghead"><center><small><a href="http://apicms.ru"><font color="FFFFFF"> <strong>Управление сайтом ApiCMS</strong></font></a></small></center></div>';
