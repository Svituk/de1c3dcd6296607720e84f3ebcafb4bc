<?

///////////////////////////////////
require_once 'api_core/apicms_system.php';
/////////////////////////////////////
$title = ''.display_html(isset($user['login'])?$user['login']:'').'  заблокирован';
/////////////////////////////////////
if (!$user['id']) { header('Location: /'); exit; }
if (!isset($user['block_time']) || $user['block_time'] < time()){
    header('Location: /index.php');
    exit;
}
require_once 'design/styles/'.display_html($api_design).'/head.php';
global $connect;
$ban_row = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users_ban` WHERE `ank_ban` = '".intval($user['id'])."' AND `time` >= '".time()."' ORDER BY `time` DESC LIMIT 1"));
$ban_reason = $ban_row && isset($ban_row['prich']) ? display_html($ban_row['prich']) : '';
echo '<div class="apicms_content">';
echo '<center> <img src="/design/styles/'.display_html($api_design).'/images/ban.png" alt=""> </br> <strong>Ваш профиль заблокирован администрацией нашего сайта до '.apicms_data($user['block_time']).'</strong></br>'.($ban_reason!=='' ? '<br/>Причина: <b>'.$ban_reason.'</b>' : '').'</center>';
echo '</div>';
require_once 'design/styles/'.display_html($api_design).'/footer.php';
?>
