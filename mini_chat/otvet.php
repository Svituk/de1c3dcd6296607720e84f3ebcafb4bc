<?
$title = 'Ответ на сообщение';
require_once '../api_core/apicms_system.php';
global $connect;
$msg_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_id_target = isset($_GET['user']) ? intval($_GET['user']) : 0;
if ($msg_id<=0 || $user_id_target<=0){ header('Location: index.php'); exit; }
$ank = mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '".$user_id_target."' LIMIT 1"));
if (!$is_user){ header('Location: ../auth.php'); exit; }
if (!$ank){ header('Location: index.php'); exit; }
if ($user_id==$ank['id']){ header('Location: index.php'); exit; }
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['txt']) && trim($_POST['txt'])!==''){
    $text = apicms_filter($_POST['txt']);
    if (mb_strlen($text,'UTF-8')>1024) $err = '<div class="apicms_content"><center>Очень длинное сообщение</center></div>';
    if (mb_strlen($text,'UTF-8')<3) $err = '<div class="apicms_content"><center>Короткое сообщение</center></div>';
    $check_duplicate = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `mini_chat` WHERE `txt` = '".mysqli_real_escape_string($connect, $text)."'");
    $check_duplicate_row = $check_duplicate ? mysqli_fetch_assoc($check_duplicate) : array('cnt'=>0);
    if (intval($check_duplicate_row['cnt'])!=0) $err = '<div class="apicms_content"><center>Ваше сообщение повторяет преведущие!</center></div>';
    if (!isset($err)){
        mysqli_query($connect, "INSERT INTO `mini_chat` (`txt`, `id_user`, `time`) VALUES ('".mysqli_real_escape_string($connect,$text)."', '".$user_id."', '$time')");
        $plus_fishka = intval($user['fishka']) + intval(isset($api_settings['fishka_chat']) ? $api_settings['fishka_chat'] : 0);
        mysqli_query($connect, "UPDATE `users` SET `fishka` = '".$plus_fishka."' WHERE `id` = '".$user_id."' LIMIT 1");
        $systext = 'Вам ответили в мини-чате, перейдите в него что бы дать ответ пользователю '.(isset($ank['login'])?$ank['login']:'').'';
        mysqli_query($connect, "INSERT INTO `api_system` (`id_user`, `text`, `time`, `read`) VALUES ('".$user_id_target."', '".mysqli_real_escape_string($connect, $systext)."', '$time', '0')");
        header('Location: index.php');
        exit;
    } else {
        apicms_error($err);
    }
}
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
echo "<form action='?user=".$ank['id']."&id=".$msg_id."&ok' method='post'>";
echo "<div class='apicms_dialog'><center><textarea name='txt'>".htmlspecialchars($ank['login']).", </textarea><br />";
echo "<input type='submit' value='Ответить'/></form></center></div>";
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>
