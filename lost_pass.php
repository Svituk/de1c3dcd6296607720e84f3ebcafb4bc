<?

/////////////////////////////////////////
$title = ' Восстановление пароля';
require_once 'api_core/apicms_system.php';
if (isset($user['id']) && $user['id']) { header('Location: /'); exit; }

global $connect;
$msg = '';
// Token-based reset flow
if (isset($_GET['token']) && isset($_GET['uid'])){
    $uid = intval($_GET['uid']);
    $token = apicms_filter($_GET['token']);
    $stmt0 = mysqli_prepare($connect, "SELECT `user_id`,`token`,`expires` FROM `password_resets` WHERE `user_id` = ? AND `token` = ? AND `expires` >= ? LIMIT 1");
    $now_t = time();
    mysqli_stmt_bind_param($stmt0,'isi',$uid,$token,$now_t);
    mysqli_stmt_execute($stmt0);
    $res0 = mysqli_stmt_get_result($stmt0);
    $row = mysqli_fetch_assoc($res0);
    mysqli_stmt_close($stmt0);
    if ($row && isset($_POST['newpass']) && isset($_POST['save']) && isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'])){
        $np = $_POST['newpass'];
        if (strlen($np) >= 8 && strlen($np) <= 64){
            $hash = password_hash($np, PASSWORD_DEFAULT);
            $stmt = mysqli_prepare($connect, "UPDATE `users` SET `pass` = ? WHERE `id` = ? LIMIT 1");
            mysqli_stmt_bind_param($stmt,'si',$hash,$uid);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            $del1 = mysqli_prepare($connect, "DELETE FROM `password_resets` WHERE `user_id` = ?");
            mysqli_stmt_bind_param($del1,'i',$uid);
            mysqli_stmt_execute($del1);
            mysqli_stmt_close($del1);
            $msg = '<div class="apicms_subhead"><center>Пароль успешно обновлён</center></div>';
        } else {
            $msg = '<div class="erors"><center>Пароль должен быть от 8 до 64 символов</center></div>';
        }
    }
}
if (!isset($_GET['token'])){
    $login = isset($_POST['login']) ? trim($_POST['login']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    if ($login !== '' && $email !== '' && isset($_POST['csrf_token']) && hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'])){
        $login_f = apicms_filter($login);
        $stmt1 = mysqli_prepare($connect, "SELECT `id`,`login`,`email` FROM `users` WHERE `login` = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt1,'s',$login_f);
        mysqli_stmt_execute($stmt1);
        $res1 = mysqli_stmt_get_result($stmt1);
        $qq = mysqli_fetch_assoc($res1);
        mysqli_stmt_close($stmt1);
        if ($qq && isset($qq['login']) && isset($qq['email']) && $qq['login'] === $login && $qq['email'] === $email){
            mysqli_query($connect, "CREATE TABLE IF NOT EXISTS `password_resets` ( `user_id` int NOT NULL, `token` varchar(64) NOT NULL, `expires` int NOT NULL, INDEX(`user_id`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8");
            $token = bin2hex(random_bytes(16));
            $exp = time()+1800;
            $del2 = mysqli_prepare($connect, "DELETE FROM `password_resets` WHERE `user_id` = ?");
            $uid = intval($qq['id']);
            mysqli_stmt_bind_param($del2,'i',$uid);
            mysqli_stmt_execute($del2);
            mysqli_stmt_close($del2);
            $stmt = mysqli_prepare($connect, "INSERT INTO `password_resets` (`user_id`,`token`,`expires`) VALUES (?,?,?)");
            mysqli_stmt_bind_param($stmt,'isi',$uid,$token,$exp);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            $email_from = !empty($api_settings['adm_mail']) ? $api_settings['adm_mail'] : ('no-reply@'.$set['site']);
            $reset_link = 'https://'.$set['site'].'/lost_pass.php?uid='.$uid.'&token='.$token;
            $message = 'Сброс пароля: перейдите по ссылке '.$reset_link.' (действует 30 минут).';
            $subject = 'Восстановление '.$set['site'];
            $encoded_subject = '=?UTF-8?B?'.base64_encode($subject).'?=';
            $headers = "MIME-Version: 1.0\r\nFrom: $email_from\r\nReply-To: $email_from\r\nContent-Type: text/plain; charset=UTF-8\r\nContent-Transfer-Encoding: 8bit\r\nX-Mailer: PHP";
            $sent = @mail($qq['email'], $encoded_subject, $message, $headers, '-f'.$email_from);
            if (!$sent) { $sent = @mail($qq['email'], $encoded_subject, $message, $headers); }
            $msg = $sent ? '<div class="apicms_subhead"><center>Ссылка для сброса пароля отправлена на e-mail '.display_html($qq['login']).'</center></div>' : '<div class="erors"><center>Не удалось отправить письмо</center></div>';
        } else {
            $msg = '<div class="erors"><center>Пользователь не найден или e-mail не совпадает</center></div>';
        }
    }
}

require_once 'design/styles/'.display_html($api_design).'/head.php';
if ($msg !== '') echo $msg;
if (!isset($_GET['token'])){
    echo "<form action='?okpass' method='post'><div class='apicms_content'>";
    echo "Логин:<br /> <input type='text' name='login' title='Логин' value='' maxlength='32' size='16' /><br />";
    echo "E-mail:<br /> <input type='text' name='email' title='E-mail' value='' maxlength='32' size='16' /><br />";
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    echo "<input type='hidden' name='csrf_token' value='".display_html($_SESSION['csrf_token'])."' />";
    echo "<input type='submit' value='Восстановление' title='Далее' /></div></form>";
} else {
    echo "<form action='?uid=".intval($_GET['uid'])."&token=".display_html($_GET['token'])."' method='post'><div class='apicms_content'>";
    echo "Новый пароль:<br /> <input type='password' name='newpass' maxlength='64' /><br />";
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    echo "<input type='hidden' name='csrf_token' value='".display_html($_SESSION['csrf_token'])."' />";
    echo "<input type='submit' name='save' value='Сменить пароль' /></div></form>";
}
require_once 'design/styles/'.display_html($api_design).'/footer.php';
?>
