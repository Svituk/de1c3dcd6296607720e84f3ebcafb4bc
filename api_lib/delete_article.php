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
    $can_delete = ($user_level==1 || ($user_id && $user_id==$owner_id));
    if ($can_delete){
        if ($_SERVER['REQUEST_METHOD']==='POST'){
            if (csrf_check()){
                mysqli_query($connect, "DELETE FROM `api_lib_article` WHERE `id` = '$lib_id' LIMIT 1");
                header("Location: article_list.php?id=".$raz_id);
                exit;
            } else {
                require_once '../design/styles/'.display_html($api_design).'/head.php';
                echo "<div class='erors'><center>Неверный CSRF-токен</center></div>\n";
                require_once '../design/styles/'.display_html($api_design).'/footer.php';
                exit;
            }
        } else {
            require_once '../design/styles/'.display_html($api_design).'/head.php';
            echo "<div class='apicms_subhead'><center>Подтвердите удаление статьи</center></div>";
            echo "<form method='post' action='?id=".$lib_id."&raz=".$raz_id."'>";
            echo "<input type='hidden' name='csrf_token' value='".display_html(csrf_token())."' />";
            echo "<div class='apicms_subhead'><center><input type='submit' value='Удалить' /></center></div>";
            echo "</form>";
            require_once '../design/styles/'.display_html($api_design).'/footer.php';
            exit;
        }
    }
}
require_once '../design/styles/'.display_html($api_design).'/head.php';
echo "<div class='erors'>Ошибка удаления статьи</div>\n";
require_once '../design/styles/'.display_html($api_design).'/footer.php';
?>
