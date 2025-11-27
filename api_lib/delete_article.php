<?


/////////////////////////////////////////
$title = 'Удаление статьи';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
/////////////////////////////////////////
global $connect;
$lib_id = intval($_GET['id']);
$raz_id = intval($_GET['raz']);
/////////////////////////////////////////
if (!isset($user)) header('location: index.php');
$check_article = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `api_lib_article` WHERE `id` = '".intval($_GET['id'])."'");
$check_article_row = mysqli_fetch_assoc($check_article);
if (isset($_GET['id']) && $user['level']==1 && $check_article_row['cnt']==1){
mysqli_query($connect, "DELETE FROM `api_lib_article` WHERE `id` = '$lib_id' LIMIT 1");
header("Location: article_list.php?id=".$raz_id."");
}else{
echo "<div class='erors'>Ошибка удаления статьи</div>\n";
}
//////////////////////////////////////////
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>