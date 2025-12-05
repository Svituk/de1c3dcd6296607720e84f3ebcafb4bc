<?

/////////////////////////////////////////
$title = 'Удаление сообщения в гостевой';
require_once '../api_core/apicms_system.php';
/////////////////////////////////////////
global $connect;
if ($user_level < 1) { header('Location: index.php'); exit; }
$post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$check_guest = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `guest` WHERE `id` = '".$post_id."'");
$check_guest_row = mysqli_fetch_assoc($check_guest);
if ($post_id && $check_guest_row && $check_guest_row['cnt']==1){
    if ($_SERVER['REQUEST_METHOD']==='POST'){
        if (csrf_check()){
            mysqli_query($connect, "DELETE FROM `guest` WHERE `id` = '".$post_id."'");
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
require_once '../design/styles/'.display_html($api_design).'/head.php';
echo "<div class='erors'><center>Ошибка удаления</center></div>";
require_once '../design/styles/'.display_html($api_design).'/footer.php';
//////////////////////////////////////////
?>
