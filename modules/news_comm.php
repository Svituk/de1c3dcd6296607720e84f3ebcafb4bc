<?php

/////////////////////////////////////////
$title = 'Комментарии к новости';
require_once '../api_core/apicms_system.php';

// validate id presence and numeric
if (!isset($_GET['id']) || !is_numeric($_GET['id'])){ header("Location: index.php"); exit; }
global $connect;
$check_news = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `news` WHERE `id` = '".intval($_GET['id'])."' LIMIT 1");
$check_news_row = mysqli_fetch_assoc($check_news);
if ($check_news_row['cnt']==0){header("Location: index.php");exit;}

$id_news = intval($_GET['id']);
// Handle POST before rendering head to allow redirects if necessary
if (isset($user['id']) && isset($_POST['txt']) && trim($_POST['txt']) !== ''){
	$raw = apicms_filter($_POST['txt']);
	if (mb_strlen($raw, 'UTF-8') > 1024) $err = '<div class="apicms_content"><center>Очень длинное сообщение</center></div>';
	if (mb_strlen($raw, 'UTF-8') < 10) $err = '<div class="apicms_content"><center>Короткое сообщение</center></div>';
	if (!isset($err)){
		$text = mysqli_real_escape_string($connect, $raw);
		$time_now = isset($time) && $time ? intval($time) : time();
		mysqli_query($connect, "INSERT INTO `news_comm` (`id_news`, `txt`, `id_user`, `time`) VALUES ('".intval($id_news)."', '".$text."', '".intval($user['id'])."', '".$time_now."')");
		////////////////////////////////////
		$plus_fishka = intval($user['fishka']) + intval(isset($api_settings['fishka_n_comm']) ? $api_settings['fishka_n_comm'] : 0);
		mysqli_query($connect, "UPDATE `users` SET `fishka` = '".intval($plus_fishka)."' WHERE `id` = '".intval($user['id'])."' LIMIT 1");
		echo '<div class="erors">Комментарий успешно добавлен</div>';
	} else {
		apicms_error($err);
	}
}

require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
/////////////////////////////////////////

/////////////////////////////////////////
$k_post_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `news_comm`");
$k_post_row = mysqli_fetch_assoc($k_post_result);
$k_post = $k_post_row['cnt'];
$k_page=k_page($k_post,$api_settings['on_page']);
$page=page($k_page);
$start=$api_settings['on_page']*$page-$api_settings['on_page'];
if ($k_post==0)echo "<div class='erors'>Комментариев к новости не найдено!</div>";
/////////////////////////////////////////
$qii=mysqli_query($connect, "SELECT * FROM `news_comm` WHERE `id_news` = '$id_news' ORDER BY id DESC LIMIT $start, ".$api_settings['on_page']);
while ($post_comm = mysqli_fetch_assoc($qii)){
$ank2=mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = ".intval($post_comm['id_user'])." LIMIT 1"));
if (!$ank2) $ank2 = array('id'=>0,'login'=>'Гость');
echo '<div class="apicms_comms"><table width="100%" ><tr><td width="20%"><center>';
echo apicms_ava32($ank2['id']);
$profile_link = function_exists('profile_url_by_id') ? profile_url_by_id(intval($ank2['id'])) : ('/profile.php?id='.intval($ank2['id']));
echo "</center></td><td width='80%'><a href='".$profile_link."'>".htmlspecialchars($ank2['login'])."</a> ";
echo "<span style='float:right'> ".apicms_data($post_comm['time'])." ";
 $user_level = isset($user['level']) ? intval($user['level']) : 0;
if ($user_level==1) echo ' | <a href="delete_n_comm.php?id='.$post_comm['id'].'">DEL</a> ';
echo " </span>";
echo '</br> <b>'.apicms_smiles(apicms_bb_code(apicms_br(htmlspecialchars($post_comm['txt'])))).'</b></td></tr></table></div>';
}
/////////////////////////////////////////
if (isset($user['id']) && $user['id']){
echo "<form action=\"/modules/news_comm.php?id=".$id_news."&ok\" method=\"post\">\n";
echo "<div class='apicms_dialog'><center><textarea name=\"txt\"></textarea><br />\n";
echo "<input type='submit' value='Добавить'/></form></center></div>\n";
}else{
echo "<div class='apicms_content'>Извините вы неможете добавлять комментарии</div>\n";
}
/////////////////////////////////////////
if ($k_page > 1){
echo '<div class="apicms_subhead"><center>';
str('?id='.$id_news.'&',$k_page,$page); // генерируем постраничную навигацию
echo '</center></div>';
}
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>
