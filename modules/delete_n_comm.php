<?php


/////////////////////////////////////////
$title = 'Удаление комментариев';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
/////////////////////////////////////////
if ($user['level'] != 1) header('location: index.php');
if ($user['level'] == 1 or $user['level'] == 2){
global $connect;
if (isset($_GET['id']) && $user['level']==1){
$check_comm = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `news_comm` WHERE `id` = '".intval($_GET['id'])."'");
$check_comm_row = mysqli_fetch_assoc($check_comm);
if ($check_comm_row['cnt']==1){
$post=mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `news_comm` WHERE `id` = '".intval($_GET['id'])."' LIMIT 1"));
mysqli_query($connect, "DELETE FROM `news_comm` WHERE `id` = '".intval($post['id'])."'");
echo '<div class="apicms_content"><center>Комментарий успешно удален</center></div>';
}
}
//////////////////////////////////////////
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
php?>