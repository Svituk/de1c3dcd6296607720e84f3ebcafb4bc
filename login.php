<?php

require_once 'api_core/apicms_system.php';
////////////////////////////////////////
if (empty($_GET['log']) and empty($_GET['pas'])){
    $login = apicms_filter($_POST['login']);
    $raw = isset($_POST['pass']) ? $_POST['pass'] : '';
}else{
    $login = apicms_filter($_GET['log']);
    $raw = isset($_GET['pas']) ? $_GET['pas'] : '';
}
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
    if (strlen($hash) >= 60){ // password_hash
        $ok = password_verify($raw, $hash);
    } else {
        $ok = (md5(md5(apicms_filter($raw))) === $hash);
    }
    if ($ok){
        mysqli_query($connect, "UPDATE `users` SET `last_aut` = '".time()."', `ip` = '".apicms_filter($ip)."', `browser` = '".browser()."', `oc` = '".apicms_filter($oc)."' WHERE `id` = '".intval($row['id'])."' LIMIT 1");
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
