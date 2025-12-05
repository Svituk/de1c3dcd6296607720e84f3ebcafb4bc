<?
$title = 'Ответ';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.display_html($api_design).'/head.php';
/////////////////////////////////////////
global $connect;
$check_user = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `users` WHERE `id` = '".intval($_GET['user'])."'");
$check_user_row = mysqli_fetch_assoc($check_user);
if (isset($_GET['user']) && $user && $check_user_row['cnt']==1){
$ank = intval($_GET['user']);
$theme_id = intval($_GET['id']);
$subuser = mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$ank' LIMIT 1"));
if (isset($_POST['txt']) && csrf_check()){
$text = apicms_filter($_POST['txt']);
if (strlen($text)>1024)$err = '<div class="content"><center>Очень длинное сообщение</center></div>';
if (strlen($text)<3)$err = '<div class="content"><center>Короткое сообщение</center></div>';
if (!isset($err)){
$stmt = mysqli_prepare($connect, "INSERT INTO `api_forum_post` (`text`, `id_user`, `theme`, `time`) VALUES (?, ?, ?, ?)");
$user_id_val = intval($user['id']);
mysqli_stmt_bind_param($stmt, 'siii', $text, $user_id_val, $theme_id, $time);
apicms_stmt_execute($stmt);
if (mysqli_stmt_affected_rows($stmt) > 0){
    $plus_fishka = $user['fishka'] + $api_settings['fishka_forum'];///начисляем фишек
    $stmt2 = mysqli_prepare($connect, "UPDATE `users` SET `fishka` = ? WHERE `id` = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt2, 'ii', $plus_fishka, $user_id_val);
    apicms_stmt_execute($stmt2);
    mysqli_stmt_close($stmt2);
}
mysqli_stmt_close($stmt);
header("Location: theme.php?id=".$theme_id."&page=end");
}else{
apicms_error($err);
}
}
echo "<form action='reply.php?id=".$theme_id."&user=".$subuser['id']."&ok' method=\"post\">\n";
echo "<div class='apicms_dialog'><center><textarea name='txt'>".display_html($subuser['login']).", </textarea><br />\n";
echo "<input type='hidden' name='csrf_token' value='".display_html(csrf_token())."' />\n";
echo "<input type='submit' value='Ответить'/></form></center></div\n";
////////////////////////////////////////
}else{
echo "<div class='erors'>Ошибка выбора адресатов</div>\n";
}
/////////////////////////////////////////
require_once '../design/styles/'.display_html($api_design).'/footer.php';
?>
