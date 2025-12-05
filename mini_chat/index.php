<?php

/////////////////////////////////////////
$title = 'Мини чат APICMS';
require_once '../api_core/apicms_system.php';

function chat_sanitize_html($html){
  $allowed = strip_tags($html,'<p><strong><em><u><s><blockquote><pre><code><a><br><b><i><ul><ol><li><span><img><iframe>');
  $clean = preg_replace('/\s(on[a-z]+|class|id|data-[^=]+)\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i','',$allowed);
  $clean = preg_replace_callback('/<a[^>]*>([\s\S]*?)<\/a>/i',function($m){$href = '#';if(preg_match('/href\s*=\s*("|\')?(https?:\/\/[^"\'\s>]+)(\1)?/i',$m[0],$mm)){$href = $mm[2];}return '<a href="'.display_html($href).'" target="_blank" rel="noopener noreferrer">'.$m[1].'</a>';},$clean);
  $clean = preg_replace_callback('/<img[^>]*>/i',function($m){$src = '';if(preg_match('/src\s*=\s*("|\')?(https?:\/\/[^"\'\s>]+)(\1)?/i',$m[0],$mm)){$src = $mm[2];}if($src==='')return '';return '<img src="'.display_html($src).'" style="max-width:100%;height:auto" alt="">';},$clean);
  $clean = preg_replace_callback('/<span[^>]*>/i',function($m){$style = '';if(preg_match('/style\s*=\s*("|\')([^\1]*?)(\1)/i',$m[0],$mm)){if(preg_match('/color\s*:\s*([^;]+)/i',$mm[2],$mc)){ $color = trim($mc[1]); $style = ' style="color:'.display_html($color).'"'; }}return '<span'.$style.'>';},$clean);
  $clean = preg_replace_callback('/<iframe[^>]*><\/iframe>/i',function($m){$src='';if(preg_match('/src\s*=\s*("|\')?(https?:\/\/[^"\'\s>]+)(\1)?/i',$m[0],$mm)){$src=$mm[2];}if(preg_match('#https?://www\.youtube\.com/embed/[A-Za-z0-9_-]{11}#i',$src)){return '<iframe src="'.$src.'" width="560" height="315" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'; }return '';},$clean);
  $clean = str_replace(['<b>','</b>'],['<strong>','</strong>'],$clean);
  $clean = str_replace(['<i>','</i>'],['<em>','</em>'],$clean);
  return $clean;
}

// Handle POST before output so headers (redirects) work reliably
if (isset($user['id']) && isset($_POST['txt']) && trim($_POST['txt']) !== ''){
    if (!csrf_check()){
        apicms_error('<div class="apicms_content"><center>Неверный CSRF-токен</center></div>');
    } else {
	$raw = isset($_POST['txt']) ? $_POST['txt'] : '';
	$text_only = strip_tags($raw);
	if (mb_strlen($text_only, 'UTF-8') > 1024) $err = '<div class="apicms_content"><center>Очень длинное сообщение</center></div>';
	if (mb_strlen($text_only, 'UTF-8') < 10) $err = '<div class="apicms_content"><center>Короткое сообщение</center></div>';
	if (!isset($err)){
		global $connect;
		$time_now = isset($time) && $time ? intval($time) : time();
		$msg_html = chat_sanitize_html($raw);
		$user_id_i = intval($user['id']);
		$ins = mysqli_prepare($connect, "INSERT INTO `mini_chat` (`txt`, `id_user`, `time`) VALUES (?,?,?)");
		mysqli_stmt_bind_param($ins, 'sii', $msg_html, $user_id_i, $time_now);
		mysqli_stmt_execute($ins);
		mysqli_stmt_close($ins);
		$plus_fishka = intval($user['fishka']) + intval(isset($api_settings['fishka_chat']) ? $api_settings['fishka_chat'] : 0);
		$upd = mysqli_prepare($connect, "UPDATE `users` SET `fishka` = ? WHERE `id` = ? LIMIT 1");
		mysqli_stmt_bind_param($upd, 'ii', $plus_fishka, $user_id_i);
		mysqli_stmt_execute($upd);
		mysqli_stmt_close($upd);
		header('Location: index.php');
		exit();
	} else {
		apicms_error($err);
	}
    }
}

require_once '../design/styles/'.display_html($api_design).'/head.php';
/////////////////////////////////////////

/////////////////////////////////////////
global $connect;
$stmt_cnt = mysqli_prepare($connect, "SELECT COUNT(*) as cnt FROM `mini_chat`");
mysqli_stmt_execute($stmt_cnt);
$res_cnt = mysqli_stmt_get_result($stmt_cnt);
$k_post_row = mysqli_fetch_assoc($res_cnt);
mysqli_stmt_close($stmt_cnt);
$k_post = $k_post_row['cnt'];
$k_page=k_page($k_post,$api_settings['on_page']);
$page=page($k_page);
$start=$api_settings['on_page']*$page-$api_settings['on_page'];
if ($k_post==0)echo "<div class='erors'><center>Сообщений в мини-чате ненайдено</center></div>";
/////////////////////////////////////////
$stmt_mc = mysqli_prepare($connect, "SELECT `id`,`txt`,`id_user`,`time` FROM `mini_chat` ORDER BY id DESC LIMIT ?, ?");
$lim1 = intval($start);
$lim2 = intval($api_settings['on_page']);
mysqli_stmt_bind_param($stmt_mc, 'ii', $lim1, $lim2);
mysqli_stmt_execute($stmt_mc);
$res_mc = mysqli_stmt_get_result($stmt_mc);
while ($post_chat = mysqli_fetch_assoc($res_mc)){
$stmt_u = mysqli_prepare($connect, "SELECT `id`,`login` FROM `users` WHERE `id` = ? LIMIT 1");
$uid_q = intval($post_chat['id_user']);
mysqli_stmt_bind_param($stmt_u, 'i', $uid_q);
mysqli_stmt_execute($stmt_u);
$res_u = mysqli_stmt_get_result($stmt_u);
$ank2 = mysqli_fetch_assoc($res_u);
mysqli_stmt_close($stmt_u);
echo '<div class="apicms_subhead"><table width="100%" ><tr><td width="20%"><center>';
echo apicms_ava32($ank2['id']);
echo "</center></td><td width='80%'><a href='/profile.php?id=$ank2[id]'>".$ank2['login']."</a> ";
echo "<span style='float:right'> ".apicms_data($post_chat['time'])." ";
if (isset($user['level']) && $user['level']>=1) echo '  <a href="delete.php?id='.$post_chat['id'].'"><img src="/design/styles/'.display_html($api_design).'/images/delete_us.png" alt="DEL"></a> ';
echo " </span>";
$t = $post_chat['txt'];
if (preg_match('/<[a-z][\s\S]*>/i', $t)) {
    $clean_html = chat_sanitize_html($t);
    echo " </br><b>".apicms_smiles($clean_html)."</b>";
} else if (strpos($t,'[')!==false){
    echo " </br><b>".apicms_smiles(apicms_bb_code(apicms_br(display_html($t))))."</b>";
} else {
    echo " </br><b>".apicms_smiles(apicms_br(display_html($t)))."</b>";
}
if (isset($user['id']) && $user['id']!=$ank2['id']) echo '<br /><small><a href="otvet.php?id='.$post_chat['id'].'&user='.$ank2['id'].'">Ответить</a></small>';
echo '</td></tr></table></div>';
}
/////////////////////////////////////////
if (isset($user['id']) && $user['id']){
echo "<form id='mc_form' action='?ok' method='post'>";
echo "<div class='apicms_dialog'><center>";
echo "<link rel='stylesheet' href='/api_core/assets/wysiwyg.css' />";
echo "<div id='apicms-wysiwyg' class='wysiwyg'><div class='wysiwyg-toolbar'></div><div id='mc_html' class='wysiwyg-editor' contenteditable='true'></div><textarea id='mc_ta' style='display:none;width:95%;min-height:120px'></textarea></div>";
echo "<input type='hidden' id='mc_txt' name='txt' />";
echo "<input type='hidden' name='csrf_token' value='".display_html(csrf_token())."' />";
echo "<script src='/api_core/assets/wysiwyg.js'></script>";
echo "<script src='/api_core/assets/tinymce.min.js'></script>";
echo "<script>(function(){var useTiny = !!(window.tinymce && typeof window.tinymce.init==='function');var ta = document.getElementById('mc_ta');var ed = document.getElementById('mc_html');var hidden = document.getElementById('mc_txt');if (useTiny){ed.style.display='none';ta.style.display='block';tinymce.init({selector:'#mc_ta',menubar:false,statusbar:false,plugins:'lists link image media codesample emoticons',toolbar:'bold italic underline strikethrough | bullist numlist | blockquote codesample | link image media emoticons | forecolor backcolor | undo redo',setup:function(inst){var form=document.getElementById('mc_form');if(form){form.addEventListener('submit',function(){hidden.value = inst.getContent();});}}});} else {apicmsWysiwyg.init({editor:'#mc_html', hidden:'#mc_txt'});}})();</script>";
echo "<input id='mc_submit' type='submit' value='Добавить'/></form></center></div>";
}else{
echo "<div class='erors'>Извините вы неможете писать в чате</div\n";
}
/////////////////////////////////////////
if ($k_page > 1){
echo '<div class="apicms_subhead"><center>';
str('?',$k_page,$page); // генерируем постраничную навигацию
echo '</center></div>';
}
require_once '../design/styles/'.display_html($api_design).'/footer.php';
?>
