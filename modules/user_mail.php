<?


/////////////////////////////////////////
$title = 'Приватная почта';
require_once '../api_core/apicms_system.php';
require_once '../design/styles/'.htmlspecialchars($api_design).'/head.php';
/////////////////////////////////////////

if (!isset($_GET['id'])){header("Location: /");exit;}
$ank = intval($_GET['id']);
if (!$ank){header("Location: /");exit;}
global $connect;
$ank=mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '".intval($ank)."' LIMIT 1"));
if ($user['id']==$ank['id']){header("Location: /");exit;}

mysqli_query($connect, "UPDATE `user_mail` SET `views` = '1' WHERE `id_recipient` = '".intval($user['id'])."' AND `id_sender` = '".intval($ank['id'])."'");

if (isset($_POST['txt'])){
$text = apicms_filter($_POST['txt']);
if (strlen($text)>1024)$err = '<div class="erors"><center>Очень длинное сообщение</center></div>';
if (strlen($text)<10)$err = '<div class="erors"><center>Короткое сообщение</center></div>';
if (!isset($err)){
mysqli_query($connect, "INSERT INTO `user_mail` (`txt`, `id_sender`, `id_recipient`, `time`) VALUES ('$text', '".intval($user['id'])."', '".intval($ank['id'])."', '$time')");
////////////////////////////////////
$plus_fishka = $user['fishka'] + $api_settings['fishka_mail'];
mysqli_query($connect, "UPDATE `users` SET `fishka` = '".intval($plus_fishka)."' WHERE `id` = '".intval($user['id'])."' LIMIT 1");
echo '<div class="erors">Сообщение успешно добавлено</div>';
}else{
apicms_error($err);
}
}

/////////////////////////////////////////
$k_post_result = mysqli_query($connect, "SELECT COUNT(*) as cnt FROM `user_mail` WHERE (`id_recipient` = '".intval($user['id'])."' AND `id_sender` = '".intval($ank['id'])."') OR (`id_recipient` = '".intval($ank['id'])."' AND `id_sender` = '".intval($user['id'])."')");
$k_post_row = mysqli_fetch_assoc($k_post_result);
$k_post = $k_post_row['cnt'];
$k_page=k_page($k_post,$api_settings['on_page']);
$page=page($k_page);
$start=$api_settings['on_page']*$page-$api_settings['on_page'];
if ($k_post==0)echo "<div class='erors'><center>Вы еще не вели диалогов</center></div>";
/////////////////////////////////////////
$qii=mysqli_query($connect, "SELECT * FROM `user_mail` WHERE (`id_recipient` = '".intval($user['id'])."' AND `id_sender` = '".intval($ank['id'])."') OR (`id_recipient` = '".intval($ank['id'])."' AND `id_sender` = '".intval($user['id'])."') ORDER BY time DESC LIMIT $start, ".$api_settings['on_page']);
while ($post_mail = mysqli_fetch_assoc($qii)){
$ank2=mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = ".intval($post_mail['id_sender'])." LIMIT 1"));
echo '<div class="apicms_subhead"><table width="100%" ><tr><td width="20%"><center>';
echo apicms_ava32($ank2['id']);
echo "</center></td><td width='80%'>".htmlspecialchars($ank2['login'])." ";
echo "<span style='float:right'> ".apicms_data($post_mail['time'])." ";
echo " </span>";
if ($post_mail['views']==0){
echo "</br><font color='red'> <b>".apicms_smiles(apicms_br(htmlspecialchars($post_mail['txt'])))."</b> </font></td></tr></table></div>";
}else{
echo "</br> <b>".apicms_smiles(apicms_br(htmlspecialchars($post_mail['txt'])))."</b></td></tr></table></div>";
}
}
/////////////////////////////////////////
if ($user['id']){
echo "<form action='/modules/user_mail.php?id=".$ank['id']."&ok' method='post'>";
echo "<div class='apicms_dialog'><center><textarea name='txt'></textarea><br />";
echo "<input type='submit' value='Добавить'/></form></center></div>";
}else{
echo "<div class='apicms_content'>Извините вы неможете писать  в почту</div>";
}
/////////////////////////////////////////
if ($k_page > 1){
echo '<div class="apicms_subhead"><center>';
str('/modules/user_mail.php?id='.$ank['id'].'&',$k_page,$page); // генерируем постраничную навигацию
echo '</center></div>';
}
require_once '../design/styles/'.htmlspecialchars($api_design).'/footer.php';
?>