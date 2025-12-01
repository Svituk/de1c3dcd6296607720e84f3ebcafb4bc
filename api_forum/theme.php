<?php


/////////////////////////////////////////
require_once '../api_core/apicms_system.php';
/////////////////////////////////////////
global $connect;
if (isset($_GET['id'])) $theme_id = intval($_GET['id']);
$theme_name = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `api_forum_theme` WHERE `id` = '$theme_id' LIMIT 1"));
$title = 'APICMS - '.htmlspecialchars($theme_name['name']).'';

// Handle POST first so we can redirect without "headers already sent" issues
$post_error = '';
if (isset($user['id']) && !empty($_POST['txt'])){
	$raw_text = apicms_filter($_POST['txt']);
	if (mb_strlen($raw_text, 'UTF-8') > 1024) $post_error = 'Очень длинное сообщение';
	if (mb_strlen($raw_text, 'UTF-8') < 10) $post_error = 'Короткое сообщение';
	if (empty($post_error)){
		$text = mysqli_real_escape_string($connect, $raw_text);
		$time_now = isset($time) && $time ? intval($time) : time();
		$ins = mysqli_query($connect, "INSERT INTO `api_forum_post` (`text`, `id_user`, `theme`, `time`) VALUES ('".$text."', '".intval($user['id'])."', '".intval($theme_id)."', '".$time_now."')");
		if ($ins){
			$plus_fishka = intval($user['fishka']) + intval(isset($api_settings['fishka_forum_post']) ? $api_settings['fishka_forum_post'] : 0);
			mysqli_query($connect, "UPDATE `users` SET `fishka` = '".$plus_fishka."' WHERE `id` = '".intval($user['id'])."' LIMIT 1");
			header('Location: theme.php?id=' . intval($theme_id) . '&page=end');
			exit();
		} else {
			$post_error = 'Ошибка при добавлении сообщения';
		}
	}
}

// Now include head and render page; if POST had errors, we'll show them later
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
if (isset($_GET['id']) && $theme_name){
$check_theme = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `api_forum_theme` WHERE `id` = '".intval($theme_name['id'])."'");
$check_theme_row = mysqli_fetch_assoc($check_theme);
if ($check_theme_row['cnt']==1){
//////////////////////////////////////////////////////////
if ($theme_name['close']==1) echo '<div class="erors">Тема закрыта для обсуждений</div>';

$reloads = rand(100, 99999);

echo '<div class="apicms_subhead"><table width="100%" ><tr>';
if ($theme_name['close']==0 && ($is_user && ($theme_name['id_user']==$user_id || $user_level==1 || $user_level==2)))echo '<td width="25%"><center><a href="theme_close.php?id='.$theme_name['id'].'"><img src="/design/styles/'.htmlspecialchars($api_design).'/forum/theme_close.png"></a></center></td>';
if ($theme_name['close']==1 && ($is_user && ($theme_name['id_user']==$user_id || $user_level==1 || $user_level==2)))echo '<td width="25%"><center><a href="theme_open.php?id='.$theme_name['id'].'"><img src="/design/styles/'.htmlspecialchars($api_design).'/forum/theme_open.png"></a></center></td>';
echo '<td width="25%"><center><a href="theme.php?id='.$theme_name['id'].'&'.$reloads.'"><img src="/design/styles/'.htmlspecialchars($api_design).'/forum/reload.png"></a></center></td> ';
if ($theme_name['close']==0 && ($is_user && ($theme_name['id_user']==$user_id || $user_level==1 || $user_level==2)))echo '<td width="25%"><center><a href="del_theme.php?id='.$theme_name['id'].'"><img src="/design/styles/'.htmlspecialchars($api_design).'/forum/del_theme.png"></a></center></td>';
if ($theme_name['close']==0 && ($is_user && ($theme_name['id_user']==$user_id || $user_level==1 || $user_level==2)))echo '<td width="25%"><center><a href="edit_theme.php?id='.$theme_name['id'].'"><img src="/design/styles/'.htmlspecialchars($api_design).'/forum/edit_theme.png"></a></center></td>';
echo '</td></tr></table></div>';

/////////////////////////////////////////

$qii22=mysqli_query($connect, "SELECT * FROM `api_forum_theme` WHERE `id` = '$theme_id' ORDER BY id DESC LIMIT 1");
while ($post_theme = mysqli_fetch_assoc($qii22)){
$who_post=mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = ".intval($post_theme['id_user'])." LIMIT 1"));
echo '<div class="apicms_subhead"><table width="100%" ><tr><td width="10%"><center>';
echo apicms_ava32($who_post['id']);
echo "</center></td><td width='90%'><a href='/profile.php?id=$who_post[id]'>".$who_post['login']."</a> ";
echo "<span style='float:right'> <small>".apicms_data($post_theme['time'])."</small> </span>";
echo "<br/> <b>".apicms_smiles(apicms_br(htmlspecialchars($post_theme['text'])))."</b></td></tr></table></div>";
}

//////////////////////////////////////////////////////////

$k_post_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `api_forum_post` WHERE `theme` = '$theme_id'");
$k_post_row = mysqli_fetch_assoc($k_post_result);
$k_post = $k_post_row['cnt'];
$k_page=k_page($k_post,$api_settings['on_page']);
$page=page($k_page);
$start=$api_settings['on_page']*$page-$api_settings['on_page'];
if ($k_post==0)echo "<div class='erors'><center>Ответов в данной теме не найдено!</center></div>";

/////////////////////////////////////////

$qii=mysqli_query($connect, "SELECT * FROM `api_forum_post` WHERE `theme` = '$theme_id' ORDER BY id ASC LIMIT $start, ".$api_settings['on_page']);
while ($post_post = mysqli_fetch_assoc($qii)){
$who_post = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = ".intval($post_post['id_user'])." LIMIT 1"));
echo '<div class="apicms_subhead"><table width="100%" ><tr><td width="10%"><center>';
echo apicms_ava32($who_post['id']);
echo "</center></td><td width='85%'><a href='/profile.php?id=$who_post[id]'>".$who_post['login']."</a> ";
echo "<span style='float:right'> <small>".apicms_data($post_post['time'])."</small> </span>";
echo "<br/> <b>".apicms_smiles(apicms_br(htmlspecialchars($post_post['text'])))."</b>";
if ($post_post['edit']==1 && $post_post['delete']==0) echo ' <br/> <small>Изменено: '.apicms_data($post_post['edit_time']).'</small>';
if ($post_post['delete']==1) echo ' <br/> <small>Удалено: '.apicms_data($post_post['delete_time']).'</small>';
echo '<br/>';
if ($post_post['delete']==0 && ($is_user && ($post_post['id_user']==$user_id || $user_level==1 || $user_level==2)))echo '<small><a href="edit_post.php?id='.$theme_name['id'].'&post='.$post_post['id'].'">Редактировать</a>  / </small>';
if ($is_user && $user_id!=$post_post['id_user'] && ($theme_name['close']==0 && $post_post['delete']==0))echo ' <small> <a href="reply.php?id='.$theme_name['id'].'&user='.$who_post['id'].'">Ответить</a> / </small>';
if ($post_post['delete']==0 && ($is_user && ($post_post['id_user']==$user_id || $user_level==1 || $user_level==2)))echo ' <small> <a href="delete_post.php?id='.$post_post['id'].'&theme='.$theme_name['id'].'">Удалить</a></small>';
echo "</td></tr></table></div>";
}

//////////////////////////////////////////////////////////
if ($k_page > 1){
echo '<div class="apicms_subhead"><center>';
str('theme.php?id='.$theme_id.'&',$k_page,$page); // генерируем постраничную навигацию
echo '</center></div>';
}
//////////////////////////////////////////////////////////
if ($is_user && $theme_name['close']==0){
echo "<form action='/api_forum/theme.php?id=".$theme_id."&page=end&ok' method='post'>";
echo "<div class='apicms_dialog'><center><textarea name='txt'></textarea><br />";
echo "<input type='submit' value='Добавить'/></form></center></div>";
}else{
echo "<div class='erors'>Извините, вы не можете отправить сообщение</div>";
}

$my_acts = time()-600;
$in_theme_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `users` WHERE `my_place` = '".mysqli_real_escape_string($connect, $title)."' AND `activity` > '$my_acts'");
$in_theme_row = mysqli_fetch_assoc($in_theme_result);
$in_theme = $in_theme_row['cnt'];
if ($in_theme > 0)echo '<div class="apicms_subhead"><center> <img src="/design/styles/'.htmlspecialchars($api_design).'/forum/in_theme.png"> Сейчас в теме "'.$theme_name['name'].'": '.$in_theme.' чел.</center></div>';


}else{
echo "<div class='erors'><center>Извините, темы не существует</center></div>\n";
}
/////////////////////////////////////////
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';}
?>
