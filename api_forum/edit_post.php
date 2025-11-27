<?

$title = 'Редактирование сообщения';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
/////////////////////////////////////////
global $connect;
$postes = intval($_GET['post']);
$theme_id = intval($_GET['id']);
$subuser = mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM `api_forum_post` WHERE `id` = '$postes' LIMIT 1"));
/////////////////////////////////////////
$check_post = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `api_forum_post` WHERE `id` = '$postes'");
$check_post_row = mysqli_fetch_assoc($check_post);
if (isset($_GET['post']) && ($user['id'] == $subuser['id_user'] or $user['level']==1 or $user['level']==2) && $check_post_row['cnt']==1){
/////////////////////////////////////////
if (isset($_POST['txt'])){
$text = apicms_filter($_POST['txt']);
if (strlen($text)>1024)$err = '<div class="content"><center>Очень длинное сообщение</center></div>';
if (strlen($text)<3)$err = '<div class="content"><center>Короткое сообщение</center></div>';
/////////////////////////////////////////
if (!isset($err)){
mysqli_query($connect, "UPDATE `api_forum_post` SET `text` = '$text', `edit` = '1', `edit_time` = '$time' WHERE `id` = '$postes' LIMIT 1");
header("Location: theme.php?id=".$theme_id."&page=end");
}else{
apicms_error($err);
}
}
/////////////////////////////////////////
echo "<form action='edit_post.php?id=".$theme_id."&post=".$postes."&ok' method=\"post\">\n";
echo "<div class='apicms_dialog'><center><textarea name='txt'>".htmlspecialchars($subuser['text'])."</textarea><br />\n";
echo "<input type='submit' value='Изменить сообщение'/></form></center></div>\n";
////////////////////////////////////////
}else{
echo "<div class='erors'>Ошибка редактирования</div>\n";
}
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>