<?


/////////////////////////////////////////
$title = 'Удаление';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
/////////////////////////////////////////
if ($user['level'] < 1) header('location: index.php');
global $connect;
if ($user['level'] >= 1){
$check_razdel = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `api_forum_razdel` WHERE `id` = '".intval($_GET['id'])."'");
$check_razdel_row = mysqli_fetch_assoc($check_razdel);
if (isset($_GET['id']) && $user['level']>=1 && $check_razdel_row['cnt']==1){
$post=mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `api_forum_razdel` WHERE `id` = '".intval($_GET['id'])."' LIMIT 1"));
mysqli_query($connect, "DELETE FROM `api_forum_razdel` WHERE `id` = '".intval($post['id'])."'");
header("Location: index.php");
}
}else{
echo '<div class="erors">Ошибка доступа</div>';
}
/////////////////////////////////////////
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>