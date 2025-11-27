<?

$title = 'Ответ на сообщение';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
/////////////////////////////////////////

if (!$user['id']){
echo '<div class="apicms_content"><center>Для начала авторизуйтесь!</center></div>';
apicms_foot();
exit;}

global $connect;
//Определение
$otvet = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `mini_chat` WHERE `id` = '".intval($_GET['id'])."' LIMIT 1"));
if (isset($_GET['user']))$ank['id']=intval($_GET['user']);
$ank=mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '".intval($ank['id'])."' LIMIT 1"));

if (!$ank){
echo '<div class="apicms_content"><center>Данный юзер не найден!</center></div>';
apicms_foot();
exit;}

if ($user['id']==$ank['id']){
echo '<div class="apicms_content"><center>Нельзя отвечать самому себе!</center></div>';
apicms_foot();
exit;}

//Обработка ответа
if (isset($user['id']) && $_POST['txt']!=NULL){
$text = apicms_filter($_POST['txt']);
if (strlen($text)>1024)$err = '<div class="apicms_content"><center>Очень длинное сообщение</center></div>';
if (strlen($text)<3)$err = '<div class="apicms_content"><center>Короткое сообщение</center></div>';
$check_duplicate = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `mini_chat` WHERE `txt` = '".mysqli_real_escape_string($connect, $text)."'");
$check_duplicate_row = mysqli_fetch_assoc($check_duplicate);
if ($check_duplicate_row['cnt']!=0)$err = '<div class="apicms_content"><center>Ваше сообщение повторяет преведущие!</center></div>';
if (!isset($err)){

//Производим отправку
mysqli_query($connect, "INSERT INTO `mini_chat` (`txt`, `id_user`, `time`) VALUES ('$text', '".intval($user['id'])."', '$time')");
////////////////////////////////////
$plus_fishka = $user['fishka'] + $api_settings['fishka_chat'];
mysqli_query($connect, "UPDATE `users` SET `fishka` = '$plus_fishka' WHERE `id` = '".intval($user['id'])."' LIMIT 1");
$systext = 'Вам ответили в мини-чате, перейдите в него что бы дать ответ пользователю '.$ank['login'].'';
mysqli_query($connect, "INSERT INTO `api_system` (`id_user`, `text`, `time`, `read`) VALUES ('".intval($ank['id'])."', '".mysqli_real_escape_string($connect, $systext)."', '$time', '0')");
echo'<meta http-equiv="Refresh" apicms_content="0"; URL=index.php"/>';
header("Location: index.php");
}else{
apicms_error($err);
}
}

echo "<form action='?user=".$ank['id']."&ok' method='post'>";
echo "<div class='apicms_dialog'><center><textarea name='txt'>".htmlspecialchars($ank['login']).", </textarea><br />";
echo "<input type='submit' value='Ответить'/></form></center></div>";

////////////////////////////////////////
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>