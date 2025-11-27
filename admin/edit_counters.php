<?


/////////////////////////////////////////
$title = 'Настройка счетчиков сайта APICMS';
require_once '../api_core/apicms_system.php';
if (!function_exists('apicms_ob_started')){ ob_start(); function apicms_ob_started(){} }
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
/////////////////////////////////////////
if ($user['level'] != 1) header('location: ../');
if ($user['level'] == 1){
/////////////////////////////////////////
global $connect;
if (isset($_POST['txt'])){
$text = base64_encode($_POST['txt']);
mysqli_query($connect, "UPDATE `settings` SET `counters` = '$text' LIMIT 1");
echo '<div class="apicms_content"><center>Изменения успешно внесены</center></div>';
}
/////////////////////////////////////////
if ($user['level']==1){
echo "<form action='?ok' method='post'>";
echo "<div class='apicms_content'><center><textarea name='txt'>".base64_decode($api_settings['counters'])."</textarea><br />";
echo "<input type='submit' value='Опубликовать'/></form></center></div>";
}else{
echo "<div class='apicms_content'>У вас нет прав изменять счетчики для сайта!</div>";
}
/////////////////////////////////////////
}
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>