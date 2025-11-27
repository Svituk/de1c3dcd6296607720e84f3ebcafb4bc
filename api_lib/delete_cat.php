<?


/////////////////////////////////////////
$title = 'Удаление раздела';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
/////////////////////////////////////////
global $connect;
$raz_id = intval($_GET['id']);
/////////////////////////////////////////
if (!isset($user)) header('location: index.php');
$check_cat = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `api_lib_cat` WHERE `id` = '".intval($_GET['id'])."'");
$check_cat_row = mysqli_fetch_assoc($check_cat);
if (isset($_GET['id']) && $user['level']==1 && $check_cat_row['cnt']==1){
mysqli_query($connect, "DELETE FROM `api_lib_cat` WHERE `id` = '$raz_id' LIMIT 1");
header("Location: index.php");
}else{
echo "<div class='erors'>Ошибка удаления раздела</div>\n";
}
//////////////////////////////////////////
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>