<?


/////////////////////////////////////////
$title = 'Удаление новости сайта';
require_once '../api_core/apicms_system.php';
if (!function_exists('apicms_ob_started')){ ob_start(); function apicms_ob_started(){} }
require_once '../design/styles/'.display_html($api_design).'/head.php';
/////////////////////////////////////////
if ($user['level'] != 1) header('location: index.php');
global $connect;
if ($user['level'] == 1){
    $nid = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $check_news = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `news` WHERE `id` = '".$nid."'");
    $check_news_row = mysqli_fetch_assoc($check_news);
    if ($nid && $check_news_row['cnt']==1){
        if ($_SERVER['REQUEST_METHOD']==='POST'){
            if (csrf_check()){
                mysqli_query($connect, "DELETE FROM `news` WHERE `id` = '".$nid."'");
                header("Location: add_news.php");
                exit;
            } else {
                echo "<div class='erors'><center>Неверный CSRF-токен</center></div>";
            }
        } else {
            echo "<div class='apicms_subhead'><center>Подтвердите удаление новости</center></div>";
            echo "<form method='post' action='?id=".$nid."'>";
            echo "<input type='hidden' name='csrf_token' value='".display_html(csrf_token())."' />";
            echo "<div class='apicms_subhead'><center><input type='submit' value='Удалить' /></center></div>";
            echo "</form>";
        }
    }
}
//////////////////////////////////////////
?>
