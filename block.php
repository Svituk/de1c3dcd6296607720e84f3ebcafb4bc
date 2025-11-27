<?

///////////////////////////////////
require_once 'api_core/apicms_system.php';
///////////////////////////////////
$title = ''.$user['login'].'  заблокирован';
require_once 'design/styles/'.htmlspecialchars($api_design).'/head.php';
///////////////////////////////////
if (!$user['id']) header('location: /');
if (isset($user)){
echo '<div class="apicms_content">';
echo '<center> <img src="/design/styles/'.htmlspecialchars($api_design).'/images/ban.png" alt=""> </br> <strong>Ваш профиль заблокирован администрацией нашего сайта до '.apicms_data($user['block_time']).'</strong></br></center>';
echo '</div>';
}
///////////////////////////////////
require_once 'design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>
