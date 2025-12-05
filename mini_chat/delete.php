<?

/////////////////////////////////////////
$title = 'Удаление сообщения в чате';
require_once '../api_core/apicms_system.php';
/////////////////////////////////////////
global $connect;
if ($user_level < 1) { header('Location: index.php'); exit; }

$post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt_c = mysqli_prepare($connect, "SELECT COUNT(*) as cnt FROM `mini_chat` WHERE `id` = ?");
mysqli_stmt_bind_param($stmt_c, 'i', $post_id);
mysqli_stmt_execute($stmt_c);
$res_c = mysqli_stmt_get_result($stmt_c);
$check_chat_row = mysqli_fetch_assoc($res_c);
mysqli_stmt_close($stmt_c);
if ($post_id && $check_chat_row && $check_chat_row['cnt']==1){
    if ($_SERVER['REQUEST_METHOD']==='POST'){
        if (csrf_check()){
            $stmt_d = mysqli_prepare($connect, "DELETE FROM `mini_chat` WHERE `id` = ?");
            mysqli_stmt_bind_param($stmt_d, 'i', $post_id);
            mysqli_stmt_execute($stmt_d);
            mysqli_stmt_close($stmt_d);
            header("Location: index.php");
            exit;
        } else {
            require_once '../design/styles/'.display_html($api_design).'/head.php';
            echo "<div class='erors'><center>Неверный CSRF-токен</center></div>";
            require_once '../design/styles/'.display_html($api_design).'/footer.php';
            exit;
        }
    } else {
        require_once '../design/styles/'.display_html($api_design).'/head.php';
        echo "<div class='apicms_subhead'><center>Подтвердите удаление сообщения</center></div>";
        echo "<form method='post' action='?id=".$post_id."'>";
        echo "<input type='hidden' name='csrf_token' value='".display_html(csrf_token())."' />";
        echo "<div class='apicms_subhead'><center><input type='submit' value='Удалить' /></center></div>";
        echo "</form>";
        require_once '../design/styles/'.display_html($api_design).'/footer.php';
        exit;
    }
}
//////////////////////////////////////////
?>
