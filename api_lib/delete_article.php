<?


/////////////////////////////////////////
$title = 'Удаление статьи';
require_once '../api_core/apicms_system.php';
/////////////////////////////////////////
global $connect;
$lib_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$raz_id = isset($_GET['raz']) ? intval($_GET['raz']) : 0;
/////////////////////////////////////////
if (!$is_user) { header('Location: index.php'); exit; }
$row = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `api_lib_article` WHERE `id` = '".$lib_id."' LIMIT 1"));
if ($lib_id && $row){
    $owner_id = intval($row['id_user']);
    if ($user_level==1 || ($user_id && $user_id==$owner_id)){
        mysqli_query($connect, "DELETE FROM `api_lib_article` WHERE `id` = '$lib_id' LIMIT 1");
        header("Location: article_list.php?id=".$raz_id);
        exit;
    }
}
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
echo "<div class='erors'>Ошибка удаления статьи</div>\n";
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>
