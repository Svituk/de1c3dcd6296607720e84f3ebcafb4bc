<?php

/////////////////////////////////////////
$title = 'Закрытие темы';
require_once '../api_core/apicms_system.php';
/////////////////////////////////////////
global $connect;
$theme_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Redirects must happen before any output (head.php prints HTML). If user not logged in, redirect now.
if (!isset($user) || !$user){ header('Location: /index.php'); exit(); }

$check_theme = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `api_forum_theme` WHERE `id` = '".$theme_id."'");
$check_theme_row = mysqli_fetch_assoc($check_theme);
if ($theme_id && $check_theme_row['cnt']==1){
    $post = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `api_forum_theme` WHERE `id` = '".$theme_id."' LIMIT 1"));
    if ($post && $post['close']==0 && (isset($user['id']) && ($user['id'] == $post['id_user'] || $user['level']==1 || $user['level']==2))){
        if ($_SERVER['REQUEST_METHOD']==='POST'){
            if (csrf_check()){
                mysqli_query($connect, "UPDATE `api_forum_theme` SET `close` = '1' WHERE `id` = '".intval($post['id'])."' LIMIT 1");
                header('Location: theme.php?id=' . intval($theme_id));
                exit();
            } else {
                require_once '../design/styles/'.display_html($api_design).'/head.php';
                echo "<div class='erors'><center>Неверный CSRF-токен</center></div>";
                require_once '../design/styles/'.display_html($api_design).'/footer.php';
                exit();
            }
        } else {
            require_once '../design/styles/'.display_html($api_design).'/head.php';
            echo "<div class='apicms_subhead'><center>Подтвердите закрытие темы</center></div>";
            echo "<form method='post' action='?id=".$theme_id."'>";
            echo "<input type='hidden' name='csrf_token' value='".display_html(csrf_token())."' />";
            echo "<div class='apicms_subhead'><center><input type='submit' value='Закрыть' /></center></div>";
            echo "</form>";
            require_once '../design/styles/'.display_html($api_design).'/footer.php';
            exit();
        }
    }
}

// Now include head and render page if we didn't redirect
require_once '../design/styles/'.display_html($api_design).'/head.php';
//////////////////////////////////////////
?>
