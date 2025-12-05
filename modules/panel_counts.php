<?php
require_once '../api_core/apicms_system.php';
header('Content-Type: application/json; charset=UTF-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
if (ob_get_level()) { while (ob_get_level()) { ob_end_clean(); } }
if (empty($user) || empty($user['id'])){ echo json_encode(['ok'=>0,'mail'=>0,'sys'=>0]); exit; }
global $connect;
$uid = intval($user['id']);
$q1 = mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(`id`) as cnt FROM `user_mail` WHERE `id_recipient` = '$uid' AND `views` = '0'"));
$q2 = mysqli_fetch_assoc(mysqli_query($connect, "SELECT COUNT(`id`) as cnt FROM `api_system` WHERE `id_user` = '$uid' AND `read` = '0'"));
$mail = $q1 ? intval($q1['cnt']) : 0;
$sys = $q2 ? intval($q2['cnt']) : 0;
echo json_encode(['ok'=>1,'mail'=>$mail,'sys'=>$sys]);
?>
