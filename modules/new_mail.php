<?


/////////////////////////////////////////
$title = 'Приватная почта';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
/////////////////////////////////////////

/////////////////////////////////////////
global $connect;
$k_post_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `user_mail` WHERE `id_recipient` = '".intval($user['id'])."' AND `views` = '0'");
$k_post_row = mysqli_fetch_assoc($k_post_result);
$k_post = $k_post_row['cnt'];
$k_page=k_page($k_post,$api_settings['on_page']);
$page=page($k_page);
$start=$api_settings['on_page']*$page-$api_settings['on_page'];
if ($k_post==0)echo "<div class='erors'><center>Для вас нет сообщений</center></div>";
/////////////////////////////////////////
$qii=mysqli_query($connect, "SELECT * FROM `user_mail` WHERE `id_recipient` = '".intval($user['id'])."' AND `views` = '0' ORDER BY time DESC LIMIT $start, ".$api_settings['on_page']);
while ($post_mail = mysqli_fetch_assoc($qii)){
$ank2=mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = ".intval($post_mail['id_sender'])." LIMIT 1"));
echo '<div class="apicms_subhead"><table width="100%" ><tr><td width="20%"><center>';
echo apicms_ava32($ank2['id']);
echo "</center></td><td width='80%'>Отправитель: ".htmlspecialchars($ank2['login'])." ";
echo "<span style='float:right'> ".apicms_data($post_mail['time'])." ";
echo " </span>";
echo " </br></br><a class = 'headbut' href='/modules/user_mail.php?id=".$ank2['id']."'>Перейти к диалогам</a> </td></tr></table></div>";
}
if ($k_page > 1){
echo '<div class="apicms_subhead"><center>';
str('/modules/new_mail.php?id='.$ank['id'].'&',$k_page,$page); // генерируем постраничную навигацию
echo '</center></div>';
}
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>