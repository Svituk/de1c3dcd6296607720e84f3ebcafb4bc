<?php


/////////////////////////////////////////
$title = 'Удаление комментария к новости';
require_once '../api_core/apicms_system.php';
global $connect;
if ($user_level != 1) { header('location: index.php'); exit; }
$comm_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$check_comm = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `news_comm` WHERE `id` = '".$comm_id."'");
$check_comm_row = mysqli_fetch_assoc($check_comm);
if ($comm_id && $check_comm_row && $check_comm_row['cnt']==1){
    if ($_SERVER['REQUEST_METHOD']==='POST'){
        if (csrf_check()){
            mysqli_query($connect, "DELETE FROM `news_comm` WHERE `id` = '".$comm_id."'");
            header('Location: news_comm.php?id='.(isset($_GET['news'])?intval($_GET['news']):0));
            exit;
        } else {
            require_once '../design/styles/'.display_html($api_design).'/head.php';
            echo "<div class='erors'><center>Неверный CSRF-токен</center></div>";
            require_once '../design/styles/'.display_html($api_design).'/footer.php';
            exit;
        }
    } else {
        require_once '../design/styles/'.display_html($api_design).'/head.php';
        echo "<div class='apicms_subhead'><center>Подтвердите удаление комментария</center></div>";
        echo "<form method='post' action='?id=".$comm_id."&news=".(isset($_GET['news'])?intval($_GET['news']):0)."'>";
        echo "<input type='hidden' name='csrf_token' value='".display_html(csrf_token())."' />";
        echo "<div class='apicms_subhead'><center><input type='submit' value='Удалить' /></center></div>";
        echo "</form>";
        require_once '../design/styles/'.display_html($api_design).'/footer.php';
        exit;
    }
}
require_once '../design/styles/'.display_html($api_design).'/head.php';
echo "<div class='erors'><center>Ошибка удаления</center></div>";
require_once '../design/styles/'.display_html($api_design).'/footer.php';
?>
