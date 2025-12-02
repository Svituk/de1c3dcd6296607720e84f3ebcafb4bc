<?php

////////////////////////////////////////
$title = 'Редактирование темы';
require_once '../api_core/apicms_system.php';
global $connect;

$theme_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// fetch theme and check permissions BEFORE any output
$setthem = mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM `api_forum_theme` WHERE `id` = '$theme_id' LIMIT 1"));
$setthem = $setthem ? $setthem : array();
$theme_owner = isset($setthem['id_user']) ? intval($setthem['id_user']) : 0;
$can_edit = ( ($is_user && $user_id == $theme_owner) || $user_level==1 || $user_level==2 );

if (!$can_edit){
	header('Location: /api_forum/index.php');
	exit();
}

// Handle POST (save) before output so header redirect works
if (isset($_POST['save'])){
	if (!csrf_check()){
		require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
		echo "<div class='erors'><center>Неверный CSRF-токен</center></div>";
		require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
		exit();
	}
	$nameus = apicms_filter($_POST['name']);
	$textus = apicms_filter($_POST['text']);
	mysqli_query($connect, "UPDATE `api_forum_theme` SET `name` = '$nameus', `text` = '$textus'  WHERE `id` = '$theme_id' LIMIT 1");
	header("Location: /api_forum/edit_theme.php?id=".$theme_id);
	exit();
}

// No redirect — include head and show form
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';

echo "<form method='post' action='?id=".$theme_id."&ok'>";
echo '<div class="apicms_subhead">';
echo "Название темы: </br> <input type='text' name='name' value='".htmlentities($setthem['name'], ENT_QUOTES, 'UTF-8')."' style='width:95%;' /><br />";
echo '</div>';

echo "<div class='apicms_subhead">";
echo 'Сообщение темы:</br><textarea name="text" cols="17" rows="3" style="width:95%;" >'.htmlspecialchars($setthem['text']).'</textarea><br />';
echo '</div>';
echo "<input type='hidden' name='csrf_token' value='".htmlspecialchars(csrf_token())."' />";
echo "<div class='apicms_subhead'><center><input type='submit' name='save' value='Обновить информацию' style='width:95%;' /></center></div>";

require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';

?>
