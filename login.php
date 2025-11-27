<?php

require_once 'api_core/apicms_system.php';
////////////////////////////////////////
if (empty($_GET['log']) and empty($_GET['pas'])){
	$login = apicms_filter($_POST['login']);
	$pass = md5(md5(apicms_filter($_POST['pass'])));
}else{
	$login = apicms_filter($_GET['log']);
	$pass = md5(md5(apicms_filter($_GET['pas'])));
}
////////////////////////////////////////
global $connect;
$query = mysqli_query($connect, "SELECT `login` FROM `users` WHERE `login` = '$login' and `pass` = '$pass' LIMIT 1");
if (mysqli_num_rows($query)) {	
mysqli_query($connect, "UPDATE `users` SET `last_aut` = '".time()."', `ip` = '".apicms_filter($ip)."', `browser` = '".browser()."', `oc` = '".apicms_filter($oc)."' WHERE `login` = '$login' LIMIT 1");		
//// Ставим куки (86400 = day)
setcookie('userlogin', $login, time()+86400*365, '/');
setcookie('userpass', $pass, time()+86400*365, '/');
		
//// Переадресовываем браузер на главную страницу
header('location: index.php');
} else {
//// Переадресовываем браузер на страницу авторизации, если не верно
header('location: auth.php?error');
}
////////////////////////////////////////
?>