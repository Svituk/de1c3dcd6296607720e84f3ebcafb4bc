<?


/////////////////////////////////////////
$title = 'Приватная почта - рассылка';
require_once '../api_core/apicms_system.php';
if (!function_exists('apicms_ob_started')){ ob_start(); function apicms_ob_started(){} }
require_once '../design/styles/'.display_html($api_design).'/head.php';
/////////////////////////////////////////
if ($user['level']==1){
if (isset($_POST['txt']) && csrf_check()){
$text = apicms_filter($_POST['txt']);
if (strlen($text)>1024)$err = '<div class="erors"><center>Очень длинное сообщение</center></div>';
if (strlen($text)<10)$err = '<div class="erors"><center>Короткое сообщение</center></div>';
global $connect;
if (!isset($err)){
$q = mysqli_query($connect, "SELECT `id` FROM `users` WHERE `id` != '".intval($user['id'])."'");
while ($us = mysqli_fetch_array($q)){
mysqli_query($connect, "INSERT INTO `user_mail` (`txt`, `id_sender`, `id_recipient`, `time`) VALUES ('$text', '".intval($user['id'])."', '".intval($us['id'])."', '$time')");
}
echo '<div class="erors">Сообщения успешно отправлены!</div>';
}else{
apicms_error($err);
}
}
echo "<form action='/admin/rassilka.php?ok' method='post'>";
echo "<div class='apicms_content'><center><textarea name='txt'></textarea><br />";
echo "<input type='hidden' name='csrf_token' value='".display_html(csrf_token())."' />";
echo "<input type='submit' value='Добавить'/></form></center></div>";
}else{
echo '<div class="erors">Нет прав для просмотра раздела!</div>';
}
require_once '../design/styles/'.display_html($api_design).'/footer.php';
?>
