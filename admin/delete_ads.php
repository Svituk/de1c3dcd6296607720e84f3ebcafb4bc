<?


/////////////////////////////////////////
$title = 'Удаление рекламной ссылки';
require_once '../api_core/apicms_system.php';
if (!function_exists('apicms_ob_started')){ ob_start(); function apicms_ob_started(){} }
require_once '../design/styles/'.display_html($api_design).'/head.php';
/////////////////////////////////////////
if ($user['level'] != 1) header('location: index.php');
global $connect;
if ($user['level'] == 1){
    $aid = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $check_ads = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `advertising` WHERE `id` = '".$aid."'");
    $check_ads_row = mysqli_fetch_assoc($check_ads);
    if ($aid && $check_ads_row['cnt']==1){
        if ($_SERVER['REQUEST_METHOD']==='POST'){
            if (csrf_check()){
                mysqli_query($connect, "DELETE FROM `advertising` WHERE `id` = '".$aid."'");
                header("Location: ads.php");
                exit;
            } else {
                echo "<div class='erors'><center>Неверный CSRF-токен</center></div>";
            }
        } else {
            echo "<div class='apicms_subhead'><center>Подтвердите удаление рекламной записи</center></div>";
            echo "<form method='post' action='?id=".$aid."'>";
            echo "<input type='hidden' name='csrf_token' value='".display_html(csrf_token())."' />";
            echo "<div class='apicms_subhead'><center><input type='submit' value='Удалить' /></center></div>";
            echo "</form>";
        }
    }
}
//////////////////////////////////////////
?>
