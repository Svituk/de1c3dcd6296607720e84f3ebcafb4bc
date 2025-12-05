<?php

$title = 'Выход из профиля'; // заголовок страницы
//////////////////////////////
require_once 'api_core/apicms_system.php';
//////////////////////////////
// If user is not logged in, send to home immediately
if (empty($user['id'])){ header('Location: /'); exit(); }

$act = isset($_GET['act']) ? display_html(trim($_GET['act'])) : '';
//////////////////////////////
switch ($act){
case 'go_out':
	// Require POST and CSRF to avoid CSRF logout
	if ($_SERVER['REQUEST_METHOD']!=='POST' || !csrf_check()){
		header('Location: /');
		exit();
	}
	// Clear authentication cookies (set to empty and expire in past)
	setcookie('userlogin', '', time() - 3600, '/', '', false, true);
	setcookie('userpass',  '', time() - 3600, '/', '', false, true);
	// Also clear from $_COOKIE superglobal
	unset($_COOKIE['userlogin'], $_COOKIE['userpass']);
	// Destroy session
	session_destroy();
	// Redirect back or to index
	if (isset($_GET['return']) && $_GET['return'] !== '' && strpos($_GET['return'],'/')===0){
		header('Location: ' . $_GET['return']);
	} else {
		header('Location: /index.php');
	}
	exit();
	break;
default:
require_once 'design/styles/'.display_html($api_design).'/head.php';
    echo "<div class='apicms_subhead'><center><img src='/design/styles/".display_html($api_design)."/images/load.gif' alt=''><br/> Сессия будет удалена, подтвердите свой выход или покиньте эту страницу!";
	echo '<form action="/log_out.php?act=go_out" method="post">';
    echo "<input type='hidden' name='csrf_token' value='".display_html(csrf_token())."' />";
	echo '<input value="Подтверждаю" style="width:95%;" type="submit"></center></form></div>';
    require_once 'design/styles/'.display_html($api_design).'/footer.php';
}
//////////////////////////////
?>
