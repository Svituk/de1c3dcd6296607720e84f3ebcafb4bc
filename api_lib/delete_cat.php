<?


/////////////////////////////////////////
$title = 'Удаление раздела';
require_once '../api_core/apicms_system.php';
global $connect;
$raz_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$is_user || $user_level!=1 || !$raz_id){ header('Location: index.php'); exit; }
$check_cat = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `api_lib_cat` WHERE `id` = '".$raz_id."'");
$check_cat_row = mysqli_fetch_assoc($check_cat);
if ($check_cat_row && $check_cat_row['cnt']==1){
    mysqli_query($connect, "DELETE FROM `api_lib_cat` WHERE `id` = '$raz_id' LIMIT 1");
    header("Location: index.php");
    exit;
}
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
echo "<div class='erors'>Ошибка удаления раздела</div>\n";
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>
