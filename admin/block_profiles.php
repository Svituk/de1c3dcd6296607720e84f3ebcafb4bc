<?


/////////////////////////////////////////
$title = 'Список заблокированных';
require_once '../api_core/apicms_system.php';
if (!function_exists('apicms_ob_started')){ ob_start(); function apicms_ob_started(){} }
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
/////////////////////////////////////////
global $connect;
$k_post_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `users` WHERE `block_time` > '$time'");
$k_post_row = mysqli_fetch_assoc($k_post_result);
$k_post = $k_post_row['cnt'];
$k_page=k_page($k_post,$api_settings['on_page']);
$page=page($k_page);
$start=$api_settings['on_page']*$page-$api_settings['on_page'];
if ($k_post==0)echo "<div class='apicms_content'><center>Заблокированных пользователей не найдено</center></div>";
/////////////////////////////////////////
$qii_us=mysqli_query($connect, "SELECT * FROM `users`  WHERE `block_time` > '$time' ORDER BY id DESC LIMIT $start, ".$api_settings['on_page']);
while ($post_us = mysqli_fetch_assoc($qii_us)){
echo "<div class='apicms_subhead'> <img src='/design/styles/".htmlspecialchars($api_design)."/images/user_ico.png' alt=''> <a href='/profile.php?id=".$post_us['id']."'>".$post_us['login']."</a> :: ".apicms_data($post_us['block_time'])." </div>";
}
/////////////////////////////////////////
if ($k_page > 1){
echo '<div class="apicms_subhead"><center>';
str('?',$k_page,$page); // генерируем постраничную навигацию
echo '</center></div>';
}
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>