<?
///////////////////////////////
$title = 'Выполнить MySQL запрос';
require_once '../api_core/apicms_system.php';
if (!function_exists('apicms_ob_started')){ ob_start(); function apicms_ob_started(){} }
require_once '../design/styles/'.display_html($api_design).'/head.php';
///////////////////////////////
if ($user['level'] != 1) header('location: ../');
///////////////////////////////
require_once '../api_core/user_panel.php';
if ($user['level'] == 1){
///////////////////////////////
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['getbase']) && csrf_check()){
global $connect;
$sql=trim($_POST['getbase']);
mysqli_query($connect, $sql);
echo "<div class='erors'>Запрос успешно выполнен</div>";
}
///////////////////////////////
echo "<form method='post' action='mysql.php'>";
echo "<div class='apicms_content'><center><textarea name='getbase'></textarea><br />";
echo "<input type='hidden' name='csrf_token' value='".display_html(csrf_token())."' />";
echo "<input value='Выполнить запрос' type='submit' /></center></div>";
echo "</form>\n";

echo '<div class="apicms_content">* Внимание добавляйте по одному запросу! Система делает только 1 запрос.</div>';
///////////////////////////////
}else{
echo '<div class="erors">Недостаточно прав для входа!</div>';
}
require_once '../design/styles/'.display_html($api_design).'/footer.php';
?>
