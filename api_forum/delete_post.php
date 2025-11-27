<?


/////////////////////////////////////////
$title = 'Удаление';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
/////////////////////////////////////////
global $connect;
$theme_id = intval($_GET['theme']);
/////////////////////////////////////////
if (!isset($user)) header('location: index.php');
$check_post = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `api_forum_post` WHERE `id` = '".intval($_GET['id'])."'");
$check_post_row = mysqli_fetch_assoc($check_post);
$check_theme = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `api_forum_theme` WHERE `id` = '".$theme_id."'");
$check_theme_row = mysqli_fetch_assoc($check_theme);
if (isset($_GET['id']) && $check_post_row['cnt']==1 && $check_theme_row['cnt']==1){
$post=mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `api_forum_post` WHERE `id` = '".intval($_GET['id'])."' LIMIT 1"));
if (isset($user) && $user['id'] == $post['id_user'] or $user['level']==1 or $user['level']==2 && $post['delete']==0){
$msg = 'Сообщение удалено';
mysqli_query($connect, "UPDATE `api_forum_post` SET `text` = '$msg', `delete` = '1', `delete_time` = '$time' WHERE `id` = '".intval($post['id'])."' LIMIT 1");
header("Location: theme.php?id=".$theme_id."");
}
}else{
echo "<div class='erors'>Ошибка удаления</div>\n";
}
//////////////////////////////////////////
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>