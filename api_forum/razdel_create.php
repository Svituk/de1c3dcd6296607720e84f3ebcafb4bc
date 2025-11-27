<?php

////////////////////////////////////////
$title = 'Форум - Создание раздела';
require_once '../api_core/apicms_system.php';
global $connect;

// Use safe user flags from apicms_system
$can_create = ($user_level==1 || $user_level==2);

// Handle POST and permission checks BEFORE output so header() works
if ($can_create && isset($_POST['save'])){
	$my_razdel = apicms_filter($_POST['razdel']);
	$my_forum_opis = apicms_filter($_POST['forum_opis']);
	if (isset($_POST['razdel']) && strlen($my_forum_opis)>10){
		mysqli_query($connect, "INSERT INTO `api_forum_razdel` (name, opisanie, id_user, time) values ('".apicms_filter($my_razdel)."', '".apicms_filter($my_forum_opis)."', '".intval($user_id)."', '$time')");
	}
	// Redirect after successful creation
	header("Location: index.php");
	exit();
}

// Include head and show form / message
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';

if ($can_create){
	echo "<form method='post' action='?ok'>\n";
	echo "<div class='apicms_subhead'><center>Название раздела: </br> <input type='text' name='razdel' value=''  /><br /> <textarea name='forum_opis'></textarea></center></div>\n";
	echo "<div class='apicms_subhead'><center><input type='submit' name='save' value='Создать раздел' /></center></div>\n";
} else {
	echo "<div class='apicms_content'><center>Недостаточно прав для входа!</center></div>\n";
}

////////////////////////////////////////
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';

?>