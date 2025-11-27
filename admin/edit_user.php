<?


////////////////////////////////////////
$title = 'Редактирование пользователя';
require_once '../api_core/apicms_system.php';
if (!function_exists('apicms_ob_started')){ ob_start(); function apicms_ob_started(){} }
////////////////////////////////////////
if (!isset($user) && !isset($_GET['id'])){header("Location: /index.php?");exit;}
global $connect;
if (isset($_GET['id']))$ank['id']=intval($_GET['id']);
$check_user = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `users` WHERE `id` = '".intval($ank['id'])."' LIMIT 1");
$check_user_row = mysqli_fetch_assoc($check_user);
if ($check_user_row['cnt']==0){header("Location: /index.php?");exit;}
$ank=mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '".intval($ank['id'])."' LIMIT 1"));
/////////////////////////////////////////
if ($user['level'] != 1) header('location: ../');
if ($user['level'] == 1){
/////////////////////////////////////////
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
/////////////////////////////////////////
if (isset($_POST['save'])){
/////////////////////////////////////////
if (isset($_POST['name']) && preg_match('/[A-zА-я0-9 _\-\=\+\(\)\*\?\.,]/i', $_POST['name'])){
$nameus = apicms_filter($_POST['name']);
mysqli_query($connect, "UPDATE `users` SET `name` = '$nameus' WHERE `id` = '".intval($ank['id'])."' LIMIT 1");
}
/////////////////////////////////////////
if (isset($_POST['login']) && preg_match('/[A-zА-я0-9 _\-\=\+\(\)\*\?\.,]/i', $_POST['login'])){
$loginus = apicms_filter($_POST['login']);
mysqli_query($connect, "UPDATE `users` SET `login` = '$loginus' WHERE `id` = '".intval($ank['id'])."' LIMIT 1");
}
/////////////////////////////////////////
if (isset($_POST['surname']) && preg_match('/[A-zА-я0-9 _\-\=\+\(\)\*\?\.,]/i', $_POST['surname'])){
$surnameus = apicms_filter($_POST['surname']);
mysqli_query($connect, "UPDATE `users` SET `surname` = '$surnameus' WHERE `id` = '".intval($ank['id'])."' LIMIT 1");
}
/////////////////////////////////////////
if (isset($_POST['country']) && preg_match('/[A-zА-я0-9 _\-\=\+\(\)\*\?\.,]/i', $_POST['country'])){
$countryus = apicms_filter($_POST['country']);
mysqli_query($connect, "UPDATE `users` SET `country` = '$countryus' WHERE `id` = '".intval($ank['id'])."' LIMIT 1");
}
/////////////////////////////////////////
if (isset($_POST['city']) && preg_match('/[A-zА-я0-9 _\-\=\+\(\)\*\?\.,]/i', $_POST['city'])){
$cityus = apicms_filter($_POST['city']);
mysqli_query($connect, "UPDATE `users` SET `city` = '$cityus' WHERE `id` = '".intval($ank['id'])."' LIMIT 1");
}
/////////////////////////////////////////
if (isset($_POST['fishka']) && $_POST['fishka'] >= 0 && preg_match('/[A-zА-я0-9 _\-\=\+\(\)\*\?\.,]/i', $_POST['fishka'])){
$fishkaus = apicms_filter($_POST['fishka']);
mysqli_query($connect, "UPDATE `users` SET `fishka` = '$fishkaus' WHERE `id` = '".intval($ank['id'])."' LIMIT 1");
}
/////////////////////////////////////////
if (isset($_POST['level']) && ($_POST['level']==0 || $_POST['level']==1 || $_POST['level']==2)){
$levelus = intval($_POST['level']);
mysqli_query($connect, "UPDATE `users` SET `level` = '$levelus' WHERE `id` = '".intval($ank['id'])."' LIMIT 1");
}
/////////////////////////////////////////
echo '<div class="apicms_content"><center>Изменения внесены</center></div>';
}
////////////////////////////////////////
echo "<form method='post' action='/admin/edit_user.php?id=".$ank['id']."&ok'>\n";
echo '<div class="apicms_subhead">';
echo "Администратор: <br /> <select name='level'>\n";
echo "<option value='0'".($ank['level']==0?" selected='selected'":null).">Пользователь</option>\n";
echo "<option value='1'".($ank['level']==1?" selected='selected'":null).">Администратор</option>\n";
echo "<option value='2'".($ank['level']==2?" selected='selected'":null).">Модератор</option>\n";
echo "</select><br />\n";
echo '</div>';
/////////////////////////////////////////
echo '<div class="apicms_subhead">';
echo "Имя: </br> <input type='text' name='name' value='".htmlspecialchars($ank['name'])."'  /><br />\n";
echo '</div>';
/////////////////////////////////////////
echo '<div class="apicms_subhead">';
echo "Никнейм: </br> <input type='text' name='login' value='".htmlspecialchars($ank['login'])."'  /><br />\n";
echo '</div>';
/////////////////////////////////////////
echo '<div class="apicms_subhead">';
echo "Фамилия: </br> <input type='text' name='surname' value='".htmlspecialchars($ank['surname'])."'  /><br />\n";
echo '</div>';
/////////////////////////////////////////
echo '<div class="apicms_subhead">';
echo "Страна: </br> <input type='text' name='country' value='".htmlspecialchars($ank['country'])."'  /><br />\n";
echo '</div>';
/////////////////////////////////////////
echo '<div class="apicms_subhead">';
echo "Город: </br> <input type='text' name='city' value='".htmlspecialchars($ank['city'])."'  /><br />\n";
echo '</div>';
/////////////////////////////////////////
echo '<div class="apicms_subhead">';
echo "Фишек: </br> <input type='text' name='fishka' value='".htmlspecialchars($ank['fishka'])."'  /><br />\n";
echo '</div>';
/////////////////////////////////////////
echo "<div class='apicms_subhead'><center><input type='submit' name='save' value='Сохранить' /></center></div>\n";
////////////////////////////////////////
}
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>