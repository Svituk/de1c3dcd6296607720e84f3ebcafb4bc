<?

/////////////////////////////////////////
$title = 'Настройка правил APICMS';
require_once '../api_core/apicms_system.php';
if (!function_exists('apicms_ob_started')){ ob_start(); function apicms_ob_started(){} }
require_once '../design/styles/'.display_html($api_design).'/head.php';
/////////////////////////////////////////
if ($user['level'] != 1) header('location: ../');
if ($user['level'] == 1){
/////////////////////////////////////////
global $connect;
if (isset($_POST['txt']) && csrf_check()){
 $text = apicms_filter($_POST['txt']);
 mysqli_query($connect, "UPDATE `settings` SET `rules` = '$text' LIMIT 1");
 echo '<div class="apicms_content"><center>Изменения успешно внесены</center></div>';
}
/////////////////////////////////////////
if ($user['level']==1){
 echo "<form action=\"?ok\" method=\"post\">\n";
 echo "<div class='apicms_content'><center><textarea name='txt'>".display_html($api_settings['rules'])."</textarea><br />\n";
 echo "<input type='hidden' name='csrf_token' value='".display_html(csrf_token())."' />";
 echo "<input type='submit' value='Опубликовать'/></form></center></div>\n";
}else{
echo "<div class='apicms_content'>У вас нет прав изменять правила сайта!</div>\n";
}
}
/////////////////////////////////////////
require_once '../design/styles/'.display_html($api_design).'/footer.php';
?>
