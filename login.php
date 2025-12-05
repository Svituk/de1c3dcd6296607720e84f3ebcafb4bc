<?php

require_once 'api_core/apicms_system.php';
////////////////////////////////////////
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_check()){
    header('location: auth.php?error');
    exit;
}
$login = apicms_filter(isset($_POST['login']) ? $_POST['login'] : '');
$raw = isset($_POST['pass']) ? $_POST['pass'] : '';
////////////////////////////////////////
global $connect;
// fetch user
$stmt = mysqli_prepare($connect, "SELECT `id`,`login`,`pass` FROM `users` WHERE `login` = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, 's', $login);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($res);
if ($row){
    $ok = false;
    $hash = $row['pass'];
    if (preg_match('/^\$2[aby]\$/', $hash) || strlen($hash) >= 60){
        $ok = password_verify($raw, $hash);
    } else {
        $ok = (md5(md5(apicms_filter($raw))) === $hash);
    }
    if ($ok){
        $update_time = time();
        $ip_val = apicms_filter($ip);
        $browser_val = browser();
        $oc_val = apicms_filter($oc);
        $user_id_val = intval($row['id']);
        $stmt = mysqli_prepare($connect, "UPDATE `users` SET `last_aut` = ?, `ip` = ?, `browser` = ?, `oc` = ? WHERE `id` = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, 'isssi', $update_time, $ip_val, $browser_val, $oc_val, $user_id_val);
        apicms_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $_SESSION['uid'] = intval($row['id']);
        setcookie('userlogin', '', time() - 3600, '/', '', false, true);
        setcookie('userpass',  '', time() - 3600, '/', '', false, true);
        header('location: index.php');
        exit;
    }
}
header('location: auth.php?error');
////////////////////////////////////////
?>
