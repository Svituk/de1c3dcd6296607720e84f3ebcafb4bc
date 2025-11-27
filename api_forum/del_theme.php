<?php

/////////////////////////////////////////
$title = 'Удаление';
require_once '../api_core/apicms_system.php';
global $connect;
$theme_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Redirect guests before any output is sent
if (empty($is_user)) { header('Location: /api_forum/index.php'); exit(); }
// fetch post and check ownership/permissions before any output
$post = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `api_forum_theme` WHERE `id` = '".$theme_id."' LIMIT 1"));
$post = $post ? $post : array();
$post_owner_id = isset($post['id_user']) ? intval($post['id_user']) : 0;
$can_delete = ( ($is_user && $user_id == $post_owner_id) || $user_level==1 || $user_level==2 );

if (!$can_delete){
	header('Location: /api_forum/index.php');
	exit();
}

// If form submitted and user allowed — perform deletion and redirect before any output
if (isset($_POST['okdel'])){
	$check_theme = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `api_forum_theme` WHERE `id` = '".$theme_id."'");
	$check_theme_row = mysqli_fetch_assoc($check_theme);
	if ($check_theme_row && $check_theme_row['cnt']==1){
		mysqli_query($connect, "DELETE FROM `api_forum_theme` WHERE `id` = '$theme_id'");
		mysqli_query($connect, "DELETE FROM `api_forum_post` WHERE `theme` = '$theme_id'");
		header("Location: index.php");
		exit();
	} else {
		// If theme not found, redirect back
		header('Location: index.php');
		exit();
	}
}

// No POST (or deletion not yet confirmed) — include head and show confirmation form
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
echo "<form action='del_theme.php?id=".$theme_id."&ok' method=\"post\">\n";
echo "<div class='content'><center><input type='submit' name='okdel' value='Подтвердить удаление'/></form></center></div>\n";

require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>