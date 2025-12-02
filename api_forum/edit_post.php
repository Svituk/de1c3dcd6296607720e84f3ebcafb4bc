<?

$title = 'Редактирование сообщения';
require_once '../api_core/apicms_system.php';
/////////////////////////////////////////
global $connect;
$postes = isset($_GET['post']) ? intval($_GET['post']) : 0;
$theme_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$subuser = mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM `api_forum_post` WHERE `id` = '$postes' LIMIT 1"));
/////////////////////////////////////////
$check_post = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `api_forum_post` WHERE `id` = '$postes'");
$check_post_row = mysqli_fetch_assoc($check_post);
$owner_id = $subuser && isset($subuser['id_user']) ? intval($subuser['id_user']) : 0;
$can_edit = ($is_user && $user_id == $owner_id) || ($user_level==1 || $user_level==2);
if ($postes && $can_edit && $check_post_row && $check_post_row['cnt']==1){
/////////////////////////////////////////
if (isset($_POST['txt']) && isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']){
$text = apicms_filter($_POST['txt']);
if (strlen($text)>1024)$err = '<div class="content"><center>Очень длинное сообщение</center></div>';
if (strlen($text)<3)$err = '<div class="content"><center>Короткое сообщение</center></div>';
/////////////////////////////////////////
if (!isset($err)){
$stmt = mysqli_prepare($connect, "UPDATE `api_forum_post` SET `text` = ?, `edit` = 1, `edit_time` = ? WHERE `id` = ? LIMIT 1");
mysqli_stmt_bind_param($stmt,'sii',$text,$time,$postes);
mysqli_stmt_execute($stmt);
header("Location: theme.php?id=".$theme_id."&page=end");
exit;
}else{
apicms_error($err);
}
}
/////////////////////////////////////////
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
echo "<form action='edit_post.php?id=".$theme_id."&post=".$postes."&ok' method=\"post\">\n";
echo "<div class='apicms_dialog'><center><textarea name='txt'>".htmlspecialchars($subuser['text'])."</textarea><br />\n";
echo "<input type='hidden' name='csrf_token' value='".$_SESSION['csrf_token']."' />\n";
echo "<input type='submit' value='Изменить сообщение'/></form></center></div>\n";
////////////////////////////////////////
}else{
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
echo "<div class='erors'>Ошибка редактирования</div\n";
}
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>
