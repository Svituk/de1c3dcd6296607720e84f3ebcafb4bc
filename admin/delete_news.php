<?


/////////////////////////////////////////
$title = 'Удаление новости сайта';
require_once '../api_core/apicms_system.php';
if (!function_exists('apicms_ob_started')){ ob_start(); function apicms_ob_started(){} }
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
/////////////////////////////////////////
if ($user['level'] != 1) header('location: index.php');
global $connect;
if ($user['level'] == 1 or $user['level'] == 2){
$check_news = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `news` WHERE `id` = '".intval($_GET['id'])."'");
$check_news_row = mysqli_fetch_assoc($check_news);
if (isset($_GET['id']) && $user['level']==1 && $check_news_row['cnt']==1){
$post=mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `news` WHERE `id` = '".intval($_GET['id'])."' LIMIT 1"));
mysqli_query($connect, "DELETE FROM `news` WHERE `id` = '".intval($post['id'])."'");
header("Location: add_news.php");
}
}
//////////////////////////////////////////
?>