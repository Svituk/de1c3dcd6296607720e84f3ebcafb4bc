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
echo '<div class="apicms_menu">ApiCms успешно установлена! Ваш ждут</div>


<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=dz.png></center></td><td width="80%">
Приятный дизайн и интерфейс.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=cms.png></center></td><td width="80%">
Постоянные обновления, новые модули, дизайны и т. д.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=er.png></center></td><td width="80%">
Удобный и многофункциональный, готовый сайт.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=md.png></center></td><td width="80%">
Отзывчивая поддержка на официальном сайте <a href="http://apicms.ru">ApiCMS.ru</a>.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=author.png></center></td><td width="80%">
Понятный и лёгкий код, с множеством комментариев.
</td></tr></tbody></table></div>';

echo'<div class="apicms_menu">Справка</div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=ew.png></center></td><td width="80%">
Обязательно удалите папку install (Она вам больше не понадобится).
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=rd.png></center></td><td width="80%">
Произведите базовые настройки сайта в админ панели.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=sv.png></center></td><td width="80%">
Расскажите о своём сайте в нашем <a href="http://apicms.ru/catalog/"><b>каталоге</b></a>.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=pas.png></center></td><td width="80%">
Загляните в <a href="http://apicms.ru/shop/"><b>маркет</b> обновлений</a>.
</td></tr></tbody></table></div>';

echo'<div class="apicms_menu">Действие</div>

<a href="/index.php"><div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=sp.png></center></td><td width="80%">
Перейти на сайт сайт.
</td></tr></tbody></table></div></a>';



echo'<div class="loghead"><center><small><a href="http://apicms.ru"><font color="FFFFFF"> <strong>Управление сайтом ApiCMS</strong></font></a></small></center></div>';
