<?
$title = 'Ответ на сообщение';
require_once '../api_core/apicms_system.php';


global $connect;
$msg_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_id_target = isset($_GET['user']) ? intval($_GET['user']) : 0;
if ($msg_id<=0 || $user_id_target<=0){ header('Location: index.php'); exit; }
$stmt_ank = mysqli_prepare($connect, "SELECT `id`,`login`,`fishka` FROM `users` WHERE `id` = ? LIMIT 1");
mysqli_stmt_bind_param($stmt_ank, 'i', $user_id_target);
mysqli_stmt_execute($stmt_ank);
$res_ank = mysqli_stmt_get_result($stmt_ank);
$ank = mysqli_fetch_array($res_ank);
mysqli_stmt_close($stmt_ank);
if (!$is_user){ header('Location: ../auth.php'); exit; }
if (!$ank){ header('Location: index.php'); exit; }
if ($user_id==$ank['id']){ header('Location: index.php'); exit; }
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['txt']) && trim($_POST['txt'])!==''){
    if (!csrf_check()){
        apicms_error('<div class="apicms_content"><center>Неверный CSRF-токен</center></div>');
    } else {
    $raw = isset($_POST['txt']) ? $_POST['txt'] : '';
    $text = apicms_filter($raw);
    $len = mb_strlen($text, 'UTF-8');
    if ($len > 1024) $err = '<div class="apicms_content"><center>Очень длинное сообщение</center></div>';
    if ($len < 3) $err = '<div class="apicms_content"><center>Короткое сообщение</center></div>';
    if (!isset($err)){
        $text_escaped = $text;
        $stmt_dup = mysqli_prepare($connect, "SELECT COUNT(*) as cnt FROM `mini_chat` WHERE `txt` = ?");
        mysqli_stmt_bind_param($stmt_dup, 's', $text_escaped);
        mysqli_stmt_execute($stmt_dup);
        $res_dup = mysqli_stmt_get_result($stmt_dup);
        $check_duplicate_row = $res_dup ? mysqli_fetch_assoc($res_dup) : array('cnt'=>0);
        mysqli_stmt_close($stmt_dup);
        if (intval($check_duplicate_row['cnt'])!=0) $err = '<div class="apicms_content"><center>Ваше сообщение повторяет преведущие!</center></div>';
    }
    if (!isset($err)){
        $stmt_ins = mysqli_prepare($connect, "INSERT INTO `mini_chat` (`txt`, `id_user`, `time`) VALUES (?,?,?)");
        $uid_cur = intval($user_id);
        mysqli_stmt_bind_param($stmt_ins, 'sii', $text_escaped, $uid_cur, $time);
        mysqli_stmt_execute($stmt_ins);
        mysqli_stmt_close($stmt_ins);
        $plus_fishka = intval($user['fishka']) + intval(isset($api_settings['fishka_chat']) ? $api_settings['fishka_chat'] : 0);
        $stmt_upd = mysqli_prepare($connect, "UPDATE `users` SET `fishka` = ? WHERE `id` = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt_upd, 'ii', $plus_fishka, $uid_cur);
        mysqli_stmt_execute($stmt_upd);
        mysqli_stmt_close($stmt_upd);
        $systext = 'Вам ответили в мини-чате, перейдите в него что бы дать ответ пользователю '.(isset($ank['login'])?$ank['login']:'').'';
        $stmt_sys = mysqli_prepare($connect, "INSERT INTO `api_system` (`id_user`, `text`, `time`, `read`) VALUES (?,?,?,0)");
        mysqli_stmt_bind_param($stmt_sys, 'isi', $user_id_target, $systext, $time);
        mysqli_stmt_execute($stmt_sys);
        mysqli_stmt_close($stmt_sys);
        header('Location: index.php');
        exit;
    } else {
        apicms_error($err);
    }
    }
}
require_once '../design/styles/'.display_html($api_design).'/head.php';
echo "<form action='?user=".$ank['id']."&id=".$msg_id."&ok' method='post'>";
echo "<div class='apicms_dialog'><center><textarea name='txt'>".display_html($ank['login']).", </textarea><br />";
echo "<input type='hidden' name='csrf_token' value='".display_html(csrf_token())."' />";
echo "<input type='submit' value='Ответить'/></form></center></div>";
require_once '../design/styles/'.display_html($api_design).'/footer.php';
?>
