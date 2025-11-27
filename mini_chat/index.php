<?php

/////////////////////////////////////////
$title = 'Мини чат APICMS';
require_once '../api_core/apicms_system.php';

// Handle POST before output so headers (redirects) work reliably
if (isset($user['id']) && isset($_POST['txt']) && trim($_POST['txt']) !== ''){
	$raw = apicms_filter($_POST['txt']);
	if (mb_strlen($raw, 'UTF-8') > 1024) $err = '<div class="apicms_content"><center>Очень длинное сообщение</center></div>';
	if (mb_strlen($raw, 'UTF-8') < 10) $err = '<div class="apicms_content"><center>Короткое сообщение</center></div>';
	if (!isset($err)){
		global $connect;
		$text = mysqli_real_escape_string($connect, $raw);
		$time_now = isset($time) && $time ? intval($time) : time();
		mysqli_query($connect, "INSERT INTO `mini_chat` (`txt`, `id_user`, `time`) VALUES ('".$text."', '".intval($user['id'])."', '".$time_now."')");
		////////////////////////////////////
		$plus_fishka = intval($user['fishka']) + intval(isset($api_settings['fishka_chat']) ? $api_settings['fishka_chat'] : 0);
		mysqli_query($connect, "UPDATE `users` SET `fishka` = '".$plus_fishka."' WHERE `id` = '".intval($user['id'])."' LIMIT 1");
		header('Location: index.php');
		exit();
	} else {
		apicms_error($err);
	}
}

require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
/////////////////////////////////////////

/////////////////////////////////////////
global $connect;
$k_post_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `mini_chat`");
$k_post_row = mysqli_fetch_assoc($k_post_result);
$k_post = $k_post_row['cnt'];
$k_page=k_page($k_post,$api_settings['on_page']);
$page=page($k_page);
$start=$api_settings['on_page']*$page-$api_settings['on_page'];
if ($k_post==0)echo "<div class='erors'><center>Сообщений в мини-чате ненайдено</center></div>";
/////////////////////////////////////////
$qii=mysqli_query($connect, "SELECT * FROM `mini_chat` ORDER BY id DESC LIMIT $start, ".$api_settings['on_page']);
while ($post_chat = mysqli_fetch_assoc($qii)){
$ank2=mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = ".intval($post_chat['id_user'])." LIMIT 1"));
echo '<div class="apicms_subhead"><table width="100%" ><tr><td width="20%"><center>';
echo apicms_ava32($ank2['id']);
echo "</center></td><td width='80%'><a href='/profile.php?id=$ank2[id]'>".$ank2['login']."</a> ";
echo "<span style='float:right'> ".apicms_data($post_chat['time'])." ";
if (isset($user['level']) && $user['level']>=1) echo '  <a href="delete.php?id='.$post_chat['id'].'"><img src="/design/styles/'.htmlspecialchars($api_design).'/images/delete_us.png" alt="DEL"></a> ';
echo " </span>";
echo "</br> <b>".apicms_smiles(apicms_br(htmlspecialchars($post_chat['txt'])))."</b>";
if (isset($user['id']) && $user['id']!=$ank2['id']) echo '<br /><small><a href="otvet.php?id='.$post_chat['id'].'&user='.$ank2['id'].'">Ответить</a></small>';
echo '</td></tr></table></div>';
}
/////////////////////////////////////////
if (isset($user['id']) && $user['id']){
echo "<form action='?ok' method='post'>";
echo "<div class='apicms_dialog'><center><textarea name='txt'></textarea><br />";
echo "<input type='submit' value='Добавить'/></form></center></div>";
}else{
echo "<div class='erors'>Извините вы неможете писать в чате</div>\n";
}
/////////////////////////////////////////
if ($k_page > 1){
echo '<div class="apicms_subhead"><center>';
str('?',$k_page,$page); // генерируем постраничную навигацию
echo '</center></div>';
}
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>
