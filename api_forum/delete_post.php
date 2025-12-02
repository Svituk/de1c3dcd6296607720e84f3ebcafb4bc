<?


/////////////////////////////////////////
$title = 'Удаление';
require_once '../api_core/apicms_system.php';
/////////////////////////////////////////
global $connect;
$theme_id = intval($_GET['theme']);
/////////////////////////////////////////
if (!$is_user) { header('Location: index.php'); exit; }
$check_post = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `api_forum_post` WHERE `id` = '".intval($_GET['id'])."'");
$check_post_row = mysqli_fetch_assoc($check_post);
$check_theme = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `api_forum_theme` WHERE `id` = '".$theme_id."'");
$check_theme_row = mysqli_fetch_assoc($check_theme);
if (isset($_GET['id']) && $check_post_row && $check_post_row['cnt']==1 && $check_theme_row && $check_theme_row['cnt']==1){
    $post=mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `api_forum_post` WHERE `id` = '".intval($_GET['id'])."' LIMIT 1"));
    $owner = intval($post['id_user']);
    $can = ($user_level==1 || $user_level==2 || ($user_id && $user_id==$owner)) && ($post['delete']==0);
    if ($can){
        $msg = 'Сообщение удалено';
        $stmt = mysqli_prepare($connect, "UPDATE `api_forum_post` SET `text` = ?, `delete` = 1, `delete_time` = ? WHERE `id` = ? LIMIT 1");
        $pid = intval($post['id']);
        mysqli_stmt_bind_param($stmt,'sii',$msg,$time,$pid);
        mysqli_stmt_execute($stmt);
        header("Location: theme.php?id=".$theme_id);
        exit;
    }
}
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
echo "<div class='erors'>Ошибка удаления</div\n";
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>
