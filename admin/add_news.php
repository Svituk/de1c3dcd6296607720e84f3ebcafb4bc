<?php 


///////////////////////////////
$title = 'Добавление новости';
require_once '../api_core/apicms_system.php';
// Start output buffering so header() calls later won't fail if output started
if (!function_exists('apicms_ob_started')){ ob_start(); function apicms_ob_started(){} }
require_once '../design/styles/'.display_html($api_design).'/head.php';
///////////////////////////////
if ($user['level'] != 1) header('location: ../');
///////////////////////////////
require_once '../api_core/user_panel.php';
/////////////////////////////////////
global $connect;
if ($user['level'] == 1){
$k_post_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `news`");
$k_post_row = mysqli_fetch_assoc($k_post_result);
$k_post = $k_post_row['cnt'];
$k_page=k_page($k_post,$api_settings['on_page']);
$page=page($k_page);
$start=$api_settings['on_page']*$page-$api_settings['on_page'];
if ($k_post==0)echo "<div class='apicms_content'><center>Новостей сайта не найдено</center></div>";
/////////////////////////////////////////
$query = mysqli_query($connect, "SELECT * FROM `news` ORDER BY time DESC LIMIT $start, ".$api_settings['on_page']);
while ($newsone = mysqli_fetch_assoc($query)){			
echo '<div class="apicms_content">';
if ($user['level']==1)echo ' <a href="delete_news.php?id='.$newsone['id'].'"><img src="/design/styles/'.display_html($api_design).'/images/delete_us.png" alt="DEL"></a> ';
echo ' <b>'.display_html($newsone['name']).'</b> <small>'.apicms_data($newsone['time']).' </br> '.apicms_smiles(apicms_bb_code(apicms_br(display_html($newsone['txt'])))).'</small> </div>';
}
/////////////////////////////////////////
if ($k_page > 1){
echo '<div class="apicms_subhead"><center>';
str('?',$k_page,$page); // генерируем постраничную навигацию
echo '</center></div>';
}

// Safely read action parameter to avoid "Undefined array key 'act'" warnings
$act = '';
if (isset($_GET['act'])) {
	$act = $_GET['act'];
} elseif (isset($_POST['act'])) {
	$act = $_POST['act'];
}

switch ($act) {
default:
echo '<div class="apicms_content"><form action="?act=do" method="post">
Название:<br /><input name="name" type="text" maxlength="200" /><br />
Текст:<br /><input name="txt" type="text" maxlength="1500" /><br />
Рассылка на email </br> <select name="rassilka">
<option value="1">Да,разослать юзерам</option>
<option value="0">Нет,только добавить</option></select><br />
<input type="hidden" name="csrf_token" value="'.display_html(csrf_token()).'" />
<input type="submit" value="Добавить"/></form></div>';
require_once '../design/styles/'.display_html($api_design).'/footer.php';
break;
///////////////////////////////	
case 'do':
$csrf_ok = csrf_check();
$name_news = apicms_filter($_POST['name']);
$txt_news = apicms_filter($_POST['txt']);
# проверяем CSRF
if (!$csrf_ok){
echo '<div class="erors"><center>Неверный CSRF-токен</center></div>';
require_once '../design/styles/'.display_html($api_design).'/footer.php';
break;
}
# проверяем, введено ли название
if (empty($_POST['name'])) {
echo '<div class="apicms_content">Вы не ввели название!<br /></div>';
require_once '../design/styles/'.display_html($api_design).'/footer.php';
break;
}
///////////////////////////////
# проверяем длину названия
if (strlen($name_news) < 3 or strlen($name_news) > 200) {
echo '<div class="apicms_content">Неверная длинна названия!<br /></div>';
require_once '../design/styles/'.display_html($api_design).'/footer.php';
break;
}
///////////////////////////////
# проверяем длину текста
if (strlen($txt_news) < 30 or strlen($txt_news) > 1500) {
echo '<div class="apicms_content">Неверная длинна текста!<br /></div>';
require_once '../design/styles/'.display_html($api_design).'/footer.php';
break;
}
///////////////////////////////
mysqli_query($connect, "INSERT INTO `news` SET `name` = '$name_news', `txt` = '$txt_news', `time` = '".time()."', `id_user` = '".intval($user['id'])."'");
///////////////////////////////
echo '<div class="apicms_content">Вы успешно добавили новость</div>';
header('location: add_news.php');
require_once '../design/styles/'.display_html($api_design).'/footer.php';

if (isset($_POST['rassilka']) && $_POST['rassilka']==1){
//Отправка на E-Mail
$email_from = !empty($api_settings['adm_mail']) ? $api_settings['adm_mail'] : ('no-reply@'.$set['site']);
$email_result = mysqli_query($connect, "SELECT * FROM `users` LIMIT 1");
$email = mysqli_fetch_assoc($email_result);
$message = 'Последние новости сайта:
'.$name_news.'
 '.$txt_news.'';
$subject = 'Новости сайта '.$set['site'];
$encoded_subject = '=?UTF-8?B?'.base64_encode($subject).'?=';
$headers = "MIME-Version: 1.0\r\n".
           "From: $email_from\r\n".
           "Reply-To: $email_from\r\n".
           "Content-Type: text/plain; charset=UTF-8\r\n".
           "Content-Transfer-Encoding: 8bit\r\n".
           "X-Mailer: PHP";
@mail($email['email'], $encoded_subject, $message, $headers, '-f'.$email_from);
}
session_destroy();
break;
}
}
///////////////////////////////
?>
