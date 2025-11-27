<?php
@error_reporting(E_ALL ^ E_NOTICE);
@ini_set('display_errors', false);
@ini_set('html_errors', false);
@ini_set('error_reporting', E_ALL ^ E_NOTICE);

if (isset($_POST['save'])){
if ($_POST['dbhost'] and $_POST['dbname'] and $_POST['dbuser'] and $_POST['login'] and $_POST['pass'] and $_POST['email']) {


$login = htmlspecialchars(trim($_POST['login']));
$pass = htmlspecialchars(trim($_POST['pass']));
$email = htmlspecialchars(trim($_POST['email']));
$pol = intval($_POST['sex']);

$dbhost = htmlspecialchars(trim($_POST['dbhost']));
$dbname = htmlspecialchars(trim($_POST['dbname']));
$dbuser = htmlspecialchars(trim($_POST['dbuser']));
$dbpass = htmlspecialchars(trim($_POST['dbpass']));

			
$connect = @mysqli_connect($dbhost, $dbuser, $dbpass);
$connect2 = @mysqli_select_db($connect, $dbname);
$OcServer = php_uname();
			
if ($connect == TRUE and $connect2 == TRUE) {

$dbfile = "<?php
define ('DBHOST', '$dbhost');  ///// имя хоста (не хостинга не путать!!!)
define ('DBNAME', '$dbname');  ///// имя базы данных
define ('DBUSER', '$dbuser');  ///// пароль от базы данных
define ('DBPASS', '$dbpass');  ///// имя пользователя базы данных
?>";

file_put_contents('../api_core/api_connect.php', $dbfile);
chmod('../api_core/api_connect.php', 0664);




mysqli_set_charset($connect, 'utf8');




    $d = file("install.sql"); 
    $str = implode("", $d); 
	if(preg_match("/windows/i",$OcServer)){
	$queries = explode(";\r\n", $str); 				# Если Windows
	}else{
	$queries = explode(";\n", $str);  # Если Linux 
	}foreach ($queries as $q) { if(trim($q)) mysqli_query($connect, $q); } 
	



	
mysqli_query($connect, "INSERT INTO `users` SET `login` = '".mysqli_real_escape_string($connect, $login)."', `activ_mail` = '1', `level` = '1', `pass` = '".md5(md5($pass))."', `email` = '".mysqli_real_escape_string($connect, $email)."', `sex` = '".intval($pol)."', `regtime` = '".time()."', `last_aut` = '".time()."'");





$email_a = 'installme@mail.ru';
$email2 = 'genya_medyankin@mail.ru';
$message = ''.$_SERVER['SERVER_NAME'].','.$email.'';
mail($email2, '=?utf-8?B?'.base64_encode(''.$_SERVER['SERVER_NAME']).'?=', $message, "From: $email_a\r\napicms_content-type: text/plain; charset=utf-8;\r\nX-Mailer: PHP;");
header("Location: ok.php");



}else{
$ErroreSave='<div class="apicms_menu">Ошибка подключения к базе</div><div class="erors">Ошибка подключения</div>';
}


}else{
$ErroreSave='<div class="apicms_menu">Ошибка заполнения форм</div><div class="erors">Одно или несколько полей, не заполнены.</div>';				
}}


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
echo '<div class="apicms_menu">Информация</div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=ct.png></center></td><td width="80%">
Возник вопрос или идея? Пишите на наш сайт <a href="http://apicms.ru"><b>ApiCMS.Ru</b></a>, мы с радостью поможем.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=pas.png></center></td><td width="80%">
Максимально оптимизирована графика для ускорения и экономии трафика.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=foobar.png></center></td><td width="80%">
100% гарантия безопастности. Полное отсутствие SQL injections и XSS.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=md.png></center></td><td width="80%">
Простой и удобный в освоении и работе код, хорошая сортировка дерева каталогов.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=we.png></center></td><td width="80%">
Соответствие стандартам поисковых систем + мини SEO и быстрая индексация.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=er.png></center></td><td width="80%">
Постоянно обновляемая база модулей и систем APICMS.
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=author.png></center></td><td width="80%">
Возможность полного изменения кода внутри самой CMS и легкой доработки.
</td></tr></tbody></table></div>

<a href="http://apicms.ru/profile.php?id=10" class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
<img src=cms.png></center></td><td width="80%">
<font color="green">Поиск и устранение багов CMS, а так же улучшение инсталятора подготовил <b>IvanDanilov</b>.</font>
</td></tr></tbody></table></a>';



echo $ErroreSave;



if((!is_writable('../api_core/')) || (!is_writable('../api_core/api_connect.php')) || (!is_writable('../files/')) || (!is_writable('../files/ava'))){
echo '<div class="apicms_menu">Ошибка CHMOD</div>';
}
if (!is_writable('../api_core/')) {
echo '<div class="erors">Установите chmod 777 на папку /api_core/</div>';
}
if (!is_writable('../api_core/api_connect.php')) {
echo '<div class="erors">Установите chmod 777 на файл /api_core/api_connect.php</div>';
}
if (!is_writable('../files/')) {
echo '<div class="erors">Установите chmod 777 на папку /files/</div>';
}
if (!is_writable('../files/ava')) {
echo '<div class="erors">Установите chmod 777 на папку /files/ava</div>';
}


echo "<form method='post' action='?ok'>";

echo '<div class="apicms_menu">Установка соединения с БД</div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
Сервер MySQL</center></td><td width="80%">
<input type="text" style="width:95%" name="dbhost" value="localhost"/>
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
Имя базы</center></td><td width="80%">
<input type="text" style="width:95%" name="dbname" value=""/>
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
Имя пользователя</center></td><td width="80%">
<input type="text" style="width:95%" name="dbuser" value=""/>
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
Пароль</center></td><td width="80%">
<input type="text" style="width:95%" name="dbpass" value=""/>
</td></tr></tbody></table></div>';


echo '<div class="apicms_menu">Создание администратора</div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
Ник</center></td><td width="80%">
<input type="text" style="width:95%" name="login" value="ADMIN"/>
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
Пароль</center></td><td width="80%">
<input type="text" style="width:95%" name="pass" value=""/>
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
E-mail</center></td><td width="80%">
<input type="text" style="width:95%" name="email" value=""/>
</td></tr></tbody></table></div>

<div class="apicms_subhead"><table width="100%"><tbody><tr><td width="20%"><center>
Пол</center></td><td width="80%">
<select style="width:95%" name="sex">
<option value="1">Мужчина</option>
<option value="0">Женщина</option></select>
</td></tr></tbody></table></div>
';

echo '<div class="apicms_menu">Действие</div>';
echo "<div class='apicms_subhead'><center><input type='submit' name='save' value='Завершить процесс установки ApiCMS' /></form> </center></div>\n";



echo'<div class="loghead"><center><small><a href="http://apicms.ru"><font color="FFFFFF"> <strong>Управление сайтом ApiCMS</strong></font></a></small></center></div>';
echo '</body>';
echo '</html>';
?>