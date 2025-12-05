<?

///////////////////////////////////
$title = 'Активация почты';
require_once 'api_core/apicms_system.php';
///////////////////////////////////
if (!isset($user) && !isset($_GET['log'])){header("Location: /index.php?");exit;}
if (isset($_GET['log']))$ank['login'] = apicms_filter($_GET['log']);
if (isset($_GET['code']))$myactivate = apicms_filter($_GET['code']);
global $connect;
$ank=mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '".mysqli_real_escape_string($connect, $ank['login'])."' LIMIT 1"));
///////////////////////////////////
require_once 'design/styles/'.display_html($api_design).'/head.php';
if ($user['activ_mail']!=1){
$k2_post_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `users`  WHERE `login` = '".mysqli_real_escape_string($connect, $ank['login'])."' AND `activ_mail` = '".mysqli_real_escape_string($connect, $myactivate)."'");
$k2_post_row = mysqli_fetch_assoc($k2_post_result);
$k2_post = $k2_post_row['cnt'];
if (isset($_GET['log']) && isset($_GET['code'])){

if ($k2_post==0)echo "<div class='erors'>Активация провалена, возможно не верно указаны данные!</div>\n";

if ($k2_post!=0){
mysqli_query($connect, "UPDATE `users` SET `activ_mail` = '1' WHERE `login` = '".mysqli_real_escape_string($connect, $ank['login'])."' LIMIT 1");
echo "<div class='erors'>Активация почтового аккаунта выполнена! Перейдите на главную страницу сайта.</div>\n";
}
}

echo '<div class="apicms_subhead"><center><strong><img src="/design/styles/'.display_html($api_design).'/images/no_act_mail.png" alt=""> </center></div><div class="erors"> Система APICMS ожидает активацию почты, если вам не пришло письмо с кодом активации пожалуйста обратитесь в службу поддержки данного сайта или на e-mail администратора '.display_html($api_settings['adm_mail']).'</strong></br></div>';
}else{
echo "<div class='erors'>Ожидается активация почтового ящика или ваш аккаунт уже подтвержден!</div>\n";
}
///////////////////////////////////
require_once 'design/styles/'.display_html($api_design).'/footer.php';
?>
