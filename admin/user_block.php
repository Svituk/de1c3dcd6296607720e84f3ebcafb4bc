<?


/////////////////////////////////////////
$title = 'Блокировка пользователя';
require_once '../api_core/apicms_system.php';
if (!function_exists('apicms_ob_started')){ ob_start(); function apicms_ob_started(){} }
require_once '../design/styles/'.display_html($api_design).'/head.php';
/////////////////////////////////////////
if ($user['level'] < 1) header('location: ../');
if ($user['level'] == 1 or $user['level'] == 2){
/////////////////////////////////////////
global $connect;
if (isset($_GET['id']))$ank['id']=intval($_GET['id']);else{
header("Location: /index.php");
exit;
}
/////////////////////////////////////////
$unset_id = isset($_GET['unset']) ? intval($_GET['unset']) : 0;
$check_user = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `users` WHERE `id` = '".intval($ank['id'])."' LIMIT 1");
$check_user_row = mysqli_fetch_assoc($check_user);
if ($check_user_row['cnt']==0){
header("Location: /index.php");
exit;
}
/////////////////////////////////////////
if ($user['level'] < 1){
header("Location: /index.php");
exit;
}
$ank=mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '".intval($ank['id'])."' LIMIT 1"));
/////////////////////////////////////////
$check_ban = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `users_ban` WHERE `ank_ban` = '".intval($ank['id'])."' AND `id` = '".$unset_id."'");
$check_ban_row = mysqli_fetch_assoc($check_ban);
if ($unset_id && $check_ban_row['cnt']>0){
$block_inf=mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users_ban` WHERE `ank_ban` = '".intval($ank['id'])."' AND `id` = '".$unset_id."'"));
$ank2=mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '".intval($block_inf['ank_ban'])."' LIMIT 1"));
$min_block = max(0, intval($ank2['block_count']) - 1);
if ($user['level']>=1){
mysqli_query($connect, "DELETE FROM `users_ban` WHERE `id` = '".$unset_id."' LIMIT 1");
mysqli_query($connect, "UPDATE `users` SET `block_count` = '".$min_block."', `block_time` = '".(time()-1)."' WHERE `id` = '".intval($ank['id'])."' LIMIT 1");
echo '<div class="apicms_content"><center>Пользователь успешно разблокирован</center></div>';
}
else
echo '<div class="apicms_content"><center>У вас нет соответствующих прав</center></div>';
}
/////////////////////////////////////////
if (isset($_POST['ban_pr']) && isset($_POST['time']) && isset($_POST['vremja']) && $user['level']>=1 && csrf_check()){
$block_time = $time;
if ($_POST['vremja']=='min')$block_time+=intval($_POST['time'])*60;
if ($_POST['vremja']=='chas')$block_time+=intval($_POST['time'])*60*60;
if ($_POST['vremja']=='sut')$block_time+=intval($_POST['time'])*60*60*24;
if ($_POST['vremja']=='mes')$block_time+=intval($_POST['time'])*60*60*24*30;
if ($block_time < $time)$err = '<div class="apicms_content"><center>Ошибка времени блока</center></div>';
$prich = apicms_filter($_POST['ban_pr']);
$prich = apicms_filter($prich);
$plus_block = $ank['block_count']+1;
mysqli_query($connect, "INSERT INTO `users_ban` (`ank_ban`, `id_user`, `prich`, `time`) VALUES ('".intval($ank['id'])."', '".intval($user['id'])."', '".apicms_filter($prich)."', '$block_time')");
mysqli_query($connect, "UPDATE `users` SET `block_time` = '$block_time', `block_count` = '$plus_block' WHERE `id` = '".intval($ank['id'])."' LIMIT 1");
echo '<div class="apicms_content"><center>Пользователь успешно заблокирован</center></div>';
}
/////////////////////////////////////////
$ban_post_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `users` WHERE `id` = '".intval($ank['id'])."'");
$ban_post_row = mysqli_fetch_assoc($ban_post_result);
$ban_post = $ban_post_row['cnt'];
if ($ban_post==0)echo "<div class='apicms_content'><center>Нарушений не найдено</center></div>";
/////////////////////////////////////////
$qii=mysqli_query($connect, "SELECT * FROM `users_ban` WHERE `ank_ban` = '".intval($ank['id'])."' ORDER BY `time` DESC");
while ($post_ban = mysqli_fetch_assoc($qii)){
$ank2=mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = ".intval($post_ban['ank_ban'])." LIMIT 1"));
echo "<div class='apicms_subhead'>Причина: <b>".display_html($post_ban['prich'])."</b> </br></br> До ".apicms_data($post_ban['time'])." <a class = 'headbut' href='?id=$ank[id]&unset=$post_ban[id]'>Разблокировать</a></div>";
}
/////////////////////////////////////////
if ($user['level']>=1){
echo "<form action=\"user_block.php?id=$ank[id]&ok\" method=\"post\">\n";
echo "<div class='apicms_content'><center>Причина блокировки:<br /> <textarea name=\"ban_pr\"></textarea><br />\n";
echo "Срок блокировки<br /> <input type='text' name='time' value='10' maxlength='11' size='3' />\n";
echo "<select class='form' name=\"vremja\">\n";
echo "<option value='min'>Минут</option>\n";
echo "<option value='chas'>Часов</option>\n";
echo "<option value='sut'>Суток</option>\n";
echo "<option value='mes'>Месяцев</option>\n";
echo "</select><br /><input type='hidden' name='csrf_token' value='".display_html(csrf_token())."' /><input type='submit' value='Заблокировать'/></form></center></div>\n";
}else{
echo "<div class='apicms_content'>Нет прав для того, чтобы забанить пользователя</div>\n";
}
/////////////////////////////////////////
}
require_once '../design/styles/'.display_html($api_design).'/footer.php';
?>
