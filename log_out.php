<?php

$title = 'Выход из профиля'; // заголовок страницы
//////////////////////////////
require_once 'api_core/apicms_system.php';
//////////////////////////////
// If user is not logged in, send to home immediately
if (empty($user['id'])){ header('Location: /'); exit(); }

$act = isset($_GET['act']) ? htmlspecialchars(trim($_GET['act'])) : '';
//////////////////////////////
switch ($act){
case 'go_out':
	// Clear authentication cookies (set to empty and expire in past)
	setcookie('userlogin', '', time() - 3600, '/');
	setcookie('userpass',  '', time() - 3600, '/');
	// Also clear from $_COOKIE superglobal
	unset($_COOKIE['userlogin'], $_COOKIE['userpass']);
	// Destroy session
	session_destroy();
	// Redirect back or to index
	if (isset($_GET['return']) && $_GET['return'] !== ''){
		header('Location: ' . urldecode($_GET['return']));
	} else {
		header('Location: /index.php');
	}
	exit();
	break;
default:
	require_once 'design/styles/'.htmlspecialchars($api_design).'/head.php';
	echo "<div class='apicms_subhead'><center><img src='/design/styles/".htmlspecialchars($api_design)."/images/load.gif' alt=''><br/> Сессия будет удалена, подтвердите свой выход или покиньте эту страницу!";
	echo '<form action="/log_out.php?act=go_out" method="post">';
	echo '<input value="Подтверждаю" style="width:95%;" type="submit"></center></form></div>';
	require_once 'design/styles/'.htmlspecialchars($api_design).'/footer.php';
}
//////////////////////////////
?>