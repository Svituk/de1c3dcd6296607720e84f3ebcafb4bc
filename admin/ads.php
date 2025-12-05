<?php 


///////////////////////////////
$title = 'Добавление рекламы';
require_once '../api_core/apicms_system.php';
if (!function_exists('apicms_ob_started')){ ob_start(); function apicms_ob_started(){} }
require_once '../design/styles/'.display_html($api_design).'/head.php';
///////////////////////////////
if ($user['level'] != 1) header('location: ../');
///////////////////////////////
require_once '../api_core/user_panel.php';
///////////////////////////////
global $connect;
if ($user['level'] == 1){
$k_post_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `advertising`");
$k_post_row = mysqli_fetch_assoc($k_post_result);
$k_post = $k_post_row['cnt'];
$k_page=k_page($k_post,$api_settings['on_page']);
$page=page($k_page);
$start=$api_settings['on_page']*$page-$api_settings['on_page'];
if ($k_post==0)echo "<div class='erors'><center>Рекламы не найдено</center></div>";
/////////////////////////////////////////
$query = mysqli_query($connect, "SELECT * FROM `advertising` ORDER BY time DESC LIMIT $start, ".$api_settings['on_page']);
while ($adsone = mysqli_fetch_assoc($query)){	
if ($adsone['mesto']==1)$ms = 'верх сайта';
if ($adsone['mesto']==2)$ms = 'низ сайта';	
echo '<div class="apicms_subhead"> '.$adsone['name'].' ';
if ($user['level']==1)echo ' <span style="float:right"><a href="delete_ads.php?id='.$adsone['id'].'"><img src="/design/styles/'.display_html($api_design).'/images/delete_us.png" alt="Удалить"></a></span> ';
echo ' </br> Активна до: '.apicms_data($adsone['time']).' </br> Расположение на сайте: '.display_html($ms).' </br> Ссылка на страницу: '.display_html($adsone['link']).' ';
echo '</div>';
}
/////////////////////////////////////////

echo '<div class="apicms_subhead"><center>';
if ($k_page > 1)str('?',$k_page,$page); // генерируем постраничную навигацию
echo '</center></div>';
// Safely read action parameter to avoid undefined index warnings
$act = '';
if (isset($_GET['act'])) {
	$act = $_GET['act'];
} elseif (isset($_POST['act'])) {
	$act = $_POST['act'];
}

switch ($act) {
default:
echo '<div class="apicms_content"><form action="?act=do" method="post">';
echo 'Название:<br /><input name="name" type="text" maxlength="200" /><br />';
echo 'Ссылка:<br /><input name="link" type="text" maxlength="150" /><br />';
echo "Дней для заказа <select name='days'>";
echo "<option value='7'>7</option>\n";
echo "<option value='14'>14</option>\n";
echo "<option value='21'>21</option>\n";
echo "<option value='30'>30</option>\n";
echo "<option value='60'>60</option>\n";
echo "<option value='90'>90</option>\n";
echo "</select></br>\n";
echo "Расположение <select name='mesto'>";
echo "<option value='1'>Вверху сайта</option>\n";
echo "<option value='2'>Внизу сайта</option>\n";
echo "</select></br>\n";
echo '<input type="hidden" name="csrf_token" value="'.display_html(csrf_token()).'" />';
echo '<input type="submit" value="Разместить"/></form></div>';
require_once '../design/styles/'.display_html($api_design).'/footer.php';
break;
///////////////////////////////	
case 'do':
if (!csrf_check()){
echo '<div class="erors"><center>Неверный CSRF-токен</center></div>';
require_once '../design/styles/'.display_html($api_design).'/footer.php';
break;
}
$name = apicms_filter($_POST['name']);
$link = apicms_filter($_POST['link']);
$day=intval($_POST['days']);
$mesto=intval($_POST['mesto']);
$time_last=time()+$day*60*60*24;
////////////////////////////////
# проверяем, введено ли название
if (empty($_POST['name'])) {
echo '<div class="apicms_content">Вы не ввели название ссылки!</div>';
require_once '../design/styles/'.display_html($api_design).'/footer.php';
break;
}
///////////////////////////////
# проверяем длину названия
if (strlen($name) < 3 or strlen($name) > 200) {
echo '<div class="apicms_content">Неверная длинна названия ссылки!</div>';
require_once '../design/styles/'.display_html($api_design).'/footer.php';
break;
}
///////////////////////////////
# проверяем длину текста
if (strlen($link) < 5 or strlen($link) > 150) {
echo '<div class="apicms_content">Неверная длинна ссылки!</div>';
require_once '../design/styles/'.display_html($api_design).'/footer.php';
break;
}
///////////////////////////////
mysqli_query($connect, "INSERT INTO `advertising` SET `name` = '$name', `link` = '$link', `time` = '".intval($time_last)."', `mesto` = '$mesto', `id_user` = '".intval($user['id'])."'");
///////////////////////////////
echo '<div class="apicms_content">Вы успешно добавили рекламную ссылку</div>';
require_once '../design/styles/'.display_html($api_design).'/footer.php';
break;
}
}
///////////////////////////////
?>
