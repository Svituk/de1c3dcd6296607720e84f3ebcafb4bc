<?


/////////////////////////////////////////
$title = 'Удаление';
require_once '../api_core/apicms_system.php';
/////////////////////////////////////////
global $connect;
if ($user_level < 1) { header('location: index.php'); exit; }
$subforum_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$check_subforum = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `api_forum_subforum` WHERE `id` = '".$subforum_id."'");
$check_subforum_row = mysqli_fetch_assoc($check_subforum);
if ($subforum_id && $check_subforum_row['cnt']==1){
    if ($_SERVER['REQUEST_METHOD']==='POST'){
        if (csrf_check()){
            mysqli_query($connect, "DELETE FROM `api_forum_subforum` WHERE `id` = '".$subforum_id."'");
            header("Location: index.php");
            exit;
        } else {
            require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
            echo "<div class='erors'><center>Неверный CSRF-токен</center></div>";
            require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
            exit;
        }
    } else {
        require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
        echo "<div class='apicms_subhead'><center>Подтвердите удаление подфорума</center></div>";
        echo "<form method='post' action='?id=".$subforum_id."'>";
        echo "<input type='hidden' name='csrf_token' value='".htmlspecialchars(csrf_token())."' />";
        echo "<div class='apicms_subhead'><center><input type='submit' value='Удалить' /></center></div>";
        echo "</form>";
        require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
        exit;
    }
}
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
echo '<div class="erors">Ошибка доступа</div>';
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>
