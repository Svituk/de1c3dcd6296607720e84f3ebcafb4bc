<?


/////////////////////////////////////////
$title = 'Удаление';
require_once '../api_core/apicms_system.php';
/////////////////////////////////////////
global $connect;
$theme_id = isset($_GET['theme']) ? intval($_GET['theme']) : 0;
/////////////////////////////////////////
$post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$is_user) { header('Location: index.php'); exit; }
$check_post = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `api_forum_post` WHERE `id` = '".$post_id."'");
$check_post_row = mysqli_fetch_assoc($check_post);
$check_theme = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `api_forum_theme` WHERE `id` = '".$theme_id."'");
$check_theme_row = mysqli_fetch_assoc($check_theme);
if ($post_id && $check_post_row && $check_post_row['cnt']==1 && $check_theme_row && $check_theme_row['cnt']==1){
    $post=mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `api_forum_post` WHERE `id` = '".$post_id."' LIMIT 1"));
    $owner = intval($post['id_user']);
    $can = ($user_level==1 || $user_level==2 || ($user_id && $user_id==$owner)) && ($post['delete']==0);
    if ($can){
        if ($_SERVER['REQUEST_METHOD']==='POST'){
            if (csrf_check()){
                $msg = 'Сообщение удалено';
                $stmt = mysqli_prepare($connect, "UPDATE `api_forum_post` SET `text` = ?, `delete` = 1, `delete_time` = ? WHERE `id` = ? LIMIT 1");
                $pid = intval($post['id']);
                mysqli_stmt_bind_param($stmt,'sii',$msg,$time,$pid);
                mysqli_stmt_execute($stmt);
                header("Location: theme.php?id=".$theme_id);
                exit;
            } else {
                require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
                echo "<div class='erors'><center>Неверный CSRF-токен</center></div>\n";
                require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
                exit;
            }
        } else {
            require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
            echo "<div class='apicms_subhead'><center>Подтвердите удаление сообщения</center></div>";
            echo "<form method='post' action='?id=".$post_id."&theme=".$theme_id."'>";
            echo "<input type='hidden' name='csrf_token' value='".htmlspecialchars(csrf_token())."' />";
            echo "<div class='apicms_subhead'><center><input type='submit' value='Удалить' /></center></div>";
            echo "</form>";
            require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
            exit;
        }
    }
}
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
echo "<div class='erors'>Ошибка удаления</div>\n";
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>
