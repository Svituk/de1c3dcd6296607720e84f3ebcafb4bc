<?

/////////////////////////////////////////
$title = 'Изменение пароля';
require_once '../api_core/apicms_system.php';
if (!isset($user['id']) || !$user['id']) { header('Location: /'); exit; }
if (isset($_POST['save'])){
    global $connect;
    $cur = isset($_POST['pass']) ? $_POST['pass'] : '';
    $p1 = isset($_POST['pass1']) ? $_POST['pass1'] : '';
    $p2 = isset($_POST['pass2']) ? $_POST['pass2'] : '';
    $ok_cur = false;
    if (strlen($user['pass']) >= 60){ $ok_cur = password_verify($cur, $user['pass']); }
    else { $ok_cur = (md5(md5($cur)) == $user['pass']); }
    if ($ok_cur && $p1!=='' && $p2!=='' && $p1===$p2){
        $pass = password_hash($p1, PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($connect, "UPDATE `users` SET `pass` = ? WHERE `id` = ? LIMIT 1");
        $uid = intval($user['id']);
        mysqli_stmt_bind_param($stmt, 'si', $pass, $uid);
        mysqli_stmt_execute($stmt);
        setcookie('userpass', '', time()-3600, '/', '', false, true);
        $msg = '<div class="apicms_content"><center>Пароль успешно изменен</center></div>';
    } else {
        $msg = '<div class="erors"><center>Одно из полей заполнено не верно</center></div>';
    }
}
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';

if (isset($msg)) echo $msg;
/////////////////////////////////////////
echo "<form method='post' action='?saves'>";
echo "<div class='apicms_subhead'>";
echo "Старый пароль: <br /> <input type='text' name='pass' value='' /><br />";
echo "Новый пароль: <br /> <input type='password' name='pass1' value='' /><br />";
echo "Подтверждение: <br /> <input type='password' name='pass2' value='' /><br />";
echo "<input type='hidden' name='csrf_token' value='".csrf_token()."' />";
echo "<input type='submit' name='save' value='Изменить' /></div></form>";
/////////////////////////////////////////
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>
